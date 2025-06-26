<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <link rel="stylesheet" href="/path/to/your/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>User Information</h1>
        <table class="user-info-table">
            <thead>
            <tr>
            <th>Field</th>
            <th>Value</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td><strong>Name</strong></td>
            <td><?php echo htmlspecialchars($user[0]->user_name); ?></td>
            </tr>
            <tr>
            <td><strong>Email</strong></td>
            <td><?php echo htmlspecialchars($user[0]->email); ?></td>
            </tr>
            <tr>
            <td><strong>Role</strong></td>
            <td><?php echo htmlspecialchars($user[0]->role); ?></td>
            </tr>
            <tr>
            <td><strong>Added On</strong></td>
            <td><?php echo htmlspecialchars($user[0]->added); ?></td>
            </tr>
            </tbody>
        </table>
        <style>
            .user-info-table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
            font-size: 18px;
            text-align: left;
            }
            .user-info-table th, .user-info-table td {
            border: 1px solid #ddd;
            padding: 8px;
            }
            .user-info-table th {
            background-color: #f4f4f4;
            font-weight: bold;
            }
            .user-info-table tr:nth-child(even) {
            background-color: #f9f9f9;
            }
            .user-info-table tr:hover {
            background-color: #f1f1f1;
            }
        </style>
    </div>
</body>
</html>