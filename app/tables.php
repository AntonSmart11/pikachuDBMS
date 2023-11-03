<?php
    include ("templates/header.php");

    mysqli_select_db($db, $_SESSION['database']);

    $_SESSION['table'] = $_GET['name'];

    try {
        $query1 = $db->query("SHOW COLUMNS FROM ".$_GET['name']);
        $query2 = $db->query("SELECT * FROM ".$_GET['name']);
        $query3 = $db->query("SHOW COLUMNS FROM ".$_GET['name']);

        $rows2 = Array();

        if($query2->num_rows > 0) {
            $rows2 = mysqli_fetch_all($query2);
            $listValues = array_values($rows2);
        }
    
        // Identificar si tiene Primary Key y guardar cuál campo es el del Primary Key
        $pk = false;
    
        while($field = mysqli_fetch_array($query3)):
            if($field['Key'] == 'PRI'){
                $pk = true;
                $fieldPk = $field['Field'];
            }
        endwhile;
    
        // Valor de la Primary Key
        if($pk) {
            $rows3 = [];
    
            $query4 = $db->query("SELECT $fieldPk FROM ".$_GET['name']);
            while($fieldPkValue = mysqli_fetch_array($query4)):
                $rows3[] = $fieldPkValue[0];
            endwhile;
        }
    } catch (Exception $e) {
        echo alert("danger", mysqli_error($db));
        exit;
    }

?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <?php routeDB($_SESSION['database']); ?>
                    <h2 class="text-center">Tabla: <?php echo $_GET['name']; ?></h2>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <?php while($field = mysqli_fetch_array($query1)): ?>
                                    <th><?php echo $field['Field']; ?></th>
                                <?php endwhile; ?>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<count($rows2); $i++): ?>
                                <tr>
                                    <?php for($j=0; $j<count($listValues[$i]); $j++): ?>
                                        <th><?php echo $listValues[$i][$j]; ?></th>
                                    <?php endfor; 
                                        if($pk):
                                    ?>
                                        <th><a href="tablesEditColumn.php?pk=<?php echo $fieldPk; ?>&id=<?php echo $rows3[$i]; ?>">Editar</a> <a href="tablesDelete.php?pk=<?php echo $fieldPk; ?>&id=<?php echo $rows3[$i]; ?>">Eliminar</a></th>
                                    <?php else: ?>
                                        <th></th>
                                    <?php endif; ?>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
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
                ?>
            </div>
        </div>
    </div>
<?php
    include ("templates/footer.php");
?>