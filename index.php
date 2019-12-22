<?php require __DIR__.'/views/header.php'; ?>

<article>
    <h1><?php echo $config['title']; ?></h1>
    <p>This is the home page.</p>

    <?php if (isset($_SESSION['user'])) : ?>
        <p>Welcome, <?php echo $_SESSION['user']['firstname']; ?>!</p>
        <div class='avatarAndProfileData'>
            <?php if(isset($_SESSION['avatar'])) : ?>
            <img class='avatar' src="<?php echo $_SESSION['avatar']; ?>" alt="<?php echo $_SESSION['user']['username']; ?>">
            <?php endif; ?>
            <div class=post-follow-item>
                <h6>POSTS</h6>
            </div>
            <div class=post-follow-item>
                <h6>FOLLOWERS</h6>
            </div>
            <div class=post-follow-item>
                <h6>FOLLOWING</h6>
            </div>
        </div>
        <h6 class='username'><?php echo $_SESSION['user']['username']; ?></h6>
        <h6 class='bio'><?php echo $_SESSION['user']['bio']; ?></h6>
        <form action="/edit.php">
            <button type='submit' class='editProfileButton'>Edit Profile</button>
        </form> 
    <?php endif; ?>
</article>

<?php require __DIR__.'/views/footer.php'; ?>