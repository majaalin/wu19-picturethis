<?php require __DIR__.'/views/header.php'; 

if (isset($_SESSION['user'])) {
        redirect('/feed.php');
} ?>

<article>

    <h1 class='title-heading'><?php echo $config['title']; ?></h1>
    <p>Sign up to see pictures from your friends.</p>
    <button>Login</button>
    <p>or</p>
    <button>Create an Account</button>

</article>

<?php require __DIR__.'/views/footer.php'; ?>
