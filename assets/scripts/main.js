'use strict';

const footerDiv = document.querySelector('.footer-icons');
const footerATags = footerDiv.querySelectorAll('a');
footerATags.forEach(element => {
    if(element.pathname===window.location.pathname && element.pathname !== '/home.php') {
        const pathnameArray=element.pathname.split('.')
        const iconImg = "<img src='/../assets/icons/" + pathnameArray[0] + "_active.svg' class='" + pathnameArray[0] + "'>";
        element.innerHTML = iconImg; 
    };
});

