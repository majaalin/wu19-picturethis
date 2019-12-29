<?php require __DIR__.'/views/header.php'; ?>
<?php $id = $_SESSION['user']['id'];
$posts = getPosts($id, $pdo); 
$avatar = getAvatar($id, $pdo); ?>

<article>

    <?php if (isset($_SESSION['user'])) : ?>
        <div class='avatarAndProfileData'>
            <?php if(isset($_SESSION['avatar'])) : ?>
            <img class='avatar' src="<?php echo '/app/database/avatars/' . $_SESSION['avatar']; ?>" alt="<?php echo $_SESSION['user']['username']; ?>">
            <?php else : ?>
            <img class='avatar' src="<?php echo '/assets/icons/noprofile.png'; ?>" alt="noprofile">
            <?php endif; ?>
            <div class=post-follow-item>
                <h5><?= count($posts); ?></h5>
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

    <?php foreach ($posts as $post) : ?>
        <div class = 'post-header'>
            <div class = 'post-user'>
                <img class="post-avatar" src="<?= (isset($_SESSION['avatar']) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                <h5 class="post-user"><?= $_SESSION['user']['username'] ?></h5>
            </div>
            <div onclick="postPopUp()">
                <img class="post-edit" src="/assets/icons/menu_small.svg" alt="edit/delete">
                <div class="post-pop-up-text" id="postPopUp">A Simple Popup!</div>
            </div>
        </div>
        <img class = "post-img"  src="<?= '/app/database/posts/' . $post['post_image'] ?>" alt="post">
        <div class = "like-comment-strip">
            <a href="#"><img class = "like-comment" src="/assets/icons/like_inactive.svg" alt="like"></a>
            <a href="#"><img class = "like-comment" src="/assets/icons/comment.svg" alt="comment"></a>
        </div>
        <?php if($post['post_text']!=="") : ?>
            <div class="comment-box">
                <h5 class="comment-user"><?= $_SESSION['user']['username'] ?></h5>
                <h6 class="comment"><?= $post['post_text'] ?></h6>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
        

</article>

<?php require __DIR__.'/views/footer.php'; ?>