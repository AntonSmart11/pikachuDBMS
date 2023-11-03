<?php
    include ("templates/header.php");

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $result = false;

        try {
            $result = $query = $db->query("CREATE DATABASE ".$_POST['db']." COLLATE ".$_POST['collate']);
        } catch (Exception $e) {
            $errores[] = substr(mysqli_error($db), 0, 36);
        }

        if($result) {
            echo "<script>window.location.href='index.php?create=1'</script>";
        } else {
            echo "<script>window.location.href='index.php?error=1'</script>";
        }
    }

    include ("templates/footer.php");
?>