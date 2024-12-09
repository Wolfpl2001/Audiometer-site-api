<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/css/manageusers.css">
    <title>Register</title>
</head>
<body>
<div class="header">
    <h1>Edit User</h1>
    <a href="/manageusers" class="btn">Back to Manage Users</a>
    <a href="/logout" class="btn">Logout</a>
</div>

<div class="edit-user-form">
    <h2>Register</h2>
    <?php if (isset($errorMessage)) echo "<p style='color: red;'>$errorMessage</p>"; ?>
    <form action="/processRegistration" method="post">
        <div class="row">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Choose a username" required>
        </div>
        <div class="row">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Choose a password" required>
        </div>
        <div class="row">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
        </div>
        <div class="row">
            <button type="submit" name="register" class="btn">Register</button>
        </div>
    </form>
</div>
</body>
</html>
