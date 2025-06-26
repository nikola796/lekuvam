<!-- app/views/customer/register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Registration</title>
</head>
<body>
    <h1>Register</h1>
    <form action="<?php echo url() ?>register" method="post" style="max-width: 400px; margin: auto;">
        <div style="margin-bottom: 15px;">
            <label for="username" style="display: block;">Username:</label>
            <input type="text" id="username" name="username" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="email" style="display: block;">Email:</label>
            <input type="email" id="email" name="email" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="password" style="display: block;">Password:</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="confirm_password" style="display: block;">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required style="width: 100%; padding: 8px; box-sizing: border-box;">
        </div>
        <div style="text-align: center;">
            <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer;">Register</button>
        </div>
    </form>
</body>
</html>