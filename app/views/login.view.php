<?php $title = ''?>
<?php require('partials/header.php') ?>

<h1>Login</h1>

<form action="<?php echo url() ?>login" method="POST">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>

<?php require('partials/footer.php') ?>


