<?php
    session_start();   

    if(!isset($_SESSION['server'],$_SESSION['user'],$_SESSION['pass'])) {
        header('Location: ../index.php');
    }

?>