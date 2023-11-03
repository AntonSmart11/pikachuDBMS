<?php
    include ("templates/header.php");

    mysqli_select_db($db, $_SESSION['database']);

    $errores = [];

    //Obteniendo datos del método GET
    if($_SERVER['REQUEST_METHOD'] === 'GET') {

        $_SESSION['fk'] = $_GET['name'];
        $_SESSION['table'] = $_GET['table'];

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $result = false;

        $query = "ALTER TABLE ".$_SESSION['table']." DROP FOREIGN KEY ".$_SESSION['fk'];

        var_dump($query);

        try {
            $result = $db->query($query);
        } catch (Exception $e) {
            $errores[] = substr(mysqli_error($db), 0, 36);
        }

        if($result) {
            echo "<script>window.location.href='foreignKeyInfo.php?delete=1'</script>";
        }

    }
?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <?php routeDB($_SESSION['database']); ?>
                    <h2 class="text-center">Eliminar llave foránea: <?php echo $_SESSION['fk']; ?></h2>
                </div>
                <form action="fkDrop.php" method="POST">
                    <div class="text-center mt-5">
                        <a class="btn btn-secondary mb-4" href="foreignKeyInfo.php">Cancelar</a>
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