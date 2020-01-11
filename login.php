<?php require __DIR__.'/views/header.php'; ?> 

<?php if(isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
} else {
    $errors = [];
} ?>

<article>
    <h1>Login</h1>

    <?php foreach ($errors as $error) : ?>
        <p class="errors"><?= $error; ?></p>
    <?php endforeach; ?>

    <form action="app/users/login.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" type="email" name="email" required>
            <small class="form-text text-muted">Please provide your email address.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" required>
            <small class="form-text text-muted">Please provide your password.</small>
        </div><!-- /form-group -->

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</article>

<?php unset($_SESSION['errors']); ?>
<?php require __DIR__.'/views/footer.php'; ?>
