<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Code</title>
</head>
<body>
    <h2>Password Reset Request 🚚</h2>
    <p>You requested to reset your password. Use the code below to verify your identity:</p>
    
    <div style="background: #f4f4f4; padding: 10px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 5px;">
        {{ $code }}
    </div>
    
    <p>This code will expire after use or in 5 minutes.</p>
    <p>If you didn't request this, please ignore this email.</p>
</body>
</html>