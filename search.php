<?php require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/views/navigation.php'; ?>

<div class="container py-5">

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
        $liked = getLikesByPost($post["post_id"], $pdo) ?>
        <?php $id = $post['user_id'];
        $usernameArray = explode('-',$post['post_image']);
        $username = $usernameArray[0]; ?>
        <div class = "<?= $username; ?>-post post">
            <div class = 'post-header'>
                <div class = "post-header">
                    <img class="post-avatar" src="<?= (($avatar!==null) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                    <h5 class="post-user"><?= $username ?></h5>
                </div>
                <?php if($id===$_SESSION["user"]["id"]) : ?>
                    <div class="edit-delete-icons">
                        <div>
                            <img class="post-edit" id="<?= $post['post_id']; ?>" src="/assets/icons/edit.svg" alt="edit">
                        </div>
                        <form id="<?= $post['post_id']; ?>-delete" action="/app/posts/delete.php" method="post">
                            <input type="hidden" name="post-id" value="<?= $post['post_id']; ?>">
                            <div onclick="document.getElementById('<?= $post['post_id']; ?>-delete').submit();">
                                <img class="post-delete" src="/assets/icons/delete.svg" alt="delete">
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
            <img class = "post-img"  src="<?= '/app/database/posts/' . $post['post_image']; ?>" alt="post">
                <div class = "like-comment-strip">
                <img class = "like-img like-comment" id="<?= $post['post_id']; ?>" src="/assets/icons/<?= ($liked) ? "like_active.png" : "like_inactive.svg"; ?>" alt="like">
                <a href="#"><img class = "like-comment comment-img" src="/assets/icons/comment.svg" alt="comment"></a>
            </div>
            
            <div class="comments-container comments-container-<?= $post['post_id']; ?>">
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
        $username = $usernameArray[0]; 
        $liked = getLikesByPost($post["post_id"], $pdo) ?>

        <div class = "<?= $username; ?>-post post">
            <div class = 'post-header'>
                <form id="<?= $post['post_id']; ?>" action="app/posts/searchUser.php" method="post">
                    <input type="hidden" name="profileID" value="<?= $id; ?>">
                    <input type="hidden" name="return-url" value="/search.php">
                    <div onclick="document.getElementById('<?= $post['post_id']; ?>').submit();" class = "post-header">
                        <img id="<?= $post['post_id']; ?>" class="post-avatar" src="<?= (($avatar!==[]) ? '/app/database/avatars/' . $avatar['image'] : '/assets/icons/noprofile.png'); ?>" alt="avatar">
                        <h5 id="<?= $post['post_id']; ?>" class="post-user"><?= $username ?></h5>
                    </div>
                </form>

                <?php if($id===$_SESSION["user"]["id"]) : ?>
                    <div class="edit-delete-icons">
                        <div>
                            <img class="post-edit" id="<?= $post['post_id']; ?>" src="/assets/icons/edit.svg" alt="edit">
                        </div>
                        <form id="<?= $post['post_id']; ?>-delete" action="/app/posts/delete.php" method="post">
                            <input type="hidden" name="post-id" value="<?= $post['post_id']; ?>">
                            <div onclick="document.getElementById('<?= $post['post_id']; ?>-delete').submit();">
                                <img class="post-delete" src="/assets/icons/delete.svg" alt="delete">
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

            <img class = "post-img"  src="<?= '/app/database/posts/' . $post['post_image']; ?>" alt="post">
            
            <div class = "like-comment-strip">
                <img class = "like-img like-comment" id="<?= $post['post_id']; ?>" src="/assets/icons/<?= ($liked) ? "like_active.png" : "like_inactive.svg"; ?>" alt="like">
                <a href="#"><img class = "like-comment comment-img" src="/assets/icons/comment.svg" alt="comment"></a>
            </div>
            
            <div class="comments-container comments-container-<?= $post['post_id']; ?>">
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

<script>
    'use strict';
    const imgs = document.querySelectorAll(".post-edit");
    imgs.forEach(img => {
        const ID = img.id;
        img.addEventListener('click', event => {
            const commentsDiv = document.querySelector(`.comments-container-${ID}`);
            event.preventDefault();
            let existingText = "";
            if(document.querySelector(`.comment-${ID}`)) {
                let h6 = document.querySelector(`.comment-${ID}`);
                existingText = h6.innerHTML;
            }
            commentsDiv.innerHTML = "";
            const div = document.createElement('div');
            div.classList.add("comment-box");
            const h5 = document.createElement('h5');
            h5.classList.add("comment-user");
            h5.innerHTML = "<?= $_SESSION['user']['username'] ?>";
            div.appendChild(h5);
            const editForm = document.createElement('form');
            editForm.classList.add("edit-post-form");
            editForm.method = "post";
            editForm.innerHTML = `<input type="hidden" name="post-id" value="${ID}">
            <input id="updateField" type="text" name="post-text" value="${existingText}">
            <button class="edit-comment-button" type="submit">Update</button>`;
            div.appendChild(editForm);
            commentsDiv.appendChild(div);
            updateField.focus();
    
            editForm.addEventListener('submit', event => {
                event.preventDefault();
                const formData = new FormData(editForm);
                fetch('/app/posts/update.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(post => {
                    div.innerHTML = "";
                    if(post.postText!=="") {
                        const h5 = document.createElement('h5');
                        h5.classList.add("comment-user");
                        h5.innerHTML = "<?= $_SESSION['user']['username'] ?>";
                        div.appendChild(h5);
                        const h6 = document.createElement('h6');
                        h6.classList.add(`comment-${ID}`);
                        h6.innerHTML = post.postText;
                        div.appendChild(h6);
                    };
                });
            });
        }); 
    });

    let likeIMGs = document.querySelectorAll(".like-img");
    likeIMGs.forEach(likeIMG => {
        const ID = likeIMG.id;
        likeIMG.addEventListener('click', event => {
            event.preventDefault();
            let liked = true;
            if(likeIMG.src.includes("/assets/icons/like_inactive.svg")) {
                likeIMG.src='/assets/icons/like_active.png';
            } else {
                likeIMG.src='/assets/icons/like_inactive.svg';
                liked = false;
            }
            const likeForm = document.createElement('form');
            likeForm.method = "post";
            likeForm.innerHTML = `<input type="hidden" name="post-id" value="${ID}">
            <input type="hidden" name="liked-user-id" value="<?= $id; ?>">`;
            if (liked) {
                const likeFormData = new FormData(likeForm);
                fetch("app/posts/like.php", {
                method: 'POST',
                body: likeFormData
                });
            } else {
                const removeLikeFormData = new FormData(likeForm);
                fetch("app/posts/removeLike.php", {
                method: 'POST',
                body: removeLikeFormData
                });
            };  
        });
    });
</script>

<?php unset($_SESSION['profileID']); ?>
<?php require __DIR__.'/views/footer.php'; ?>