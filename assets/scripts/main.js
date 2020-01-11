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
    <button class="follow-buttons" onclick="unfollowUser()">Unfollow</button>`;

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
} 

const navSlide = () => {
    const menu = document.querySelector('.menu-large');
    const nav = document.querySelector('.navbar-nav');
    const navLinks = document.querySelectorAll('.navbar-nav li');
    const navBar = document.querySelector('.navbar');
    menu.addEventListener('click', () => {
        //Toggle Nav
        navBar.classList.toggle('navbar-fixed');
        nav.classList.toggle('nav-active');
        nav.style.animation = `navFade 200ms ease`

        //Animate Links
        navLinks.forEach((link, index) => {
            if (link.style.animation) {
                link.style.animation = '';
            } else {
                link.style.animation = `navLinkFade 0.4s ease forwards ${index / 8 + 0.15}s`;
            }
        });

        //Burger Animation
        menu.classList.toggle('translate');
    });
};

navSlide();


