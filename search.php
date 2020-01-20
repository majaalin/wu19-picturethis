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
    $isFollowing = FollowByID($id, $_SESSION['user']['id'], $pdo);?>

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
                <button class="follow-buttons unfollow-button" onclick="unfollowUser()">Unfollow</button>
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
            <div class = 'user'>
                <div class = "post-profile-header">
                    <img class="post-avatar" src="<?= ((!empty($avatar)) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
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
    // $posts = getAllPosts($pdo); ?>

<article>
    <!-- The next three lines of text to be deleted. -->
    <h1>Search</h1>
    <form class="search" action="/app/users/searchUser.php" method="get">
        <input class="form-control search" type="text" name="search" placeholder="Search for a user"> 
    </form>

        <!-- Shows if user get an error -->
        <ul class="error-container">
<?php foreach ($errors as $error) : ?>
    <li class="messages errors">&#9747; <?php echo $error ?></li>
<?php endforeach ?>
</ul>

    <?php if (!$users): ?>
        <?php 
    $statement = $pdo->prepare('SELECT * FROM users');
    $statement->execute();
    $otherUsers = $statement->fetchAll(PDO::FETCH_ASSOC); ?> 

    <?php 
    foreach ($otherUsers as $otherUser) :
    $id = $otherUser['id'];
    $avatar = getAvatar($id, $pdo); ?>

<div class="dummy-post-div"><?= $id; ?></div>
        <div class = "<?= $otherUser['username']; ?>">
            <div class = 'user'>
                <form id="<?= $id; ?>" action="app/users/searchUser.php" method="post">
                    <input type="hidden" name="profileID" value="<?= $id; ?>">
                    <input type="hidden" name="return-url" value="/search.php">
                    <div onclick="document.getElementById('<?= $id; ?>').submit();" class = "post-profile-header">
                        <img id="<?= $id; ?>" class="post-avatar" src="<?= (($avatar!==[]) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                        <h5 id="<?= $id; ?>" class="post-user"><?= $otherUser['username'] ?></h5>
                    </div>
                </form>
            </div>
<?php endforeach ?>

        <?php else : ?>
    <!-- View results from search -->

<?php foreach ($users as $user) : 
    $id = $user['id'];
    $avatar = getAvatar($id, $pdo); ?>

<div class="dummy-post-div"><?= $id; ?></div>
        <div class = "<?= $username; ?>">
            <div class = 'user'>
                <form id="<?= $id; ?>" action="app/users/searchUser.php" method="post">
                    <input type="hidden" name="profileID" value="<?= $id; ?>">
                    <input type="hidden" name="return-url" value="/search.php">
                    <div onclick="document.getElementById('<?= $id; ?>').submit();" class = "post-profile-header">
                        <img id="<?= $id; ?>" class="post-avatar" src="<?= (($avatar!==[]) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                        <h5 id="<?= $id; ?>" class="post-user"><?= $user['username'] ?></h5>
                    </div>
                </form>
            </div>
<?php endforeach ?>
<?php 
    $statement = $pdo->prepare('SELECT * FROM users WHERE id != :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $otherUsers = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($otherUsers as $otherUser) :
    $id = $otherUser['id'];
    $avatar = getAvatar($id, $pdo); ?>

<div class="dummy-post-div"><?= $id; ?></div>
        <div class = "<?= $otherUser['username']; ?>">
            <div class ='user other'>
                <form id="<?= $id; ?>" action="app/users/searchUser.php" method="post">
                    <input type="hidden" name="profileID" value="<?= $id; ?>">
                    <input type="hidden" name="return-url" value="/search.php">
                    <div onclick="document.getElementById('<?= $id; ?>').submit();" class = "post-profile-header">
                        <img id="<?= $id; ?>" class="post-avatar" src="<?= (($avatar!==[]) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                        <h5 id="<?= $id; ?>" class="post-user"><?= $otherUser['username'] ?></h5>
                    </div>
                </form>
            </div>
<?php endforeach ?>
<?php endif; ?>
</article>

<?php } ?>

<?php unset($_SESSION['profileID']); ?>
<?php require __DIR__.'/views/footer.php'; ?>