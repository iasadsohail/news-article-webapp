<nav class="top-navbar">
    <div class="top-navbar-brand">
        NEWS APP
    </div>
    <ul class="top-navbar-items">
        <li class="top-navbar-item">
            <a class="top-navbar-link" href=".">Home</a>
        </li>
        <li class="top-navbar-item">
            <a class="top-navbar-link" href="articles.php">Articles</a>
        </li>
        <?php
        if ($user_name == '') {
            echo '
                <li class="top-navbar-item">
                    <a class="top-navbar-link" href="user/login.php">Login</a>
                </li>
                <li class="top-navbar-item">
                    <a class="top-navbar-link" href="user/register.php">Register</a>
                </li>
            ';
        } else {
            if (strtoupper($user_type) == 'ADMIN') {
                echo '
                    <li class="top-navbar-item">
                        <a class="top-navbar-link" href="admin/">Admin-Panel</a>
                    </li>
                ';
            }
            echo '
                <li class="top-navbar-item">
                    <a class="top-navbar-link" href="user/logout.php">LogOut</a>
                </li>
            ';
        }

        ?>
    </ul>
</nav>