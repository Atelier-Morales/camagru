
<link href="css/style.css" rel="stylesheet">
<link href="http://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css" rel="stylesheet">

<header class="header">
    <h1 class="main-header">Camagru</h1>
    <ul class="header-subnav">
        <?php
        if (isset($username)) {
            if ($view == 1) {
                echo '<li><a href="index.php?home" class="is-active">Hello '. htmlspecialchars($username, ENT_QUOTES, "UTF-8").'</a></li>';
                echo '<li><a href="index.php?gallery">Gallery</a></li>';
            }
            else {
                echo '<li><a href="index.php?home" >Hello '.htmlspecialchars($username, ENT_QUOTES, "UTF-8").'</a></li>';
                echo '<li><a href="index.php?gallery" class="is-active">Gallery</a></li>';
            }

            echo '<li><a href="index.php?logout">Logout</a></li>';
        }
        ?>
    </ul>
</header>
