<?php require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/views/navigation.php'; ?>

<div class="container py-5">

<?php if(isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
} else {
    $errors = [];
} ?>

<article>
    <h1>Post</h1>

    <?php foreach ($errors as $error) : ?>
        <p class="errors"><?= $error; ?></p>
    <?php endforeach; ?>

    <form action="app/posts/store.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="caption">Post Caption</label>
            <input class="form-control" type="text" name="caption">
            <small class="form-text text-muted">Please enter a caption to accompany your post.</small>
        </div><!-- /form-group -->
        
        <div class="form-group">
            <input type="file" accept=".jpg, .jpeg, .png" name="post" id="post" required> 
        </div>

        <button type="submit">Upload</button>
    </form>
</article>

<?php unset($_SESSION['errors']); ?>
<?php require __DIR__.'/views/footer.php'; ?>