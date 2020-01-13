<?php
declare(strict_types=1); ?>

<style>

    body {
        width: 100vw;
        height: 100vh;
        background: url("/../../assets/portraitImages/<?= $selectedBackground; ?>");
        background-size: cover;
        background-repeat: no-repeat;
        background-position: 50% 50%;
    }

    .container {
        background: transparent;
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
    }

    .title-heading {
        font-family: BeautifulPeople;
    }

</style>