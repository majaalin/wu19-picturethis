<?php require __DIR__.'/views/header.php'; ?>
<!-- print errors -->
<?php $id = $_SESSION['user']['id'];
$posts = getPostsByUser($id, $pdo); 
$avatar = getAvatar($id, $pdo); 
$followers = getNumFollowers($id, $pdo);
$followings = getNumFollowings($id, $pdo); ?>

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
            <div class="post-follow-item">
                <h5><?= $followers; ?></h5>
                <h6>FOLLOWERS</h6>
            </div>
            <div class="post-follow-item">
                <h5><?= $followings; ?></h5>
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
        <div class="comments-container comments-container-<?= $post['post_id']; ?>">
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
                <h6 class="comment-<?= $post['post_id'] ?>"><?= $post['post_text'] ?></h6>
            </div>
        <?php endif; ?>
        </div>
    <?php endforeach; ?>
        
</article>

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
            editForm.action = "editPost()";
            editForm.method = "post";
            editForm.innerHTML = `<input type="hidden" name="post-id" value="${ID}">
            <input type="text" name="post-text" value="${existingText}">
            <button class="edit-comment-button" type="submit">Update</button>`;
            div.appendChild(editForm);
            commentsDiv.appendChild(div);
    
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
</script>

<?php require __DIR__.'/views/footer.php'; ?>