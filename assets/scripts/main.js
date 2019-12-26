'use strict';

const footerDiv = document.querySelector('.footer-icons');
const footerATags = footerDiv.querySelectorAll('a');
footerATags.forEach(element => {
    if(element.pathname===window.location.pathname && element.pathname !== '/home.php') {
        const pathnameArray=element.pathname.split('.');
        const pathname = pathnameArray[0].split('/');
        const iconImg = "<img src='/../assets/icons" + pathnameArray[0] + "_active.svg' class='" + pathname[1] + "-active'>";
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

