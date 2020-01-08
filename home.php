<?php require __DIR__.'/views/header.php'; ?>
<!-- print errors -->
<?php $id = $_SESSION['user']['id'];
$posts = getPostsByUser($id, $pdo); 
$avatar = getAvatar($id, $pdo); ?>

<article>

    <?php if(isset($_SESSION['user'])) : ?>
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

    <?php foreach ($posts as $post) : 
        $liked = getLikesByPost($post["post_id"], $pdo) ?>
        <div class = 'post-header'>
            <div class = 'post-header'>
                <img class="post-avatar" src="<?= (isset($_SESSION['avatar']) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                <h5 class="post-user"><?= $_SESSION['user']['username'] ?></h5>
            </div>
                <div class="edit-delete-icons">
                    <form id="<?= $post['post_id']; ?>-edit" action="#" method="post">
                    <input type="hidden" name="post-id" value="<?= $post['post_id']; ?>">
                    <input type="hidden" name="post-text" value="<?= $post['post_text']; ?>">
                    <div onclick="document.getElementById('<?= $post['post_id']; ?>-edit').submit();">
                        <img class="post-edit" src="/assets/icons/edit.svg" alt="edit">
                    </div>
                    </form>
                    
                    <form id="<?= $post['post_id']; ?>-delete" action="/app/posts/delete.php" method="post">
                    <input type="hidden" name="post-id" value="<?= $post['post_id']; ?>">
                    <div onclick="document.getElementById('<?= $post['post_id']; ?>-delete').submit();">
                        <img class="post-delete" src="/assets/icons/delete.svg" alt="delete">
                    </div>
                    </form>
                </div>
        </div>
        <img class = "post-img"  src="<?= '/app/database/posts/' . $post['post_image'] ?>" alt="post">
        <form id="<?= $post['post_id']; ?>-like" action="app/posts/<?= ($liked) ? "removeLike.php" : "like.php"; ?>" method="post">
            <input type="hidden" name="post-id" value="<?= $post['post_id']; ?>">
            <input type="hidden" name="liked-user-id" value="<?= $id; ?>">
            <input type="hidden" name="return-url" id="<?= $post['post_id']; ?>-return" value="">    
            <div onclick="document.getElementById('<?= $post['post_id']; ?>-return').value = getScrolledURL(window.pageYOffset); document.getElementById('<?= $post['post_id']; ?>-like').submit();" class = "like-comment-strip">
                <img class = "like-comment" src="/assets/icons/<?= ($liked) ? "like_active.png" : "like_inactive.svg"; ?>" alt="like">
                <a href="#"><img class = "like-comment" src="/assets/icons/comment.svg" alt="comment"></a>
            </div>
        </form>
        <?php if(isset($_POST['post-id'],$_POST['post-text'])) : 
            if($_POST['post-id']===$post['post_id']) : ?>
                <div class="comment-box">
                    <h5 class="comment-user"><?= $_SESSION['user']['username'] ?></h5>
                    <form class="edit-post-form" action="/app/posts/update.php" method="post">
                        <input type="hidden" name="post-id" value="<?= $post['post_id']; ?>">
                        <input type="hidden" name="return-url" value="/home.php">
                        <input type="text" name="post-text" placeholder="<?= $_POST['post-text']; ?>">
                        <button class="edit-comment-button" type="submit">Update</button>
                    </form>
                    <!-- <h6 class="comment"><?= $post['post_text'] ?></h6> -->
                </div>
            <?php endif; 
        elseif($post['post_text']!=="") : ?>
            <div class="comment-box">
                <h5 class="comment-user"><?= $_SESSION['user']['username'] ?></h5>
                <h6 class="comment"><?= $post['post_text'] ?></h6>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
        
</article>

<?php require __DIR__.'/views/footer.php'; ?>