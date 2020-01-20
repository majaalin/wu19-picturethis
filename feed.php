<?php require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/views/navigation.php'; ?>

<?php if(!isset($_SESSION['user'])) {
    redirect("/");
} ?>

<div class="container py-5">
<div class="dummy-div"><?= $_SESSION['user']['username']; ?></div>

<?php if(isset($_SESSION['profileID'])) {
    $id = $_SESSION['profileID'];
    $user = getUserByID($id, $pdo);
    // $posts = getPostsByUser($id,$pdo);
    $avatar = getAvatar($id, $pdo);
    $followers = getNumFollowers($id, $pdo);
    $followings = getNumFollowings($id, $pdo); 
    $isFollowing = FollowByID($id, $_SESSION['user']['id'], $pdo); ?>
<article>
    
    <div class='avatarAndProfileData'>
        <img class='avatar' src="<?= (($avatar!==[]) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="<?= $user['username']; ?>">
        <div class="post-follow-item">
            <h5><?= count($posts); ?></h5>
            <h6>POSTS</h6>
        </div>
        <div class="post-follow-item">
            <h5 class="numFollowers"><?= $followers; ?></h5>
            <h6>FOLLOWERS</h6>
        </div>
        <div class="post-follow-item">
            <h5><?= $followings; ?></h5>
            <h6>FOLLOWING</h6>
        </div>
    </div>
    <div class="username-bio-follow-banner">
        <div>
        <h5 class='username' id="<?= $id; ?>"><?= $user['username']; ?></h5>
            <h6 class='bio'><?php echo $user['bio']; ?></h6>
        </div>
        <div class="follow-div">
            <?php if($isFollowing) : ?>
                <h6 class="following">Following</h6>
                <button class="follow-buttons" onclick="unfollowUser()">Unfollow</button>
            <?php else : ?>
                <button class="follow-buttons" onclick="followUser()">Follow</button>
            <?php endif; ?>
        </div>
    </div>

    <?php foreach ($posts as $post) : 
        $liked = getLikesByPost($post["post_id"], $pdo);
        $comments = getComments($post["post_id"], $pdo); ?>
        <?php $id = $post['user_id'];
        $usernameArray = explode('-',$post['post_image']);
        $username = $usernameArray[0]; ?>
        
        <div class="dummy-post-div"><?= $id; ?></div>
        <div class = "<?= $username; ?>-post post">
            <div class = 'post-header'>
                <div class = "post-profile-header">
                    <img class="post-avatar" src="<?= (($avatar!==[]) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                    <h5 class="post-user"><?= $username ?></h5>
                </div>
            </div>
            <img class = "post-img"  src="<?= '/app/database/posts/' . $post['post_image']; ?>" alt="post">
            <div class = "like-comment-strip">
                <img class = "like-img like-comment" id="<?= $post['post_id']; ?>" src="/assets/icons/<?= ($liked) ? "like_active.png" : "like_inactive.svg"; ?>" alt="like">
                <a href="#"><img class = "like-comment comment-img" id="<?= $post['post_id']; ?>" src="/assets/icons/comment.svg" alt="comment"></a>
            </div>
            
            <div class="comments-container comments-container-<?= $post['post_id']; ?>">
                <?php if($post['post_text']!=="") : ?>
                    <div class="comment-box">
                        <h5 class="post-text-user"><?= $username; ?></h5>
                        <h6 class="comment-<?= $post['post_id']; ?>"><?= $post['post_text'] ?></h6>
                    </div>
                <?php endif; ?>
                <?php if($comments!==[]) : ?>
                    <?php foreach ($comments as $comment) : ?>
                    <div class="comment-box">
                        <h5 class="comment-user"><?= $comment['username']; ?></h5>
                        <h6 class="comment-<?= $comment['comment_id']; ?>"><?= $comment['comment_text']; ?></h6>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</article>

<?php } else {
    // $posts = getPostsByFollowings($_SESSION['user']['id'], $pdo); ?>

<ul class="error-container">
<?php foreach ($successes as $success) : ?>
    <li class="messages">&#10003; <?php echo $success ?></li>
<?php endforeach ?>
</ul>

<article>
    <?php foreach ($posts as $post) : ?>
        <?php $id = $post['user_id'];
        $avatar = getAvatar($id, $pdo); 
        $usernameArray = explode('-',$post['post_image']);
        $username = $usernameArray[0]; 
        $liked = getLikesByPost($post["post_id"], $pdo);
        $comments = getComments($post["post_id"], $pdo); ?> 
        
        <div class="dummy-post-div"><?= $id; ?></div> 
        <div class = "<?= $username; ?>-post post">
            <div class = 'post-header'>
                <form id="<?= $post['post_id']; ?>" action="app/users/searchUser.php" method="post">
                    <input type="hidden" name="profileID" value="<?= $id; ?>">
                    <input type="hidden" name="return-url" value="/feed.php">
                    <div onclick="document.getElementById('<?= $post['post_id']; ?>').submit();" class = "post-profile-header">
                        <img id="<?= $post['post_id']; ?>" class="post-avatar" src="<?= (!empty($avatar) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                        <h5 id="<?= $post['post_id']; ?>" class="post-user"><?= $username ?></h5>
                    </div>
                </form>
            </div>

            <img class = "post-img"  src="<?= '/app/database/posts/' . $post['post_image']; ?>" alt="post">
            
            <div class = "like-comment-strip">
                <img class = "like-img like-comment" id="<?= $post['post_id']; ?>" src="/assets/icons/<?= ($liked) ? "like_active.png" : "like_inactive.svg"; ?>" alt="like">
                <a href="#"><img class = "like-comment comment-img" id="<?= $post['post_id']; ?>" src="/assets/icons/comment.svg" alt="comment"></a>
            </div>
            
            <div class="comments-container comments-container-<?= $post['post_id']; ?>">
            <?php if($post['post_text']!=="") : ?>
                <div class="comment-box">
                    <h5 class="post-text-user"><?= $username; ?></h5>
                    <h6 class="comment-<?= $post['post_id']; ?>"><?= $post['post_text'] ?></h6>
                </div>
            <?php endif; ?>
                <?php foreach ($comments as $comment) : ?>
                <div class="comment-box">
                    <h5 class="comment-user"><?= $comment['username']; ?></h5>
                    <h6 class="comment-<?= $comment['comment_id']; ?>"><?= $comment['comment_text']; ?>
                    <form action="/app/posts/deleteComment.php?comment_id=<?php echo $comment['comment_id']; ?>" method="post">
                    <?php if ($comment['user_id'] === $_SESSION['user']['id']) : ?>
                        <button type="submit" class="" onclick="return confirm('Are you sure you want to delete this comment?')">Delete comment</button>
                    <?php endif; ?>
                </form></h6>
                </div>
                <?php endforeach; ?>
            </div>
        </div> 
    <?php endforeach; ?>
</article>

<?php } ?>

<?php unset($_SESSION['profileID']); ?>
<?php require __DIR__.'/views/footer.php'; ?>