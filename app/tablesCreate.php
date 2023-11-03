<?php
    include ("templates/header.php");

    if($_SESSION['database'] == '') {
        echo "<script>window.location.href='index.php'</script>";
    }

    mysqli_select_db($db, $_SESSION['database']);

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'GET') {

        if(isset($_GET['table'], $_GET['num'])) {
            if($_GET['table'] == '' || $_GET['num'] == '') {
                echo "<script>databases.php?name=".$_SESSION['database']."&error=1'</script>";
            }
    
            $_SESSION['table'] = $_GET['table'];
            $_SESSION['num'] = $_GET['num'];
        } else {
            echo "<script>window.location.href='index.php'</script>";
        }

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        for ($i=0; $i < $_SESSION['num']; $i++):
            
            if(isset($_POST['name'.$i],$_POST['length'.$i])) {
                
                if($_POST['name'.$i] == '') {
                    $errores[] = "Campo ". $i+1 ." nombre vacío";
                }

                if(!isset($_POST['type'.$i])) {
                    $errores[] = "Campo ". $i+1 ." tipo vacío";
                }

                if(isset($_POST['length'.$i])) {
                    if(!is_numeric($_POST['length'.$i])) {
                        if(str_contains($_POST['length'.$i], ',')) {
                            $dec = explode(',', $_POST['length'.$i]);
                            
                            $numeric = true;

                            for ($i=0; $i < count($dec); $i++) { 
                                if(!is_numeric($dec[$i])) {
                                    $numeric = false;
                                }
                            }

                            if($numeric) {
                                if(!(count($dec) == 2)) {
                                    $errores[] = "Introduce un valor válido en el campo ".$i+1 ." longitud/valores";
                                }
                            }
                            
                        } else {
                            $errores[] = "Introduce un valor válido en el campo ".$i+1 ." longitud/valores";
                        }
                    }
                }

            } else {
                echo "<script>window.location.href='index.php'</script>";
            }

        endfor;

        if(empty($errores)) {

            $fields = "";
            $typeText = '';

            for($i=0; $i<$_SESSION['num']; $i++):

                $name[] = $_POST['name'.$i];
                $type[] = substr($_POST['type'.$i], 0, -1);
                $length[] = $_POST['length'.$i];

                $fields .= "$name[$i] $type[$i] ";

                if($_POST['length'.$i] != '') {
                    $fields .= "($length[$i]) ";
                }

                if(isset($_POST['null'.$i])) {
                    $fields .= $_POST['null'.$i] . ' ';
                }

                if(isset($_POST['pk'.$i])) {
                    $fields .= $_POST['pk'.$i] . ' ';
                }

                if(isset($_POST['ai'.$i])) {
                    $fields .= $_POST['ai'.$i] . ' ';
                }

                $fields .= ",";

            endfor;

            $fields = substr($fields, 0, -2);

            $query = "CREATE TABLE ".$_SESSION['table']." ($fields)";

            $result = false;

            try {
                $result = $db->query($query);
            } catch (Exception $e) {
                $errores[] = substr(mysqli_error($db), 0, 36);
            }

            if($result) {
                $warning = 'Creado correctamente';
                
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
                    <h2 class="text-center">Nueva Tabla: <?php echo $_SESSION['table']; ?></h2>
                </div>
                <form method="POST" action="tablesCreate.php">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Longitud/Valores</th>
                                    <th>Llave Primaria</th>
                                    <th>No Nulo</th>
                                    <th>Autoincremental</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i=0; $i < $_SESSION['num']; $i++): ?>
                                    <tr>
                                        <th><?php echo $i + 1 ?></th>
                                        <th><?php labelSimple('text', 'name'.$i, '') ?></th>
                                        <th><?php echo selectSimple(
                                            optionSimple('INT'.$i, 'INT').
                                            optionSimple('VARCHAR'.$i, 'VARCHAR').
                                            optionSimple('TEXT'.$i, 'TEXT').
                                            optionSimple('DATE'.$i, 'DATE').
                                            optionSimpleDisabled('').
                                            optionSimpleDisabled('Numérico').
                                            optionSimple('TINYINT'.$i, 'TINYINT').
                                            optionSimple('SMALLINT'.$i, 'SMALLINT').
                                            optionSimple('MEDIUMINT'.$i, 'MEDIUMINT').
                                            optionSimple('INT'.$i, 'INT').
                                            optionSimple('BIGINT'.$i, 'BIGINT').
                                            optionSimpleDisabled('-').
                                            optionSimple('DECIMAL'.$i, 'DECIMAL').
                                            optionSimple('FLOAT'.$i, 'FLOAT').
                                            optionSimple('DOUBLE'.$i, 'DOUBLE').
                                            optionSimple('REAL'.$i, 'REAL').
                                            optionSimpleDisabled('-').
                                            optionSimple('BIT'.$i, 'BIT').
                                            optionSimple('BOOLEAN'.$i, 'DATE').
                                            optionSimple('SERIAL'.$i, 'SERIAL').
                                            optionSimpleDisabled('').
                                            optionSimpleDisabled('Fecha').
                                            optionSimple('DATE'.$i, 'DATE').
                                            optionSimple('DATETIME'.$i, 'DATETIME').
                                            optionSimple('TIMESTAMP'.$i, 'TIMESTAMP').
                                            optionSimple('TIME'.$i, 'TIME').
                                            optionSimple('YEAR'.$i, 'YEAR').
                                            optionSimpleDisabled('').
                                            optionSimpleDisabled('Cadena').
                                            optionSimple('CHAR'.$i, 'CHAR').
                                            optionSimple('VARCHAR'.$i, 'VARCHAR').
                                            optionSimpleDisabled('-').
                                            optionSimple('TINYTEXT'.$i, 'TINYTEXT').
                                            optionSimple('TEXT'.$i, 'TEXT').
                                            optionSimple('MEDIUMTEXT'.$i, 'MEDIUMTEXT').
                                            optionSimple('LONGTEXT'.$i, 'DATE').
                                            optionSimpleDisabled('-').
                                            optionSimple('BINARY'.$i, 'BINARY').
                                            optionSimple('VARBINARY'.$i, 'VARBINARY').
                                            optionSimpleDisabled('-').
                                            optionSimple('TINYBLOB'.$i, 'TINYBLOB').
                                            optionSimple('BLOB'.$i, 'BLOB').
                                            optionSimple('MEDIUMBLOB'.$i, 'MEDIUMBLOB').
                                            optionSimple('LONGBLOB'.$i, 'LONGBLOB').
                                            optionSimpleDisabled('-').
                                            optionSimple('ENUM'.$i, 'ENUM').
                                            optionSimple('SET'.$i, 'SET')
                                        , 'type'.$i) ?></th>
                                        <th><?php labelSimple('text', 'length'.$i, '') ?></th>
                                        <th><?php checkboxSimple('PRIMARY KEY', 'pk'.$i) ?></th>
                                        <th><?php checkboxSimple('NOT NULL', 'null'.$i) ?></th>
                                        <th><?php checkboxSimple('AUTO_INCREMENT', 'ai'.$i) ?></th>
                                    </tr>
                                <?php endfor ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <?php echo submit('Crear'); ?>
                    </div>
                </form>
                <?php
                    if(isset($warning)) {
                        alert('success', $warning);
                    }
                ?>
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