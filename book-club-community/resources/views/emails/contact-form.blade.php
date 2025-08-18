<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Form Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .field {
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 6px;
            border-left: 4px solid #667eea;
        }
        .field-label {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        .field-value {
            color: #333;
        }
        .message-content {
            background: white;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            white-space: pre-wrap;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📧 New Contact Form Message</h1>
        <p>Someone has sent you a message through the Book Club Community contact form</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">From:</div>
            <div class="field-value">{{ $contact->name }} ({{ $contact->email }})</div>
        </div>

        <div class="field">
            <div class="field-label">Subject:</div>
            <div class="field-value">{{ $contact->subject }}</div>
        </div>

        <div class="field">
            <div class="field-label">Message:</div>
            <div class="message-content">{{ $contact->message }}</div>
        </div>

        <div class="field">
            <div class="field-label">Sent:</div>
            <div class="field-value">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</div>
        </div>
    </div>

    <div class="footer">
        <p>📚 Book Club Community Contact Form</p>
        <p>You can reply directly to this email to respond to {{ $contact->name }}</p>
    </div>
</body>
</html>
