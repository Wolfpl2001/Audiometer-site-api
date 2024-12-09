
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/login.css">

    <title>Login Page</title>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <?php if (isset($errorMessage)) echo "<p style='color: red;'>$errorMessage</p>"; ?>
    <form action="/login" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>
</body>
</html>
