<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Code</title>
</head>
<body>
    <!-- Center using table -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 10px;">
        <tr>
            <td align="center">
                <img src="{{ $message->embed(public_path('img/logo/full-logo.png')) }}" 
                    alt="Company Logo" style="max-width: 200px; height: auto;">
            </td>
        </tr>
    </table>

    <h2>Password Reset Request! 🚚</h2>
    <p>You requested to reset your password. Use the code below to verify your identity:</p>
    
    <div style="background: #f4f4f4; padding: 10px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 5px;">
        {{ $code }}
    </div>
    
    <p>This code will expire after use or in 5 minutes.</p>
    <p>If you didn't request this, please ignore this email.</p>
</body>
</html>