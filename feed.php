<?php require __DIR__.'/views/header.php'; ?>

<?php if(isset($_SESSION['profileID'])) {
    $id = $_SESSION['profileID'];
    $user = getUserByID($id, $pdo);
    $posts = getPostsByUser($id,$pdo);
    $avatar = getAvatar($id, $pdo);
    $followers = getNumFollowers($id, $pdo);
    $followings = getNumFollowings($id, $pdo); 
    $isFollowing = FollowByID($id, $_SESSION['user']['id'], $pdo); ?>
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
            <h5><?= $followers; ?></h5>
            <h6>FOLLOWERS</h6>
        </div>
        <div class="post-follow-item">
            <h5><?= $followings; ?></h5>
            <h6>FOLLOWING</h6>
        </div>
    </div>
    <div class="username-bio-follow-banner">
        <div>
            <h5 class='username'><?php echo $user['username']; ?></h5>
            <h6 class='bio'><?php echo $user['bio']; ?></h6>
        </div>
        <div>
            <?php if($isFollowing) : ?>
                <h6 class="following">Following</h6>
            <?php else : ?>
                <button onclick="followUser()">Follow</button>
            <?php endif; ?>
        </div>
    </div>
    <?php foreach ($posts as $post) : 
        $liked = getLikesByPost($post["post_id"], $pdo) ?>
        <?php $id = $post['user_id'];
        $usernameArray = explode('-',$post['post_image']);
        $username = $usernameArray[0]; ?>
        <div class = "<?= $username; ?>-post post">
            <div class = 'post-header'>
                <div class = "post-header">
                    <img class="post-avatar" src="<?= (isset($avatar) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                    <h5 class="post-user"><?= $username ?></h5>
                </div>
                <?php if($id===$_SESSION["user"]["id"]) : ?>
                <div class="edit-delete-icons">
                    <img class="post-edit" src="/assets/icons/edit.svg" alt="edit">
                    <img class="post-delete" src="/assets/icons/delete.svg" alt="delete">
                </div>
                <?php endif; ?>
            </div>
            <img class = "post-img"  src="<?= '/app/database/posts/' . $post['post_image']; ?>" alt="post">
            <form id="<?= $post['post_id']; ?>-like" action="app/posts/<?= ($liked) ? "removeLike.php" : "like.php"; ?>" method="post">
                <input type="hidden" name="post-id" value="<?= $post['post_id']; ?>">
                <input type="hidden" name="liked-user-id" value="<?= $id; ?>">
                <input type="hidden" name="return-url" id="<?= $post['post_id']; ?>-return" value="">    
                <div onclick="document.getElementById('<?= $post['post_id']; ?>-return').value = getScrolledURL(window.pageYOffset); document.getElementById('<?= $post['post_id']; ?>-like').submit();" class = "like-comment-strip">
                    <img class = "like-comment" src="/assets/icons/<?= ($liked) ? "like_active.png" : "like_inactive.svg"; ?>" alt="like">
                    <a href="#"><img class = "like-comment" src="/assets/icons/comment.svg" alt="comment"></a>
                </div>
            </form>
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
    $posts = getPostsByFollowings($_SESSION['user']['id'], $pdo); ?>
    

<article>
    <?php foreach ($posts as $post) : ?>
        <?php $id = $post['user_id'];
        $avatar = getAvatar($id, $pdo); 
        $usernameArray = explode('-',$post['post_image']);
        $username = $usernameArray[0]; 
        $liked = getLikesByPost($post["post_id"], $pdo) ?>

        <div class = "<?= $username; ?>-post post">
            <div class = 'post-header'>
                <form id="<?= $post['post_id']; ?>" action="app/posts/searchUser.php" method="post">
                    <input type="hidden" name="profileID" value="<?= $id; ?>">
                    <div onclick="document.getElementById('<?= $post['post_id']; ?>').submit();" class = "post-header">
                        <img id="<?= $post['post_id']; ?>" class="post-avatar" src="<?= (isset($avatar) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                        <h5 id="<?= $post['post_id']; ?>" class="post-user"><?= $username ?></h5>
                    </div>
                </form>

                <?php if($id===$_SESSION["user"]["id"]) : ?>
                    <form id="<?= $post['post_id']; ?>-edit" action="#" method="post">
                        <input type="hidden" name="post-id" value="<?= $post['post_id']; ?>">
                        <input type="hidden" name="post-text" value="<?= $post['post_text']; ?>">
                        <div class="edit-delete-icons">
                            <div onclick="document.getElementById('<?= $post['post_id']; ?>-edit').submit();">
                                <img class="post-edit" src="/assets/icons/edit.svg" alt="edit">
                            </div>
                            <img class="post-delete" src="/assets/icons/delete.svg" alt="delete">
                        </div>
                    </form>
                <?php endif; ?>
            </div>

            <img class = "post-img"  src="<?= '/app/database/posts/' . $post['post_image']; ?>" alt="post">
            
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
                        <input type="hidden" name="return-url" value="/search.php">
                        <input type="text" name="post-text" placeholder="<?= $_POST['post-text']; ?>">
                        <button class="edit-comment-button" type="submit">Update</button>
                    </form>
                    <!-- <h6 class="comment"><?= $post['post_text'] ?></h6> -->
                </div>
            <?php endif; 
        elseif($post['post_text']!=="") : ?>
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