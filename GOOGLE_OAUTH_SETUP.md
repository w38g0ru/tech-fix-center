# Google OAuth Setup Guide

This guide explains how to set up Google OAuth authentication for the Tech Fix Center application.

## Prerequisites

1. Google Cloud Console account
2. A Google Cloud project

## Step 1: Create Google Cloud Project

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google+ API and Google OAuth2 API

## Step 2: Create OAuth 2.0 Credentials

1. Navigate to **APIs & Services > Credentials**
2. Click **Create Credentials > OAuth 2.0 Client IDs**
3. Choose **Web application** as the application type
4. Add the following **Authorized redirect URIs**:
   - `https://tfc.gaighat.com/auth/callback` (Production)
   - `http://tfc.local/auth/callback` (Local Development)
   - `http://localhost/auth/callback` (Alternative Local)

## Step 3: Configure Environment Variables

1. Copy the `.env.example` file to `.env`
2. Add your Google OAuth credentials to the `.env` file:

```env
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=https://tfc.gaighat.com/auth/callback
```

## Step 4: Test the Configuration

1. Visit the login page: `http://tfc.local/auth/login`
2. Click the "Sign in with Google" button
3. You should be redirected to Google's OAuth consent screen

## Example Configuration

For reference, your `.env` file should look like this:

```env
GOOGLE_CLIENT_ID=your_actual_client_id_from_google_console
GOOGLE_CLIENT_SECRET=your_actual_client_secret_from_google_console
GOOGLE_REDIRECT_URI=https://tfc.gaighat.com/auth/callback
```

## Troubleshooting

### Error: "Missing required parameter: client_id"

This error occurs when the Google OAuth credentials are not properly configured. Make sure:

1. The `.env` file contains the correct `GOOGLE_CLIENT_ID` and `GOOGLE_CLIENT_SECRET`
2. The redirect URI in Google Cloud Console matches your application URL
3. The Google OAuth APIs are enabled in your Google Cloud project

### Error: "redirect_uri_mismatch"

This error occurs when the redirect URI doesn't match what's configured in Google Cloud Console. Make sure:

1. The redirect URI in Google Cloud Console exactly matches your application URL
2. For local development, add `http://tfc.local/auth/callback`
3. For production, add `https://tfc.gaighat.com/auth/callback`

## Security Notes

- Never commit the actual credentials to version control
- Use environment variables for all sensitive configuration
- Regularly rotate your OAuth credentials
- Monitor OAuth usage in Google Cloud Console

## Support

If you encounter issues with Google OAuth setup, please check:

1. Google Cloud Console error logs
2. Application logs in `writable/logs/`
3. Browser developer console for JavaScript errors

For additional support, contact the development team.
