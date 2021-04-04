<?php
    if (isset($_GET["e"])){
        include_once ("admin/logging.php");

        if ($_GET["e"] == "1")
        {
            echo "<h3> No username or password entered </h3>";
        }
        else if ($_GET["e"] == "2")
        {
            echo "<h3> Wrong information </h3>";
        }
        else if ($_GET["e"] == "3")
        {
            echo "<h3>Trying to enter page you don't have permission for / Insecure </h3>";
        }
        else if ($_GET["e"] == "4")
        {
            echo "Logged out";
        }
    }
?>