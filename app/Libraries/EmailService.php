<?php

namespace App\Libraries;

use CodeIgniter\Email\Email;
use Config\Email as EmailConfig;

class EmailService
{
    protected $email;
    protected $config;

    public function __construct()
    {
        $this->config = new EmailConfig();
        $this->email = \Config\Services::email();
    }

    /**
     * Send email verification email
     *
     * @param string $toEmail
     * @param string $toName
     * @param string $verificationToken
     * @return bool
     */
    public function sendVerificationEmail(string $toEmail, string $toName, string $verificationToken): bool
    {
        $verificationUrl = base_url('auth/verify-email/' . $verificationToken);

        $message = view('emails/verification', [
            'name' => $toName,
            'verificationUrl' => $verificationUrl,
        ]);

        $this->email->setFrom($this->config->fromEmail, $this->config->fromName);
        $this->email->setTo($toEmail);
        $this->email->setSubject('Verify Your Email Address - bandhanhara learning');
        $this->email->setMessage($message);

        return $this->email->send();
    }

    /**
     * Send password reset email
     *
     * @param string $toEmail
     * @param string $toName
     * @param string $resetToken
     * @return bool
     */
    public function sendPasswordResetEmail(string $toEmail, string $toName, string $resetToken): bool
    {
        $resetUrl = base_url('auth/reset-password/' . $resetToken);

        $message = view('emails/password_reset', [
            'name' => $toName,
            'resetUrl' => $resetUrl,
        ]);

        $this->email->setFrom($this->config->fromEmail, $this->config->fromName);
        $this->email->setTo($toEmail);
        $this->email->setSubject('Reset Your Password - bandhanhara learning');
        $this->email->setMessage($message);

        return $this->email->send();
    }

    /**
     * Get email error message
     *
     * @return string
     */
    public function getError(): string
    {
        return $this->email->printDebugger(['headers']);
    }
}

