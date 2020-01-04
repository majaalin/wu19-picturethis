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
        menu.classList.toggle('toggle1');
    });

}

navSlide();

