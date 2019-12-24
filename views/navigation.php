<nav class="navbar navbar-expand-lg navbar-light bg-light">
    
<a class="navbar-brand" href="/index.php"><?php echo $config['title']; ?></a>

    <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/about.php' ? 'active' : ''; ?>" href="/about.php">About</a>
        </li><!-- /nav-item -->

        <?php if (isset($_SESSION['user'])): ?>
        <li class="nav-item">
            <a class="nav-link" href="/app/users/logout.php">Logout</a>
        </li><!-- /nav-item -->
        <li class="nav-item">
            <a class="nav-link" href="/app/users/delete.php">Delete Account</a>
        </li><!-- /nav-item -->
        <?php else: ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/login.php' ? 'active' : ''; ?>" href="login.php">Login</a>
        </li><!-- /nav-item -->
        <li class="nav-item">
            <a class="nav-link" href="/create.php">Create Account</a>
        </li><!-- /nav-item -->
        <?php endif; ?>

    </ul><!-- /navbar-nav -->

</nav><!-- /navbar -->