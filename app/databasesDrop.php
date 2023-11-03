<?php
    include ("templates/header.php");

    $errores = [];

    //Obteniendo datos del método GET
    if($_SERVER['REQUEST_METHOD'] === 'GET') {

        $_SESSION['database'] = $_GET['db'];

    }

    //Obteniendo datos del método POST
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $result = false;

        try {
            $result = $db->query("DROP DATABASE ".$_SESSION['database']);
        } catch (Exception $e) {
            $errores[] = substr(mysqli_error($db), 0, 36);
        }

        if($result) {
            echo "<script>window.location.href='index.php?delete=1'</script>";
        }

    }
?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <?php routeDB($_SESSION['database']); ?>
                    <h2 class="text-center">Eliminar Base de Datos: <?php echo $_SESSION['database']; ?></h2>
                </div>
                <form action="databasesDrop.php" method="POST">
                    <div class="text-center mt-5">
                        <a class="btn btn-secondary mb-4" href="index.php">Cancelar</a>
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
?>