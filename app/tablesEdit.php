<?php
    include ("templates/header.php");

    mysqli_select_db($db, $_SESSION['database']);

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'GET') {

        if(isset($_GET['table'])) {
            if($_GET['table'] == '') {
                echo "<script>window.location.href='databases.php?name=".$_SESSION['database']."&error=1'</script>";
            }
    
            $_SESSION['table'] = $_GET['table'];
            $name = $_GET['name'];
            $_SESSION['column_name1'] = $_GET['name'];
            $type = substr($_GET['type'], 0, strrpos($_GET['type'], '(', 0));
            $length = substr(substr($_GET['type'], strrpos($_GET['type'], '(', 0)+1), 0, -1);
            $null = $_GET['null'];
            $pk = $_GET['pk'];
            $ai = $_GET['extra'];

            $int = FALSE;
            $varchar = FALSE;
            $text = FALSE;
            $date = FALSE;
            $tinyint = FALSE;
            $smallint = FALSE;
            $mediumint = FALSE;
            $bigint = FALSE;
            $decimal = FALSE;
            $float = FALSE;
            $double = FALSE;
            $real = FALSE;
            $bit = FALSE;
            $serial = FALSE;
            $datetime = FALSE;
            $timestamp = FALSE;
            $time = FALSE;
            $year = FALSE;
            $char = FALSE;
            $tinytext = FALSE;
            $text = FALSE;
            $mediumtext = FALSE;
            $binary = FALSE;
            $varbinary = FALSE;
            $tinyblob = FALSE;
            $blob = FALSE;
            $mediumblob = FALSE;
            $longblob = FALSE;
            $enum = FALSE;
            $set = FALSE;

            switch($type):

                case 'int':
                    $int = TRUE;
                break;

                case 'varchar':
                    $varchar = TRUE;
                break;

                case 'text':
                    $text = TRUE;
                break;

                case 'date':
                    $date = TRUE;
                break;

                case 'tinyint':
                    $tinyint = TRUE;
                break;

                case 'smallint':
                    $smallint = TRUE;
                break;

                case 'mediumint':
                    $mediumint = TRUE;
                break;

                case 'bigint':
                    $bigint = TRUE;
                break;

                case 'decimal':
                    $decimal = TRUE;
                break;

                case 'float':
                    $float = TRUE;
                break;

                case 'double':
                    $double = TRUE;
                break;

                case 'real':
                    $real = TRUE;
                break;

                case 'bit':
                    $bit = TRUE;
                break;

                case 'serial':
                    $serial = TRUE;
                break;

                case 'datetime':
                    $datetime = TRUE;
                break;

                case 'timestamp':
                    $timestamp = TRUE;
                break;

                case 'time':
                    $time = TRUE;
                break;

                case 'year':
                    $year = TRUE;
                break;

                case 'char':
                    $char = TRUE;
                break;

                case 'tinytext':
                    $tinytext = TRUE;
                break;

                case 'text':
                    $text = TRUE;
                break;

                case 'mediumtext':
                    $mediumtext = TRUE;
                break;

                case 'binary':
                    $binary = TRUE;
                break;

                case 'varbinary':
                    $varbinary = TRUE;
                break;

                case 'tinyblob':
                    $tinyblob = TRUE;
                break;

                case 'blob':
                    $blob = TRUE;
                break;

                case 'mediumblob':
                    $mediumblob = TRUE;
                break;

                case 'longblob':
                    $longblob = TRUE;
                break;

                case 'enum':
                    $enum = TRUE;
                break;

                case 'set':
                    $set = TRUE;
                break;

            endswitch;

            $nullValue = false;
            $pkValue = false;
            $aiValue = false;

            if($null == 'NO') {
                $nullValue = true;
            }

            $_SESSION['pk'] = false;
            if($pk == 'PRI') {
                $pkValue = true;
                $_SESSION['pk'] = $pkValue;
            }

            if($ai == 'auto_increment') {
                $aiValue = true;
            }

        } else {
            echo "<script>window.location.href='index.php'</script>";
        }

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = $_POST['name'];
        $type = $_POST['type'];
        $length = $_POST['length'];

        $nullValue = false;
        $pkValue = false;
        $aiValue = false;

        if(isset($_POST['null'])){
            $null = $_POST['null'];

            if($null == 'NOT NULL') {
                $nullValue = true;
            }
        }

        if(isset($_POST['pk'])){
            $pk = $_POST['pk'];

            if($pk == 'PRIMARY KEY') {
                $pkValue = true;
            }
        }

        if(isset($_POST['ai'])){
            $ai = $_POST['ai'];

            if($ai == 'AUTO_INCREMENT') {
                $aiValue = true;
            }
        }

        $int = FALSE;
        $varchar = FALSE;
        $text = FALSE;
        $date = FALSE;
        $tinyint = FALSE;
        $smallint = FALSE;
        $mediumint = FALSE;
        $bigint = FALSE;
        $decimal = FALSE;
        $float = FALSE;
        $double = FALSE;
        $real = FALSE;
        $bit = FALSE;
        $serial = FALSE;
        $datetime = FALSE;
        $timestamp = FALSE;
        $time = FALSE;
        $year = FALSE;
        $char = FALSE;
        $tinytext = FALSE;
        $text = FALSE;
        $mediumtext = FALSE;
        $binary = FALSE;
        $varbinary = FALSE;
        $tinyblob = FALSE;
        $blob = FALSE;
        $mediumblob = FALSE;
        $longblob = FALSE;
        $enum = FALSE;
        $set = FALSE;

        switch($type):

            case 'INT':
                $int = TRUE;
            break;

            case 'VARCHAR':
                $varchar = TRUE;
            break;

            case 'TEXT':
                $text = TRUE;
            break;

            case 'DATE':
                $date = TRUE;
            break;

            case 'TINYINT':
                $tinyint = TRUE;
            break;

            case 'SMALLINT':
                $smallint = TRUE;
            break;

            case 'MEDIUMINT':
                $mediumint = TRUE;
            break;

            case 'BIGINT':
                $bigint = TRUE;
            break;

            case 'DECIMAL':
                $decimal = TRUE;
            break;

            case 'FLOAT':
                $float = TRUE;
            break;

            case 'DOUBLE':
                $double = TRUE;
            break;

            case 'REAL':
                $real = TRUE;
            break;

            case 'BIT':
                $bit = TRUE;
            break;

            case 'SERIAL':
                $serial = TRUE;
            break;

            case 'DATETIME':
                $datetime = TRUE;
            break;

            case 'TIMESTAMP':
                $timestamp = TRUE;
            break;

            case 'TIME':
                $time = TRUE;
            break;

            case 'YEAR':
                $year = TRUE;
            break;

            case 'CHAR':
                $char = TRUE;
            break;

            case 'TINYTEXT':
                $tinytext = TRUE;
            break;

            case 'TEXT':
                $text = TRUE;
            break;

            case 'MEDIUMTEXT':
                $mediumtext = TRUE;
            break;

            case 'BINARY':
                $binary = TRUE;
            break;

            case 'VARBINARY':
                $varbinary = TRUE;
            break;

            case 'TINYBLOB':
                $tinyblob = TRUE;
            break;

            case 'BLOB':
                $blob = TRUE;
            break;

            case 'MEDIUMBLOB':
                $mediumblob = TRUE;
            break;

            case 'LONGBLOB':
                $longblob = TRUE;
            break;

            case 'ENUM':
                $enum = TRUE;
            break;

            case 'SET':
                $set = TRUE;
            break;

        endswitch;
            
        if(isset($_POST['name'],$_POST['length'])) {
            
            if($_POST['name'] == '') {
                $errores[] = "Campo nombre vacío";
            }

            if(!isset($_POST['type'])) {
                $errores[] = "Campo tipo vacío";
            }

            if(isset($_POST['length'])) {
                if(!is_numeric($_POST['length'])) {
                    if(str_contains($_POST['length'], ',')) {
                        $dec = explode(',', $_POST['length']);
                        
                        $numeric = true;

                        for ($i=0; $i < count($dec); $i++) { 
                            if(!is_numeric($dec[$i])) {
                                $numeric = false;
                            }
                        }

                        if($numeric) {
                            if(!(count($dec) == 2)) {
                                echo 'llego';
                                $errores[] = "Introduce un valor válido en el campo longitud/valores";
                            }
                        }
                        
                    } else {
                        $errores[] = "Introduce un valor válido en el campo longitud/valores";
                    }
                }
            }

        } else {
            echo "<script>window.location.href='index.php'</script>";
        }

        if(empty($errores)) {

            $fields = "";

            $name = $_POST['name'];
            $type = $_POST['type'];
            $length = $_POST['length'];

            $fields = "$name $type";

            if($_POST['length'] != '') {
                $fields .= "($length) ";
            }

            if(isset($_POST['null'])) {
                $fields .= $_POST['null'] . ' ';
            } else {
                $fields .= 'NULL ';
            }

            if(isset($_POST['pk'])) {
                if(!$_SESSION['pk']) {
                    $fields .= $_POST['pk'] . ' ';
                }
            } else {
                if($_SESSION['pk']) {
                    $queryPK = "ALTER TABLE ".$_SESSION['table']." DROP PRIMARY KEY";
                }
            }

            if(isset($_POST['ai'])) {
                $fields .= $_POST['ai'] . ' ';
            }

            $fields .= ",";

            $fields = substr($fields, 0, -2);

            $query = "ALTER TABLE ".$_SESSION['table']." CHANGE ".$_SESSION['column_name1']." $fields";

            $result = false;

            try {
                $result = $db->query($query);
                if(isset($queryPK)) {
                    $result = $db->query($queryPK);
                }
            } catch (Exception $e) {
                $errores[] = substr(mysqli_error($db), 0, 36);
            }

            if($result) {
                $warning = 'Creado correctamente';

                echo "<script>window.location.href='tablesStructure.php?name=".$_SESSION['table']."&change=1'</script>";
            }
        }
    }
?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <?php routeDBTableStructure($_SESSION['database'], $_SESSION['table']); ?>
                    <h2 class="text-center">Editar Columna: <?php echo $_SESSION['column_name1']; ?></h2>
                </div>
                <form method="POST" action="tablesEdit.php">
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
                                <tr>
                                    <th><?php echo 1?></th>
                                    <th><?php labelSimple('text', 'name', $name) ?></th>
                                    <th><?php echo selectSimple(
                                        optionSimpleSelected('INT', 'INT', $int).
                                        optionSimpleSelected('VARCHAR', 'VARCHAR', $varchar).
                                        optionSimpleSelected('TEXT', 'TEXT', $text).
                                        optionSimpleSelected('DATE', 'DATE', $date).
                                        optionSimpleDisabled('').
                                        optionSimpleDisabled('Numérico').
                                        optionSimpleSelected('TINYINT', 'TINYINT', $tinyint).
                                        optionSimpleSelected('SMALLINT', 'SMALLINT', $smallint).
                                        optionSimpleSelected('MEDIUMINT', 'MEDIUMINT', $mediumint).
                                        optionSimpleSelected('INT', 'INT', $int).
                                        optionSimpleSelected('BIGINT', 'BIGINT', $bigint).
                                        optionSimpleDisabled('-').
                                        optionSimpleSelected('DECIMAL', 'DECIMAL', $decimal).
                                        optionSimpleSelected('FLOAT', 'FLOAT', $float).
                                        optionSimpleSelected('DOUBLE', 'DOUBLE', $double).
                                        optionSimpleSelected('REAL', 'REAL', $real).
                                        optionSimpleDisabled('-').
                                        optionSimpleSelected('BIT', 'BIT', $bit).
                                        optionSimpleSelected('BOOLEAN', 'DATE', $date).
                                        optionSimpleSelected('SERIAL', 'SERIAL', $serial).
                                        optionSimpleDisabled('').
                                        optionSimpleDisabled('Fecha').
                                        optionSimpleSelected('DATE', 'DATE', $date).
                                        optionSimpleSelected('DATETIME', 'DATETIME', $datetime).
                                        optionSimpleSelected('TIMESTAMP', 'TIMESTAMP', $timestamp).
                                        optionSimpleSelected('TIME', 'TIME', $time).
                                        optionSimpleSelected('YEAR', 'YEAR', $year).
                                        optionSimpleDisabled('').
                                        optionSimpleDisabled('Cadena').
                                        optionSimpleSelected('CHAR', 'CHAR', $char).
                                        optionSimpleSelected('VARCHAR', 'VARCHAR', $varchar).
                                        optionSimpleDisabled('-').
                                        optionSimpleSelected('TINYTEXT', 'TINYTEXT', $tinytext).
                                        optionSimpleSelected('TEXT', 'TEXT', $text).
                                        optionSimpleSelected('MEDIUMTEXT', 'MEDIUMTEXT', $mediumtext).
                                        optionSimpleSelected('DATE', 'DATE', $date).
                                        optionSimpleDisabled('-').
                                        optionSimpleSelected('BINARY', 'BINARY', $binary).
                                        optionSimpleSelected('VARBINARY', 'VARBINARY', $varbinary).
                                        optionSimpleDisabled('-').
                                        optionSimpleSelected('TINYBLOB', 'TINYBLOB', $tinyblob).
                                        optionSimpleSelected('BLOB', 'BLOB', $blob).
                                        optionSimpleSelected('MEDIUMBLOB', 'MEDIUMBLOB', $mediumblob).
                                        optionSimpleSelected('LONGBLOB', 'LONGBLOB', $longblob).
                                        optionSimpleDisabled('-').
                                        optionSimpleSelected('ENUM', 'ENUM', $enum).
                                        optionSimpleSelected('SET', 'SET', $set)
                                    , 'type') ?></th>
                                    <th><?php labelSimple('text', 'length', $length) ?></th>
                                    <th><?php checkboxSimpleSelected('PRIMARY KEY', 'pk', $pkValue) ?></th>
                                    <th><?php checkboxSimpleSelected('NOT NULL', 'null', $nullValue) ?></th>
                                    <th><?php checkboxSimpleSelected('AUTO_INCREMENT', 'ai', $aiValue) ?></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <?php echo submit('Actualizar'); ?>
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