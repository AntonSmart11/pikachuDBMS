<?php
    session_start();

    unset($_SESSION['server']);
    unset($_SESSION['user']);
    unset($_SESSION['pass']);
    header("Location: ../index.php");