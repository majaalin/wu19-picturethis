<?php require __DIR__.'/views/header.php'; ?>

<div class="container py-5">

<?php if (isset($_SESSION['user'])) {
        redirect('/feed.php');
} ?>

<article>

    <h1 class='title-heading'><?php echo $config['title']; ?></h1>
    <p>Sign up to see pictures from your friends.</p>
    <a href="/login.php"><button>Login</button></a>
    <p>or</p>
    <a href="/create.php"><button>Create an Account</button></a>

</article>

<?php require __DIR__.'/views/footer.php'; ?>
