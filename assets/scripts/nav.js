'use strict';

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