<?php
    include ("templates/header.php");

    mysqli_select_db($db, $_SESSION['database']);

    $query = $db->query("SHOW COLUMNS FROM ".$_GET['name']);

    $fields = mysqli_fetch_all($query);

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        for($i=0; $i<count($fields); $i++):
            $data[] = $fields[$i][0];
        endfor;

        //Obtengo la tabla para la consulta
        $table = $_GET['name'];

        //Obtengo los campos de la tabla para la consulta
        $keys = '';

        for($i=0; $i<count($data); $i++):
            $keys .= "$data[$i],";
        endfor;

        $keys = substr($keys, 0, -1);

        //Obtengo los valores del método POST para la consulta
        $values = '';

        for($i=0; $i<count($data); $i++):
            $values .= "'".$_POST[$data[$i]]."',";
        endfor;

        $values = substr($values, 0, -1);
        
        //Creo la consulta INSERT
        $insert = "INSERT INTO $table ($keys) VALUES ($values)";

        $result = false;

        try {
            $result = $db->query($insert);
        } catch (Exception $e) {
            $errores[] = substr(mysqli_error($db), 0, 64);
        }

        if($result) {
            $warning = 'Insertado correctamente';
        }
    }
?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <?php routeDB($_SESSION['database']); ?>
                    <h2 class="text-center">Tabla: <?php echo $_GET['name']; ?></h2>
                </div>
                <form method="POST" action="tablesInsert.php?name=<?php echo $_GET['name']; ?>">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($i=0; $i<count($fields); $i++): ?>
                                    <tr>
                                        <th><?php echo $fields[$i][0]; ?></th>
                                        <th><?php echo $fields[$i][1]; ?></th>
                                        <th><?php labelSimple('text', $fields[$i][0],''); ?></th>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <?php echo submit('Insertar'); ?>
                    </div>
                </form>
                <?php
                    if(isset($warning)) {
                        alert('success', $warning);
                    }
                ?>
                <?php foreach($errores as $error):
                    alert('danger', $error);
                endforeach; ?>
            </div>
        </div>
    </div>
<?php
    include ("templates/footer.php");
?>