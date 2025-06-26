<!DOCTYPE html>
<style>
    body {
        margin-top: 20px;
    }
    table, h1 {
        width: 50%;
        border-collapse: collapse;
        margin: auto;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
        text-align: left;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    tr:hover {
        background-color: #ddd;
    }
</style>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link rel="stylesheet" href="/path/to/your/css/styles.css">
</head>
<body>
    <h1>Users List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Added on:</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user->user_id); ?></td>
                    <td><?php echo htmlspecialchars($user->user_name); ?></td>
                    <td><?php echo htmlspecialchars($user->email); ?></td>
                    <td><?php echo htmlspecialchars($user->added); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>