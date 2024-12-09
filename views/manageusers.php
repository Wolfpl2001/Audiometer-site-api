<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="/public/css/manageusers.css">
</head>
<body>

<div class="header">
    <h1>Manage Users</h1>
    <a href="/loginafter" class="btn">Back to Dashboard</a>
    <a href="/register" class="btn">Create new user</a>
    <a href="/logout" class="btn">Logout</a>
</div>

<div class="user-list">
    <table>
        <thead>
        <tr>
            <th>UserID</th>
            <th>Username</th>
            <th>Admin</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['UserID']) ?></td>
                <td><?= htmlspecialchars($user['Username']) ?></td>
                <td><?= $user['IsAdmin'] ? 'Yes' : 'No' ?></td>
                <td>
                    <a href="/edit-user?id=<?= $user['UserID'] ?>" class="btn">Edit</a>
                    <a href="/delete-user?id=<?= $user['UserID'] ?>" class="btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
