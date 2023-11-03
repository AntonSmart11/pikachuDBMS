<?php
    include ("templates/header.php");

    mysqli_select_db($db, $_SESSION['database']);

    $errores = [];

    //Obteniendo datos del método GET
    if($_SERVER['REQUEST_METHOD'] === 'GET') {

        $_SESSION['pk'] = $_GET['pk'];
        $_SESSION['pkValue'] = $_GET['id'];

    }

    //Organizando la información
    $query1 = $db->query("SHOW COLUMNS FROM ".$_SESSION['table']);
    $query2 = $db->query("SELECT * FROM ".$_SESSION['table']." WHERE ".$_SESSION['pk']."=".$_SESSION['pkValue']);
    $query3 = $db->query("SHOW COLUMNS FROM ".$_SESSION['table']);

    $keys = [];

    while($field = mysqli_fetch_array($query1)):
        $keys[] = $field['Field'];
    endwhile;

    $rows2 = Array();

    if($query2->num_rows > 0) {
        $rows2 = mysqli_fetch_all($query2);
        $listValues = array_values($rows2);
    }

    $rows3 = Array();

    if($query3->num_rows > 0) {
        $rows3 = mysqli_fetch_all($query3);
        $listKeys = array_keys($rows3);
    }

    //Obteniendo información del método POST
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        if($_POST[$_SESSION['pk']] == '') {
            $errores[] = 'Llave primaria vacía.';
        }

        if(empty($errores)) {

            $data = "";
            for($i=0; $i<count($listKeys); $i++):
    
                $data .= $rows3[$i][0].' = "'.$_POST[$rows3[$i][0]].'", ';
    
            endfor;

            $data = substr($data, 0, -2);
    
            $update = "UPDATE ".$_SESSION['table']." SET ".$data." WHERE ".$_SESSION['pk']." = ".$_SESSION['pkValue'];

            $result = false;
            
            try {
                $result = $db->query($update);
            } catch (Exception $e) {
                $errores[] = substr(mysqli_error($db), 0, 36);
            }

            if($result) {
                $warning = 'Creado correctamente';

                echo "<script>window.location.href='tables.php?name=".$_SESSION['table']."&change=1'</script>";
            }
        }
    }

?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <?php routeDBTable($_SESSION['database'], $_SESSION['table']); ?>
                    <h2 class="text-center">Columna id: <?php echo $_SESSION['pkValue']; ?></h2>
                </div>
                <form method="POST" action="tablesEditColumn.php">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <?php for($i=0; $i<count($keys); $i++): ?>
                                        <th><?php echo $keys[$i] ?></th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php for($i=0; $i<count($listValues[0]); $i++): ?>
                                        <th><?php labelSimple('text', $rows3[$i][0], $listValues[0][$i]) ?></th>
                                    <?php endfor; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <?php echo submit('Actualizar'); ?>
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