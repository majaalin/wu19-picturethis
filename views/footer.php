</div><!-- /container -->

    <div class='footer-icons'>
        <a href="feed.php"><img class="footer-img" src="/../assets/icons/feed_inactive.svg" class='feed'></a>
        <a href="search.php"><img class="footer-img" src="/../assets/icons/search_inactive.svg" class='search'></a>
        <a href="post.php"><img class="footer-img" src="/../assets/icons/post_inactive.svg" class='post'></a>
        <a href="activity.php"><img class="footer-img" src="/../assets/icons/activity_inactive.svg" class='activity'></a>
        <a href="home.php"><img class="footer-img home" src="/../<?= (isset($_SESSION['avatar']) ? 'app/database/avatars/' . $_SESSION['avatar'] : 'assets/icons/noprofile.png'); ?>"></a>
    </div>

    <script src="/../assets/scripts/main.js"></script>
</body>
</html>