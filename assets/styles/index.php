<?php
declare(strict_types=1); ?>

<style>

    body {
        width: 100vw;
        height: 100vh;
        background: url("/../../assets/titleImages/<?= $randomImage; ?>");
        background-size: cover;
        background-repeat: no-repeat;
        background-position: 50% 50%;
    }

    .container {
        background: transparent;
        width: 100%;
    }

    .title-buttons-div {
        display: flex;
    }

    .title-buttons {
        background-color: transparent; 
        padding: 0 15px;
        text-align: center;
        border-width: 2px;
        margin-right: 15px;
        margin-top: 4px; 
    }

    .title-heading {
        font-family: BeautifulPeople;
        margin-bottom: 6px;
        color: black;
    }

    .text {
        color: black;
    }

    .all-index-text {
        margin-left: 10px;
    }

    button:hover {
    background: rgb(255, 255, 255, 0.5);
    /* color: rgb(255, 186, 46); */
    border-color: white;
  }

</style>