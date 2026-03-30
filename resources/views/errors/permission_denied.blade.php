<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permission Denied</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        h1 {
            color: #e74c3c;
            font-size: 48px;
        }
        p {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>403 - Permission Denied</h1>
    <p>Sorry, you do not have access to this module or action.</p>
    <a href="{{ route('admins.dashboard') }}">Go Back to Dashboard</a>
</body>
</html>
