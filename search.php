<?php require __DIR__.'/views/header.php'; ?>

<?php if(isset($_SESSION['profileID'])) {
    $id = $_SESSION['profileID'];
    $user = getUserByID($id, $pdo);
    $posts = getPostsByUser($id,$pdo);
    $avatar = getAvatar($id, $pdo); ?>
<article>
    
    <div class='avatarAndProfileData'>
        <?php if($avatar!==[]) : ?>
            <img class='avatar' src="<?php echo '/app/database/avatars/' . $avatar['image']; ?>" alt="<?php echo $_SESSION['profile']['username']; ?>">
        <?php else : ?>
            <img class='avatar' src="<?php echo '/assets/icons/noprofile.png'; ?>" alt="noprofile">
        <?php endif; ?>
        <div class="post-follow-item">
            <h5><?= count($posts); ?></h5>
            <h6>POSTS</h6>
        </div>
        <div class="post-follow-item">
            <h5>0</h5>
            <h6>FOLLOWERS</h6>
        </div>
        <div class="post-follow-item">
            <h5>0</h5>
            <h6>FOLLOWING</h6>
        </div>
    </div>
    <h5 class='username'><?php echo $user['username']; ?></h5>
    <h6 class='bio'><?php echo $user['bio']; ?></h6>

    <?php foreach ($posts as $post) : ?>
        <?php $id = $post['user_id'];
        $usernameArray = explode('-',$post['post_image']);
        $username = $usernameArray[0]; ?>
        <div class = "<?= $username; ?>-post post">
            <div class = "post-header">
                <img class="post-avatar" src="<?= (isset($avatar) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                <h5 class="post-user"><?= $username ?></h5>
            </div>
            <img class = "post-img"  src="<?= '/app/database/posts/' . $post['post_image']; ?>" alt="post">
            <div class = "like-comment-strip">
                <a href="#"><img class = "like-comment" src="/assets/icons/like_inactive.svg" alt="like"></a>
                <a href="#"><img class = "like-comment" src="/assets/icons/comment.svg" alt="comment"></a>
            </div>
            <?php if($post['post_text']!=="") : ?>
                <div class="comment-box">
                    <h5 class="comment-user"><?= $username; ?></h5>
                    <h6 class="comment"><?= $post['post_text'] ?></h6>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</article>

<?php } else {
    $posts = getAllPosts($pdo); ?>

<article>
    <?php foreach ($posts as $post) : ?>
        <?php $id = $post['user_id'];
        $avatar = getAvatar($id, $pdo); 
        $usernameArray = explode('-',$post['post_image']);
        $username = $usernameArray[0]; ?>
        <div class = "<?= $username; ?>-post post">
            
            <form id="<?= $post['post_id']; ?>" action="app/posts/searchUser.php" method="post">
                <input type="hidden" name="profileID" value="<?= $id; ?>">
                <div onclick="document.getElementById('<?= $post['post_id']; ?>').submit();" class = "post-header">
                    <img id="<?= $post['post_id']; ?>" class="post-avatar" src="<?= (isset($avatar) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                    <h5 id="<?= $post['post_id']; ?>" class="post-user"><?= $username ?></h5>
                </div>
            </form>
            <img class = "post-img"  src="<?= '/app/database/posts/' . $post['post_image']; ?>" alt="post">
            <div class = "like-comment-strip">
                <a href="#"><img class = "like-comment" src="/assets/icons/like_inactive.svg" alt="like"></a>
                <a href="#"><img class = "like-comment" src="/assets/icons/comment.svg" alt="comment"></a>
            </div>
            <?php if($post['post_text']!=="") : ?>
                <div class="comment-box">
                    <h5 class="comment-user"><?= $username; ?></h5>
                    <h6 class="comment"><?= $post['post_text'] ?></h6>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</article>

<?php } ?>

<?php unset($_SESSION['profileID']); ?>
<?php require __DIR__.'/views/footer.php'; ?>