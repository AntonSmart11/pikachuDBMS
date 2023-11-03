<?php
    include ("templates/header.php");

    mysqli_select_db($db, $_SESSION['database']);

    $errores = [];

    //Obteniendo datos del método GET
    if($_SERVER['REQUEST_METHOD'] === 'GET') {

        $_SESSION['column'] = $_GET['name'];

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $result = false;

        try {
            $result = $db->query("ALTER TABLE ".$_SESSION['table']." DROP COLUMN ".$_SESSION['column']);
        } catch (Exception $e) {
            $errores[] = substr(mysqli_error($db), 0, 36);
        }
        
        if($result) {
            echo "<script>window.location.href='tablesStructure.php?name=".$_SESSION['table']."&delete=1'</script>";
        }

    }
?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <?php routeDB($_SESSION['database']); ?>
                    <h2 class="text-center">Eliminar columna: <?php echo $_SESSION['column']; ?></h2>
                </div>
                <form action="tablesDropColumn.php" method="POST">
                    <div class="text-center mt-5">
                        <a class="btn btn-secondary mb-4" href="tablesStructure.php?name=<?php echo $_SESSION['table']; ?>">Cancelar</a>
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