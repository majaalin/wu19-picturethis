<nav class="navbar navbar-expand-lg navbar-light bg-light">
    
<a class="navbar-brand" href="/index.php"><?php echo $config['title']; ?></a>

    <ul class="desktop-nav">

        <?php if (!isset($_SESSION['user'])): ?>
        <li class="nav-item">
            <a class="nav-link" href="/index.php">Home</a>
        </li><!-- /nav-item -->
        <?php endif; ?>

        <?php if (isset($_SESSION['user'])): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/about.php' ? 'active' : ''; ?>" href="/about.php">About</a>
        </li><!-- /nav-item -->
        <li class="nav-item">
            <a class="nav-link" href="/app/users/logout.php">Logout</a>
        </li><!-- /nav-item -->
        <li class="nav-item delete-account">
            <a class="nav-link" href="/app/users/delete.php">Delete Account</a>
        </li><!-- /nav-item -->
        <?php else: ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/login.php' ? 'active' : ''; ?>" href="login.php">Login</a>
        </li><!-- /nav-item -->
        <li class="nav-item">
            <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/create.php' ? 'active' : ''; ?>" href="/create.php">Create Account</a>
        </li><!-- /nav-item -->
        <?php endif; ?>

    </ul><!-- /navbar-nav -->

    <ul class="navbar-nav mobile-nav">

        <?php if (!isset($_SESSION['user'])): ?>
        <li class="nav-item">
            <a class="nav-link" href="/index.php">Home</a>
        </li><!-- /nav-item -->
        <?php endif; ?>

        <?php if (isset($_SESSION['user'])): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/about.php' ? 'active' : ''; ?>" href="/about.php">About</a>
        </li><!-- /nav-item -->
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
            <a class="nav-link <?php echo $_SERVER['SCRIPT_NAME'] === '/create.php' ? 'active' : ''; ?>" href="/create.php">Create Account</a>
        </li><!-- /nav-item -->
        <?php endif; ?>

    </ul><!-- /navbar-nav -->

    <div class="menu-large mobile-nav">
        <img class="mobile-nav" src="/assets/icons/menu_large.svg" alt="menu">
    </div>

</nav><!-- /navbar -->
