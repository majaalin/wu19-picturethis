'use strict';

const footerDiv = document.querySelector('.footer-icons');
const footerATags = footerDiv.querySelectorAll('a');
footerATags.forEach(element => {
    if(element.pathname===window.location.pathname && element.pathname !== '/home.php') {
        const pathnameArray=element.pathname.split('.');
        const pathname = pathnameArray[0].split('/');
        const iconImg = "<img class='footer-img' src='/../assets/icons" + pathnameArray[0] + "_active.svg' class='" + pathname[1] + "-active'>";
        element.innerHTML = iconImg; 
    }
    if (element.pathname===window.location.pathname && window.location.pathname === '/home.php') {
        const img = element.querySelector('img');
        img.classList.add('home-active');
    } else if (window.location.pathname !== '/home.php') {
        const img = element.querySelector('img');
        img.classList.remove('home-active');
    }
});

const followUser = () => {
    const followDiv = document.querySelector(".follow-div");
    const followers = document.querySelector(".numFollowers");
    const numFollowers = parseInt(followers.innerHTML);
    followers.innerHTML = numFollowers+1;

    const elementWithID = document.querySelector(".username");
    const followedUserID = elementWithID.id;
    followDiv.innerHTML = `<h6 class="following">Following</h6>
    <button class="follow-buttons unfollow-button" onclick="unfollowUser()">Unfollow</button>`;

    const followForm = document.createElement('form');
    followForm.method = "post";
    followForm.innerHTML = `<input type="hidden" name="followed-user-id" value="${followedUserID}">`;
    const followFormData = new FormData(followForm);
    fetch("app/users/follow.php", {
    method: 'POST',
    body: followFormData
    });
} 

const unfollowUser = () => {
    const followDiv = document.querySelector(".follow-div");
    const followers = document.querySelector(".numFollowers");
    const numFollowers = parseInt(followers.innerHTML);
    followers.innerHTML = numFollowers-1;
    
    const elementWithID = document.querySelector(".username");
    const unfollowedUserID = elementWithID.id;
    followDiv.innerHTML = `<button class="follow-buttons" onclick="followUser()">Follow</button>`;

    const unfollowForm = document.createElement('form');
    unfollowForm.method = "post";
    unfollowForm.innerHTML = `<input type="hidden" name="unfollowed-user-id" value="${unfollowedUserID}">`;
    const unfollowFormData = new FormData(unfollowForm);
    fetch("app/users/unfollow.php", {
    method: 'POST',
    body: unfollowFormData
    });
};

// // insert comment
// const commentImgs = document.querySelectorAll(".comment-img");
// commentImgs.forEach(commentImg => {
//     const ID = commentImg.id;
//     commentImg.addEventListener('click', event => {
//         const commentsDiv = document.querySelector(`.comments-container-${ID}`);
//         event.preventDefault();
//         let existingText = "";
//         if(document.querySelector(`.comment-${ID}`)) {
//             let h6 = document.querySelector(`.comment-${ID}`);
//             existingText = h6.innerHTML;
//         }
//         commentsDiv.innerHTML = "";
//         const div = document.createElement('div');
//         div.classList.add("comment-box");
//         const h5 = document.createElement('h5');
//         h5.classList.add("comment-user");
//         h5.innerHTML = "<?= $_SESSION['user']['username'] ?>";
//         div.appendChild(h5);
//         const editForm = document.createElement('form');
//         editForm.classList.add("edit-post-form");
//         editForm.method = "post";
//         editForm.innerHTML = `<input type="hidden" name="post-id" value="${ID}">
//         <input id="updateField" type="text" name="post-text" value="${existingText}">
//         <button class="edit-comment-button" type="submit">Update</button>`;
//         div.appendChild(editForm);
//         commentsDiv.appendChild(div);
//         updateField.focus();

//         editForm.addEventListener('submit', event => {
//             event.preventDefault();
//             const formData = new FormData(editForm);
//             fetch('/app/posts/update.php', {
//                 method: 'POST',
//                 body: formData
//             })
//             .then(response => response.json())
//             .then(post => {
//                 div.innerHTML = "";
//                 if(post.postText!=="") {
//                     const h5 = document.createElement('h5');
//                     h5.classList.add("comment-user");
//                     h5.innerHTML = "<?= $_SESSION['user']['username'] ?>";
//                     div.appendChild(h5);
//                     const h6 = document.createElement('h6');
//                     h6.classList.add(`comment-${ID}`);
//                     h6.innerHTML = post.postText;
//                     div.appendChild(h6);
//                 };
//             });
//         });
//     }); 
// });

// // create comment
// const commentImgs = document.querySelectorAll(".comment-img");
// commentImgs.forEach(commentImg => {
//     const ID = commentImg.id;
//     commentImg.addEventListener('click', event => {
//         event.preventDefault();
//         const commentsDiv = document.querySelector(`.comments-container-${ID}`);
//         const div = document.createElement('div');
//         div.classList.add("comment-box");
//         const h5 = document.createElement('h5');
//         h5.classList.add("comment-user");
//         h5.innerHTML = "<?= $_SESSION['user']['username'] ?>";
//         div.appendChild(h5);
//         const editForm = document.createElement('form');
//         editForm.classList.add("edit-post-form");
//         editForm.method = "post";
//         editForm.innerHTML = `<input type="hidden" name="post-id" value="${ID}">
//         <input id="updateField" type="text" name="post-text">
//         <button class="edit-comment-button" type="submit">Update</button>`;
//         div.appendChild(editForm);
//         commentsDiv.appendChild(div);
//         updateField.focus();
//     });
// });


