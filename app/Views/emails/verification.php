<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to Python Learning Platform!</h2>
        
        <p>Hello <?= esc($name) ?>,</p>
        
        <p>Thank you for registering with Python Learning Platform. To complete your registration and start learning, please verify your email address by clicking the button below:</p>
        
        <p style="text-align: center;">
            <a href="<?= esc($verificationUrl) ?>" class="button">Verify Email Address</a>
        </p>
        
        <p>Or copy and paste this link into your browser:</p>
        <p style="word-break: break-all; color: #007bff;"><?= esc($verificationUrl) ?></p>
        
        <p>This verification link will expire in 24 hours.</p>
        
        <p>If you didn't create an account with us, please ignore this email.</p>
        
        <div class="footer">
            <p>Best regards,<br>The Python Learning Platform Team</p>
            <p>This is an automated email, please do not reply.</p>
        </div>
    </div>
</body>
</html>

