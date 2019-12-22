<?php require __DIR__.'/views/header.php'; ?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <p>This is the home page.</p>

    <?php if (isset($_SESSION['user'])): ?>
        <p>Welcome, <?php echo $_SESSION['user']['firstname']; ?>!</p>
        <div class='avatarAndProfileData'>
            <!-- <img src="<?php echo $_SESSION['avatar']; ?>" alt="<?php echo $_SESSION['user']['username']; ?>">
            POSTS
            FOLLOWERS
            FOLLOWING -->
        </div>
        <h6 class='username'><?php echo $_SESSION['user']['username']; ?></h6>
        <h6 class='bio'><?php echo $_SESSION['user']['bio']; ?></h6>
        <form action="/edit.php">
            <button type='submit' class='editProfileButton'>Edit Profile</button>
        </form> 
    <?php endif; ?>
</article>

<?php require __DIR__.'/views/footer.php'; ?>