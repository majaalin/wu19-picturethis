<?php require __DIR__.'/views/header.php'; 

if (isset($_SESSION['user'])) {
        redirect('/feed.php');
} ?>

<article>
    <h1 class='title-heading'><?php echo $config['title']; ?></h1>

    <?php if (isset($_SESSION['user'])) : ?>
        <p>Welcome, <?php echo $_SESSION['user']['firstname']; ?>, to the feed!</p>
    <?php endif; ?>
</article>

<?php require __DIR__.'/views/footer.php'; ?>
