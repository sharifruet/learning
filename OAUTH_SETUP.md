# OAuth Setup Guide

This guide will help you set up Google and Facebook OAuth login for the Python Learning Platform.

## Google OAuth Setup

### 1. Create Google OAuth Credentials

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Navigate to **APIs & Services** > **Credentials**
4. Click **Create Credentials** > **OAuth client ID**
5. Configure the OAuth consent screen if prompted:
   - Choose **External** user type
   - Fill in the required information (app name, user support email, developer contact)
   - Add scopes: `email`, `profile`, `openid`
6. Create OAuth client ID:
   - Application type: **Web application**
   - Name: Python Learning Platform (or your preferred name)
   - Authorized redirect URIs: 
     - Development: `http://localhost:8080/auth/google/callback`
     - Production: `https://learning.bandhanhara.com/auth/google/callback`
7. Copy the **Client ID** and **Client Secret**

### 2. Configure Environment Variables

Add the following to your `.env` file:

```env
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8080/auth/google/callback
```

For production (learning.bandhanhara.com), update the redirect URI:
```env
GOOGLE_REDIRECT_URI=https://learning.bandhanhara.com/auth/google/callback
```

## Facebook OAuth Setup

### 1. Create Facebook App

1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Click **My Apps** > **Create App**
3. Choose **Consumer** as the app type
4. Fill in the app details:
   - App Display Name: Python Learning Platform
   - App Contact Email: your email
5. Add **Facebook Login** product:
   - Go to **Products** > **Facebook Login** > **Set Up**
   - Choose **Web** platform
   - Site URL: 
     - Development: `http://localhost:8080`
     - Production: `https://learning.bandhanhara.com`
6. Configure Settings:
   - Go to **Facebook Login** > **Settings**
   - Valid OAuth Redirect URIs: 
     - Development: `http://localhost:8080/auth/facebook/callback`
     - Production: `https://learning.bandhanhara.com/auth/facebook/callback`
7. Get your App ID and App Secret:
   - Go to **Settings** > **Basic**
   - Copy the **App ID** and **App Secret**

### 2. Configure Environment Variables

Add the following to your `.env` file:

```env
FACEBOOK_APP_ID=your_facebook_app_id_here
FACEBOOK_APP_SECRET=your_facebook_app_secret_here
FACEBOOK_REDIRECT_URI=http://localhost:8080/auth/facebook/callback
```

For production (learning.bandhanhara.com), update the redirect URI:
```env
FACEBOOK_REDIRECT_URI=https://learning.bandhanhara.com/auth/facebook/callback
```

## Running Migrations

After setting up OAuth credentials, run the migration to add OAuth fields to the users table:

```bash
docker-compose exec web php spark migrate
```

Or if running locally:
```bash
php spark migrate
```

## Testing

1. Make sure your `.env` file has the OAuth credentials
2. Start your application
3. Go to the login or register page
4. Click on "Continue with Google" or "Continue with Facebook"
5. You should be redirected to the OAuth provider's login page
6. After successful authentication, you'll be redirected back and logged in

## Troubleshooting

### Google OAuth Issues

- **Error: redirect_uri_mismatch**: Make sure the redirect URI in your Google Cloud Console exactly matches the one in your `.env` file (including http vs https)
- **Error: invalid_client**: Check that your Client ID and Client Secret are correct
- **Email not returned**: Make sure you've requested the `email` scope in the OAuth consent screen

### Facebook OAuth Issues

- **Error: redirect_uri_mismatch**: Ensure the redirect URI in Facebook App Settings matches your `.env` file
- **Email not returned**: Make sure your Facebook app is out of Development Mode, or add test users in the Facebook App Dashboard
- **Error: Invalid OAuth access token**: Check that your App ID and App Secret are correct

## Security Notes

- Never commit your `.env` file with OAuth credentials to version control
- Use environment variables for all sensitive credentials
- In production, always use HTTPS
- Regularly rotate your OAuth credentials
- Keep your OAuth credentials secure and never share them publicly


