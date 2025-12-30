<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\EmailService;
use Config\OAuth;
use CodeIgniter\HTTP\Client;

class Auth extends BaseController
{
    protected $userModel;
    protected $oauthConfig;
    protected $emailService;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->oauthConfig = new OAuth();
        $this->emailService = new EmailService();
    }

    public function login()
    {
        if (session()->has('user_id')) {
            return redirect()->to('/dashboard');
        }

        return $this->render('auth/login', []);
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password');
        }

        // Check if user is OAuth-only (no password)
        if (empty($user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'This account was created with social login. Please use Google or Facebook to sign in.');
        }

        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password');
        }

        // Check email verification (skip for OAuth users)
        if (empty($user['provider']) && !$user['email_verified']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Please verify your email address before logging in. <a href="' . base_url('auth/resend-verification') . '">Resend verification email</a>');
        }

        session()->set([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'first_name' => $user['first_name'],
        ]);

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin');
        }

        return redirect()->to('/dashboard');
    }

    public function register()
    {
        if (session()->has('user_id')) {
            return redirect()->to('/dashboard');
        }

        return $this->render('auth/register', []);
    }

    public function attemptRegister()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Generate email verification token
        $verificationToken = bin2hex(random_bytes(32));
        $verificationExpires = date('Y-m-d H:i:s', strtotime('+24 hours'));

        $data = [
            'username'   => $this->request->getPost('username'),
            'email'      => $this->request->getPost('email'),
            'password'   => $this->request->getPost('password'),
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'role'       => 'student',
            'email_verified' => 0,
            'email_verification_token' => $verificationToken,
            'email_verification_token_expires' => $verificationExpires,
        ];

        $userId = $this->userModel->insert($data);

        if ($userId) {
            $user = $this->userModel->find($userId);
            
            // Send verification email
            $userName = $user['first_name'] ?: $user['username'];
            $emailSent = $this->emailService->sendVerificationEmail(
                $user['email'],
                $userName,
                $verificationToken
            );

            if (!$emailSent) {
                // Log email error but don't fail registration
                log_message('error', 'Failed to send verification email to: ' . $user['email']);
            }

            // Don't auto-login, require email verification first
            return redirect()->to('/auth/login')
                ->with('success', 'Registration successful! Please check your email to verify your account before logging in.');
        }

        return redirect()->back()
            ->withInput()
            ->with('error', 'Registration failed. Please try again.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }

    /**
     * Verify email address
     */
    public function verifyEmail($token)
    {
        if (empty($token)) {
            return redirect()->to('/auth/login')
                ->with('error', 'Invalid verification token.');
        }

        $user = $this->userModel
            ->where('email_verification_token', $token)
            ->where('email_verification_token_expires >', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            return redirect()->to('/auth/login')
                ->with('error', 'Invalid or expired verification token. Please request a new verification email.');
        }

        // Verify the email
        $this->userModel->update($user['id'], [
            'email_verified' => 1,
            'email_verification_token' => null,
            'email_verification_token_expires' => null,
        ]);

        return redirect()->to('/auth/login')
            ->with('success', 'Email verified successfully! You can now log in.');
    }

    /**
     * Show forgot password form
     */
    public function forgotPassword()
    {
        if (session()->has('user_id')) {
            return redirect()->to('/dashboard');
        }

        return $this->render('auth/forgot_password', []);
    }

    /**
     * Process password reset request
     */
    public function requestPasswordReset()
    {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        // Always show success message for security (don't reveal if email exists)
        if ($user && empty($user['provider'])) {
            // Generate password reset token
            $resetToken = bin2hex(random_bytes(32));
            $resetExpires = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $this->userModel->update($user['id'], [
                'password_reset_token' => $resetToken,
                'password_reset_token_expires' => $resetExpires,
            ]);

            // Send password reset email
            $userName = $user['first_name'] ?: $user['username'];
            $this->emailService->sendPasswordResetEmail(
                $user['email'],
                $userName,
                $resetToken
            );
        }

        return redirect()->to('/auth/login')
            ->with('success', 'If an account exists with that email, a password reset link has been sent.');
    }

    /**
     * Show reset password form
     */
    public function resetPassword($token)
    {
        if (session()->has('user_id')) {
            return redirect()->to('/dashboard');
        }

        if (empty($token)) {
            return redirect()->to('/auth/login')
                ->with('error', 'Invalid reset token.');
        }

        $user = $this->userModel
            ->where('password_reset_token', $token)
            ->where('password_reset_token_expires >', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            return redirect()->to('/auth/login')
                ->with('error', 'Invalid or expired reset token.');
        }

        return $this->render('auth/reset_password', ['token' => $token]);
    }

    /**
     * Process password reset
     */
    public function processPasswordReset()
    {
        $rules = [
            'token' => 'required',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        $user = $this->userModel
            ->where('password_reset_token', $token)
            ->where('password_reset_token_expires >', date('Y-m-d H:i:s'))
            ->first();

        if (!$user) {
            return redirect()->to('/auth/login')
                ->with('error', 'Invalid or expired reset token.');
        }

        // Update password and clear reset token
        $this->userModel->update($user['id'], [
            'password' => $password,
            'password_reset_token' => null,
            'password_reset_token_expires' => null,
        ]);

        return redirect()->to('/auth/login')
            ->with('success', 'Password reset successfully! You can now log in with your new password.');
    }

    /**
     * Resend verification email
     */
    public function resendVerification()
    {
        if (session()->has('user_id')) {
            return redirect()->to('/dashboard');
        }

        return $this->render('auth/resend_verification', []);
    }

    /**
     * Process resend verification request
     */
    public function processResendVerification()
    {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        // Always show success message for security
        if ($user && !$user['email_verified'] && empty($user['provider'])) {
            // Generate new verification token
            $verificationToken = bin2hex(random_bytes(32));
            $verificationExpires = date('Y-m-d H:i:s', strtotime('+24 hours'));

            $this->userModel->update($user['id'], [
                'email_verification_token' => $verificationToken,
                'email_verification_token_expires' => $verificationExpires,
            ]);

            // Send verification email
            $userName = $user['first_name'] ?: $user['username'];
            $this->emailService->sendVerificationEmail(
                $user['email'],
                $userName,
                $verificationToken
            );
        }

        return redirect()->to('/auth/login')
            ->with('success', 'If an account exists with that email and is not verified, a verification email has been sent.');
    }

    /**
     * Redirect to Google OAuth
     */
    public function google()
    {
        if (session()->has('user_id')) {
            return redirect()->to('/dashboard');
        }

        $clientId = $this->oauthConfig->googleClientId;
        $redirectUri = $this->oauthConfig->getGoogleRedirectUri();

        if (empty($clientId)) {
            return redirect()->to('/auth/login')
                ->with('error', 'Google OAuth is not configured. Please contact administrator.');
        }

        // Generate state for CSRF protection
        $state = bin2hex(random_bytes(16));
        session()->set('oauth_state', $state);

        $params = [
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'state'         => $state,
            'access_type'   => 'online',
        ];

        $authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
        return redirect()->to($authUrl);
    }

    /**
     * Google OAuth callback
     */
    public function googleCallback()
    {
        $code = $this->request->getGet('code');
        $state = $this->request->getGet('state');
        $error = $this->request->getGet('error');

        if ($error) {
            return redirect()->to('/auth/login')
                ->with('error', 'Google login cancelled or failed.');
        }

        // Verify state
        $sessionState = session()->get('oauth_state');
        if (!$state || $state !== $sessionState) {
            return redirect()->to('/auth/login')
                ->with('error', 'Invalid OAuth state. Please try again.');
        }
        session()->remove('oauth_state');

        if (!$code) {
            return redirect()->to('/auth/login')
                ->with('error', 'No authorization code received from Google.');
        }

        // Exchange code for access token
        $client = \Config\Services::curlrequest();
        $tokenResponse = $client->request('POST', 'https://oauth2.googleapis.com/token', [
            'form_params' => [
                'code'          => $code,
                'client_id'     => $this->oauthConfig->googleClientId,
                'client_secret' => $this->oauthConfig->googleClientSecret,
                'redirect_uri'  => $this->oauthConfig->getGoogleRedirectUri(),
                'grant_type'    => 'authorization_code',
            ],
        ]);

        $tokenData = json_decode($tokenResponse->getBody(), true);

        if (!isset($tokenData['access_token'])) {
            return redirect()->to('/auth/login')
                ->with('error', 'Failed to get access token from Google.');
        }

        // Get user info from Google
        $userInfoResponse = $client->request('GET', 'https://www.googleapis.com/oauth2/v2/userinfo', [
            'headers' => [
                'Authorization' => 'Bearer ' . $tokenData['access_token'],
            ],
        ]);

        $userInfo = json_decode($userInfoResponse->getBody(), true);

        if (!isset($userInfo['email'])) {
            return redirect()->to('/auth/login')
                ->with('error', 'Failed to get user information from Google.');
        }

        return $this->handleOAuthUser('google', $userInfo);
    }

    /**
     * Redirect to Facebook OAuth
     */
    public function facebook()
    {
        if (session()->has('user_id')) {
            return redirect()->to('/dashboard');
        }

        $appId = $this->oauthConfig->facebookAppId;
        $redirectUri = $this->oauthConfig->getFacebookRedirectUri();

        if (empty($appId)) {
            return redirect()->to('/auth/login')
                ->with('error', 'Facebook OAuth is not configured. Please contact administrator.');
        }

        // Generate state for CSRF protection
        $state = bin2hex(random_bytes(16));
        session()->set('oauth_state', $state);

        $params = [
            'client_id'     => $appId,
            'redirect_uri'  => $redirectUri,
            'state'         => $state,
            'scope'         => 'email,public_profile',
            'response_type' => 'code',
        ];

        $authUrl = 'https://www.facebook.com/v18.0/dialog/oauth?' . http_build_query($params);
        return redirect()->to($authUrl);
    }

    /**
     * Facebook OAuth callback
     */
    public function facebookCallback()
    {
        $code = $this->request->getGet('code');
        $state = $this->request->getGet('state');
        $error = $this->request->getGet('error');

        if ($error) {
            return redirect()->to('/auth/login')
                ->with('error', 'Facebook login cancelled or failed.');
        }

        // Verify state
        $sessionState = session()->get('oauth_state');
        if (!$state || $state !== $sessionState) {
            return redirect()->to('/auth/login')
                ->with('error', 'Invalid OAuth state. Please try again.');
        }
        session()->remove('oauth_state');

        if (!$code) {
            return redirect()->to('/auth/login')
                ->with('error', 'No authorization code received from Facebook.');
        }

        // Exchange code for access token
        $client = \Config\Services::curlrequest();
        $tokenUrl = 'https://graph.facebook.com/v18.0/oauth/access_token?' . http_build_query([
            'client_id'     => $this->oauthConfig->facebookAppId,
            'client_secret' => $this->oauthConfig->facebookAppSecret,
            'redirect_uri'  => $this->oauthConfig->getFacebookRedirectUri(),
            'code'          => $code,
        ]);

        $tokenResponse = $client->request('GET', $tokenUrl);
        $tokenData = json_decode($tokenResponse->getBody(), true);

        if (!isset($tokenData['access_token'])) {
            return redirect()->to('/auth/login')
                ->with('error', 'Failed to get access token from Facebook.');
        }

        // Get user info from Facebook
        $userInfoUrl = 'https://graph.facebook.com/v18.0/me?' . http_build_query([
            'fields'       => 'id,name,email,first_name,last_name,picture',
            'access_token' => $tokenData['access_token'],
        ]);

        $userInfoResponse = $client->request('GET', $userInfoUrl);
        $userInfo = json_decode($userInfoResponse->getBody(), true);

        if (!isset($userInfo['email'])) {
            return redirect()->to('/auth/login')
                ->with('error', 'Failed to get user information from Facebook. Please ensure email permission is granted.');
        }

        // Normalize Facebook user data
        $normalizedUserInfo = [
            'id'         => $userInfo['id'],
            'email'      => $userInfo['email'],
            'first_name' => $userInfo['first_name'] ?? '',
            'last_name'  => $userInfo['last_name'] ?? '',
            'name'       => $userInfo['name'] ?? '',
            'picture'    => $userInfo['picture']['data']['url'] ?? null,
        ];

        return $this->handleOAuthUser('facebook', $normalizedUserInfo);
    }

    /**
     * Handle OAuth user login/registration
     */
    protected function handleOAuthUser(string $provider, array $userInfo)
    {
        $providerId = $userInfo['id'];
        $email = $userInfo['email'];

        // Check if user exists by provider and provider_id
        $user = $this->userModel
            ->where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();

        // If not found, check by email
        if (!$user) {
            $user = $this->userModel->where('email', $email)->first();

            if ($user) {
                // Update existing user with OAuth info
                $this->userModel->update($user['id'], [
                    'provider'   => $provider,
                    'provider_id' => $providerId,
                    'avatar'     => $userInfo['picture'] ?? null,
                ]);
                $user = $this->userModel->find($user['id']);
            } else {
                // Create new user
                $nameParts = explode(' ', $userInfo['name'] ?? '', 2);
                $firstName = $userInfo['first_name'] ?? ($nameParts[0] ?? '');
                $lastName = $userInfo['last_name'] ?? ($nameParts[1] ?? '');

                // Generate username from email
                $username = explode('@', $email)[0];
                $baseUsername = $username;
                $counter = 1;
                while ($this->userModel->where('username', $username)->first()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }

                $userId = $this->userModel->insert([
                    'username'    => $username,
                    'email'       => $email,
                    'first_name'  => $firstName,
                    'last_name'   => $lastName,
                    'provider'    => $provider,
                    'provider_id' => $providerId,
                    'avatar'      => $userInfo['picture'] ?? null,
                    'role'        => 'student',
                    'email_verified' => 1,
                    'password'    => null, // No password for OAuth users
                ]);

                if (!$userId) {
                    return redirect()->to('/auth/login')
                        ->with('error', 'Failed to create account. Please try again.');
                }

                $user = $this->userModel->find($userId);
            }
        }

        // Update avatar if available
        if (isset($userInfo['picture']) && empty($user['avatar'])) {
            $this->userModel->update($user['id'], [
                'avatar' => $userInfo['picture'],
            ]);
        }

        // Set session
        session()->set([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'email'      => $user['email'],
            'role'       => $user['role'],
            'first_name' => $user['first_name'],
        ]);

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin')
                ->with('success', 'Successfully logged in with ' . ucfirst($provider) . '!');
        }

        return redirect()->to('/dashboard')
            ->with('success', 'Successfully logged in with ' . ucfirst($provider) . '!');
    }
}

