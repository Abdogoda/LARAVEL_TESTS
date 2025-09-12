<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome!</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      margin: 0;
      padding: 0;
    }
    .container {
      background: #fff;
      max-width: 600px;
      margin: 40px auto;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    h1 {
      color: #3490dc;
    }
    p {
      color: #333;
    }
    .footer {
      margin-top: 30px;
      font-size: 12px;
      color: #aaa;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome to Our Platform!</h1>
    <p>
      Hello {{ $user->name ?? 'User' }},
    </p>
    <p>
      We're excited to have you join us. Get started by exploring our features and connecting with the community.
    </p>
    <p>
      If you have any questions, feel free to reply to this email.
    </p>
    <div class="footer">
      &copy; {{ date('Y') }} Your Company. All rights reserved.
    </div>
  </div>
</body>
</html>