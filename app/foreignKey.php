<?php
    include ("templates/header.php");

    mysqli_select_db($db, $_SESSION['database']);

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'GET') {

        if(isset($_GET['table1'], $_GET['table2'])) {
            if($_GET['table1'] != '' && $_GET['table2'] != '') {

                $_SESSION['table1'] = $_GET['table1'];
                $_SESSION['table2'] = $_GET['table2'];

            } else {
                echo "<script>window.location.href='databases.php?name=".$_SESSION['database']."&error=1'</script>";
            }
        } else {
            echo "<script>window.location.href='Location: databases.php?name=".$_SESSION['database']."&error=1'</script>";
        }
        
    }

    $table1 = $db->query("SHOW COLUMNS FROM ".$_SESSION['table1']);
    $table2 = $db->query("SHOW COLUMNS FROM ".$_SESSION['table2']);

    $options1 = '';
    $options2 = '';

    if($table1->num_rows > 0) {
        while($column = mysqli_fetch_assoc($table1)) {
            $options1 .= optionSimple($column['Field'], $column['Field']);
        }
    }

    if($table2->num_rows > 0) {
        while($column = mysqli_fetch_assoc($table2)) {
            $options2 .= optionSimple($column['Field'], $column['Field']);
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        if($_POST['fk'] == '') {
            $errores[] = "Campo nombre vacío";
        }

        if(is_numeric($_POST['fk'])) {
            $errores[] = "Coloca un nombre válido";
        }

        if(!isset($_POST['column1'])) {
            $errores[] = "Campo tabla madre vacío";
        }

        if(!isset($_POST['column2'])) {
            $errores[] = "Campo tabla foránea vacío";
        }

        if(empty($errores)) {

            $query = 'ALTER TABLE '.$_SESSION['table1'].' ADD CONSTRAINT '.$_POST['fk'].' FOREIGN KEY ('.$_POST['column1'].') REFERENCES '.$_SESSION['table2'].'('.$_POST['column2'].')';

            $result = false;

            try {
                $result = $db->query($query);
            } catch (Exception $e) {
                $errores[] = substr(mysqli_error($db), 0, 36);
            }

            if($result) {
                echo "<script>window.location.href='databases.php?name=".$_SESSION['database']."&create=1'</script>";
            }

        }

    }

?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <?php routeDB($_SESSION['database']); ?>
                    <h2 class="text-center">Llave Foránea</h2>
                </div>
                <form method="POST" action="foreignKey.php">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre de la Foreign Key</th>
                                    <th><?php echo 'Tabla madre: '.$_SESSION['table1'] ?></th>
                                    <th><?php echo 'Tabla foránea: '.$_SESSION['table2'] ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th><?php echo labelSimple('text', 'fk', '') ?></th>
                                    <th><?php echo selectSimple($options1, 'column1') ?></th>
                                    <th><?php echo selectSimple($options2, 'column2') ?></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <?php echo submit('Agregar'); ?>
                    </div>
                </form>
                <?php
                    if(isset($_GET['change'])) {
                        if($_GET['change'] == 1) {
                            alert('success', 'Se ha modificado correctamente');
                        }
                    }
                    if(isset($_GET['delete'])) {
                        if($_GET['delete'] == 1) {
                            alert('success', 'Se ha eliminado correctamente');
                        }
                    }
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