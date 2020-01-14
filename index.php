<?php require __DIR__.'/views/header.php'; ?>

<div class="container index-container py-5">

<?php if (isset($_SESSION['user'])) {
        redirect('/feed.php');
} ?>

<article>
    <div class="all-index-text">
        <h1 class='title-heading'><?php echo $config['title']; ?></h1>
        <p class="text">Sign up to share pictures with your friends.</p>
        <div class="title-buttons-div">
            <a href="/login.php"><button class="title-buttons">Login</button></a>
            <a href="/create.php"><button class="title-buttons">Create Account</button></a>
        </div>
    </div>

</article>

<?php require __DIR__.'/views/footer.php'; ?>
