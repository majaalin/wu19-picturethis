<?php require __DIR__.'/views/header.php'; ?>

<article>

    <?php if (isset($_SESSION['user'])) : ?>
        <div class='avatarAndProfileData'>
            <?php if(isset($_SESSION['avatar'])) : ?>
            <img class='avatar' src="<?php echo '/app/database/avatars/' . $_SESSION['avatar']; ?>" alt="<?php echo $_SESSION['user']['username']; ?>">
            <?php else : ?>
            <img class='avatar' src="<?php echo '/assets/icons/noprofile.png'; ?>" alt="noprofile">
            <?php endif; ?>
            <div class=post-follow-item>
                <h5>0</h5>
                <h6>POSTS</h6>
            </div>
            <div class=post-follow-item>
                <h5>0</h5>
                <h6>FOLLOWERS</h6>
            </div>
            <div class=post-follow-item>
                <h5>0</h5>
                <h6>FOLLOWING</h6>
            </div>
        </div>
        <h5 class='username'><?php echo $_SESSION['user']['username']; ?></h5>
        <h6 class='bio'><?php echo $_SESSION['user']['bio']; ?></h6>
        <form action="/edit.php">
            <button type='submit' class='editProfileButton'>Edit Profile</button>
        </form>
    <?php endif; ?>
</article>

<?php require __DIR__.'/views/footer.php'; ?>


