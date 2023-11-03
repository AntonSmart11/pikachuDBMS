<?php
    include ("templates/header.php");

    mysqli_select_db($db, $_SESSION['database']);

    $errores = [];

    //Obteniendo datos del método GET
    if($_SERVER['REQUEST_METHOD'] === 'GET') {

        $_SESSION['pk'] = $_GET['pk'];
        $_SESSION['pkValue'] = $_GET['id'];

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $result = false;

        try {
            $result = $db->query("DELETE FROM ".$_SESSION['table']." WHERE ".$_SESSION['pk']."=".$_SESSION['pkValue']);
        } catch (Exception $e) {
            $errores[] = substr(mysqli_error($db), 0, 36);
        }

        if($result) {
            echo '<script>window.location.href="tables.php?name='.$_SESSION['table'].'&delete=1"</script>';
        }
        
    }
?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <?php routeDBTable($_SESSION['database'], $_SESSION['table']); ?>
                    <h2 class="text-center">Eliminar dato</h2>
                </div>
                <form action="tablesDelete.php" method="POST">
                    <div class="text-center mt-5">
                        <a class="btn btn-secondary mb-4" href="tables.php?name=<?php echo $_SESSION['table']; ?>">Cancelar</a>
                        <?php echo submit('Eliminar'); ?>
                    </div>
                </form>
                <?php
                    foreach($errores as $error): 
                        echo alert("danger", $error);
                    endforeach;
                ?>
            </div>
        </div>
    </div>
<?php
    include ("templates/footer.php");