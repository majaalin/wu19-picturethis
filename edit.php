<?php require __DIR__.'/views/header.php'; ?>

<?php if(isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
} else {
    $errors = [];
} ?>

<article>
    <h1>Edit Profile</h1>

    <?php foreach ($errors as $error) : ?>
        <p class="errors"><?= $error; ?></p>
    <?php endforeach; ?>

    <form action="#" method="post" enctype="multipart/form-data">
        <div>
            <?php if(!isset($_FILES['avatar'])) : ?>
                <label for="avatar">Select your profile picture to upload</label>
            <?php else : 
                $avatar = $_FILES['avatar']; 
                if (!in_array($avatar['type'], ['image/jpeg', 'image/png'])) : ?>
                    <p class="errors">The uploaded file type is not allowed.</p>
                <?php elseif ($avatar['size'] > 2097152) : ?>
                    <p class="errors">The uploaded file exceeds the 2MB filesize limit.</p>
                <?php else :
                    if(isset($_SESSION['avatar'])) :
                        unlink(__DIR__.'/app/database/avatars/'.$_SESSION['avatar']);
                    endif;
                    $user = $_SESSION['user'];
                    $extension = explode('.', $avatar['name']);
                    $avatarPath = $user['username'] . '.' . $extension[1];
                    move_uploaded_file($avatar['tmp_name'], __DIR__.'/app/database/avatars/'.$avatarPath);
                    $_SESSION['avatar'] = $avatarPath;

                    $queryFetchAvatars = 'SELECT * FROM avatars WHERE username = :username';
                    $statement = $pdo->prepare($queryFetchAvatars);
                    $statement->bindParam(':username', $user['username'], PDO::PARAM_STR);
                    $statement->execute();
                    $avatar = $statement->fetch(PDO::FETCH_ASSOC);
                    
                    if($avatar===false) :
                        $queryInsertAvatar = 'INSERT INTO avatars (avatar_id, username, image) VALUES (:avatar_id, :username, :image)';
                        $statement = $pdo->prepare($queryInsertAvatar);
                        $statement->execute([
                            ':avatar_id' => $user['id'],
                            ':username' => $user['username'],
                            ':image' => $avatarPath
                        ]);
                    else :
                        $queryUpdateAvatar = 'UPDATE avatars SET username = :username, image = :image WHERE avatar_id = :id';
                        $statement = $pdo->prepare($queryUpdateAvatar);
                        $statement->execute([
                            ':id' => $user['id'],
                            ':username' => $user['username'],
                            ':image' => $avatarPath
                        ]);
                    endif;

                endif; ?>
                <img class='upload-image' src="<?= '/app/database/avatars/'. $avatarPath; ?>" alt="<?= $_SESSION['user']['username']; ?>">    
            <?php endif; ?>
            <input type="file" accept=".jpg, .jpeg, .png" name="avatar" id="avatar" required> 
            </div>
        <button type="submit">Upload</button>
    </form>

    <form action="app/users/edit.php" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control" type="email" name="email" placeholder="<?= $_SESSION['user']['email']; ?>">
            <small class="form-text text-muted">What's your email?</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="username">Username:</label>
            <input class="form-control" type="username" name="username" placeholder="<?= $_SESSION['user']['username']; ?>">
            <small class="form-text text-muted">Now how about your username?</small>
        </div><!-- /form-group -->

        <div class="form-group">
            <label for="bio">Bio:</label>
            <input class="form-control" type="bio" name="bio" placeholder="<?= $_SESSION['user']['bio']; ?>">
            <small class="form-text text-muted">Want to have a tagline?</small>
        </div><!-- /form-group -->

        <div class = 'buttons'>
            <button type="submit" value='update'>Save Changes</button>
        </div>
    </form>
</article>

<?php unset($_SESSION['errors']); ?>
<?php require __DIR__.'/views/footer.php'; ?>