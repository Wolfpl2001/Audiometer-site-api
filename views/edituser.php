<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="/public/css/manageusers.css">
</head>
<body>

<div class="header">
    <h1>Edit User</h1>
    <a href="/manageusers" class="btn">Back to Manage Users</a>
    <a href="/logout" class="btn">Logout</a>
</div>

<div class="edit-user-form">
    <form action="/update-user" method="post">
        <input type="hidden" name="userid" value="<?= htmlspecialchars($user['UserID']) ?>">
        <div class="row">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['Username']) ?>" required>
        </div>
        <div class="row">
            <label for="isadmin">Admin:</label>
            <input type="checkbox" id="isadmin" name="isadmin" <?= $user['IsAdmin'] ? 'checked' : '' ?>>
        </div>
        <div class="row">
            <button type="submit" class="btn">Update User</button>
        </div>
    </form>
</div>

</body>
</html>
