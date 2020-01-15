<?php require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/views/navigation.php'; ?>

<?php if(!isset($_SESSION['user'])) {
    redirect("/");
} ?>

<div class="container py-5">

<article>
    <h1>Activity Feed</h1>
    <p>Hi <?php echo $_SESSION['user']['firstname']; ?>!</p>
    <p>This is the activity/notifications page.</p>
    <p>Currently under development.</p>
    <p>Cominig soon!</p>
</article>

<?php require __DIR__.'/views/footer.php'; ?>