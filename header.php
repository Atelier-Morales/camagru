
<link href="css/style.css" rel="stylesheet">
<link href="http://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css" rel="stylesheet">

<header class="header">
    <h1 class="main-header">Camagru</h1>
    <ul class="header-subnav">
        <?php
        if (isset($username)) {
            echo '<li><a style="cursor:default;" href="#" class="is-active">Hello '.$username.'</a></li>';
            echo '<li><a href="index.php?logout">Logout</a></li>';
        }
        ?>
    </ul>
</header>
