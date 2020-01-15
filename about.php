<?php require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/views/navigation.php'; ?>

<?php if(!isset($_SESSION['user'])) {
    redirect("/");
} ?>

<div class="container py-5">

<article>
    <h1>About</h1>
    <h4>Hi <?php echo $_SESSION['user']['firstname']; ?>!</h4>
    <div class="about-div">
    <p class="about-text">Welcome to </p><h3 class="title-heading about-title">Picture This</h3>
    </div>
    <p>Picture This is a social media platform that was developed as part of the Web Development course at Yrgo, Lindholmen 2019-2020.</p>
    <p>The images uploaded are stills from films directed by Stanley Kubrick.</p>

    <img class="kubrick" src="/assets/titleImages/kubrick.jpg" alt="kubrick">

    <div class = "about-footer">
    <h5>Developed by AltDom 2019.</h5>
    <a href="https://github.com/AltDom"><img class="git" src="/assets/icons/github.svg" alt=""></a>
</div>
</article>



<?php require __DIR__.'/views/footer.php'; ?>
