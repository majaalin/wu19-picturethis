<?php require __DIR__.'/views/header.php'; ?>

<article>
    <h1>Edit Profile</h1>

    <form action="#" method="post" enctype="multipart/form-data">
        <div>
            <?php if(!isset($_FILES['avatar'])) : ?>
                <label for="avatar">Select your profile picture to upload</label>
            <?php else : ?>
                <?php $avatar = $_FILES['avatar']; ?>
                <?php if (!in_array($avatar['type'], ['image/jpeg', 'image/png'])) : ?>
                    <p>The uploaded file type is not allowed.</p>
                <?php elseif ($avatar['size'] > 2097152) : ?>
                    <p>The uploaded file exceeds the 2MB filesize limit.</p>
                <?php else : ?>
                    <?php $avatarPath = '/app/database/avatars/'.$avatar['name']; ?>
                    <?php move_uploaded_file($avatar['tmp_name'], __DIR__.$avatarPath); ?>
                    <?php $_SESSION['avatar'] = $avatarPath; ?>
                <?php endif; ?>
                <img class='upload-image' src="<?= $avatarPath; ?>" alt="<?= $_SESSION['user']['username']; ?>">    
            <?php endif; ?>
            <input type="file" accept=".jpg, .jpeg, .png" name="avatar" id="avatar" required> 
            </div>
        <button type="submit">Upload</button>
    </form>

    <form action="app/users/edit.php" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input class="form-control" type="username" name="username" placeholder="<?= $_SESSION['user']['username']; ?>">
            <small class="form-text text-muted">Please provide the your username.</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="bio">Bio</label>
            <input class="form-control" type="bio" name="bio" placeholder="<?= $_SESSION['user']['bio']; ?>">
            <small class="form-text text-muted">Please provide the your username.</small>
        </div><!-- /form-group -->

        <div class = 'buttons'>
            <button type="submit" value='cancel'>Cancel</button>
            <button type="submit" value='update'>Update Account Details</button>
        </div>
    </form>
</article>

<?php require __DIR__.'/views/footer.php'; ?>