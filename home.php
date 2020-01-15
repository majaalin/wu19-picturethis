<?php require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/views/navigation.php'; ?>

<?php if(!isset($_SESSION['user'])) {
    redirect("/");
} ?>

<div class="container py-5">
<div class="dummy-div"><?= $_SESSION['user']['username']; ?></div>

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
        $liked = getLikesByPost($post["post_id"], $pdo);
        $comments = getComments($post["post_id"], $pdo); ?>
        <div class="dummy-post-div"><?= $post['user_id']; ?></div>
        <div class = "post">
            <div class = 'post-header'>
                <div class = 'post-profile-header'>
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
            
            <div class="postIMG">
                <img class = "post-img"  src="<?= '/app/database/posts/' . $post['post_image'] ?>" alt="post">
            </div>
            
            <div class = "like-comment-strip">
                <img class = "like-img like-comment" id="<?= $post['post_id']; ?>" src="/assets/icons/<?= ($liked) ? "like_active.png" : "like_inactive.svg"; ?>" alt="like">
                <a href="#"><img class = "like-comment comment-img" id="<?= $post['post_id']; ?>" src="/assets/icons/comment.svg" alt="comment"></a>
            </div>
            
            <div class="comments-container comments-container-<?= $post['post_id']; ?>">
                <?php if($post['post_text']!=="") : ?>
                    <div class="comment-box">
                        <h5 class="post-text-user"><?= $_SESSION['user']['username'] ?></h5>
                        <h6 class="comment-<?= $post['post_id'] ?>"><?= $post['post_text'] ?></h6>
                    </div>
                <?php endif; ?>
                <?php if($comments!==[]) : ?>
                    <?php foreach ($comments as $comment) : ?>
                    <div class="comment-box comment-boxes-<?= $post['post_id']; ?>">
                        <h5 class="comment-user"><?= $comment['username']; ?></h5>
                        <h6 class="comment-<?= $comment['comment_id']; ?>"><?= $comment['comment_text']; ?></h6>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
        
</article>

<script>
    'use strict';

    // Edit Post
    const imgs = document.querySelectorAll(".post-edit");
    imgs.forEach(img => {
        const ID = img.id;
        img.addEventListener('click', event => {
            const commentsDiv = document.querySelector(`.comments-container-${ID}`);
            const commentBoxes = document.querySelectorAll(`.comment-boxes-${ID}`)
            const usernameElement = document.querySelector('.dummy-div');
            const username = usernameElement.innerHTML;
            event.preventDefault();
            let existingText = "";
            if(document.querySelector(`.comment-${ID}`)) {
                let h6 = document.querySelector(`.comment-${ID}`);
                existingText = h6.innerHTML;
            }
            commentsDiv.innerHTML = "";
            const div = document.createElement('div');
            div.classList.add("comment-box");
            const uploadDiv = document.createElement('div');
            uploadDiv.classList.add("upload-box");
            const h5 = document.createElement('h5');
            h5.classList.add("post-text-user");
            h5.innerHTML = username;
            // This form for editing post text
            const editForm = document.createElement('form');
            // This form for editing post image
            const imageForm = document.createElement('form');
            imageForm.enctype = "multipart/form-data";
            imageForm.classList.add("edit-image-form");
            imageForm.method = "post";
            imageForm.innerHTML = `<input type="file" accept=".jpg, .jpeg, .png" name="editedIMG" id="editedIMG" required>
            <input type="hidden" name="post-id" value="${ID}">
            <button class="edit-comment-button" type="submit">Upload</button>`;
            editForm.classList.add("edit-post-form");
            editForm.method = "post";
            editForm.innerHTML = `<input type="hidden" name="post-id" value="${ID}">
            <input id="updateField" type="text" name="post-text" value="${existingText}">
            <button class="edit-comment-button" type="submit">Update</button>`;
            uploadDiv.appendChild(imageForm);
            div.appendChild(h5);
            // Append both forms
            div.appendChild(editForm);
            commentsDiv.appendChild(imageForm);
            commentsDiv.appendChild(div);
            // Append previous post comments
            commentBoxes.forEach(commentBox => {
                commentsDiv.appendChild(commentBox);
            });
            updateField.focus();

            // If post image form is submitted
            imageForm.addEventListener('submit', event => {
                event.preventDefault();
                const imageFormData = new FormData(imageForm);
                const editedIMG = document.getElementById('editedIMG');
                imageFormData.append('editedIMG', editedIMG.files[0]);
                fetch('/app/posts/editImage.php', {
                    method: 'POST',
                    body: imageFormData
                })
                .then(response => response.json())
                .then(newPost => {
                    if (newPost.error) {
                        console.log(newPost.error)
                    } else {
                    // Small delay before reloading (to make time for the image to be saved)
                    wait(500);
                    location.reload();
                    };
                });
            });
            
            // If post text form is submitted
            editForm.addEventListener('submit', event => {
                event.preventDefault();
                const formData = new FormData(editForm);
                fetch('/app/posts/update.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(post => {
                    commentsDiv.innerHTML = "";
                    const div = document.createElement('div');
                    div.classList.add("comment-box");
                    div.innerHTML = "";
                    if(post.postText!=="") {
                        const h5 = document.createElement('h5');
                        h5.classList.add("post-text-user");
                        h5.innerHTML = username;
                        div.appendChild(h5);
                        const h6 = document.createElement('h6');
                        h6.classList.add(`comment-${ID}`);
                        h6.innerHTML = post.postText;
                        div.appendChild(h6);
                        // Append new post text
                        commentsDiv.appendChild(div);
                        // Append previous post comments
                        commentBoxes.forEach(commentBox => {
                            commentsDiv.appendChild(commentBox);
                        });
                        // append comments
                    };
                });
            });
        }); 
    });

</script>

<?php require __DIR__.'/views/footer.php'; 