<html>
<head>
    <title>Password Recovery</title>
</head>
    <body>
        <h1>Password Recovery</h1>
        <div>
            If you want to recover your password. Please use api with put localhost/api/user/password-change<br/>
            With json
            {
                "password": "your new password",
                "token": "{{ $token }}"
            }
        </div>
    </body>
</html>