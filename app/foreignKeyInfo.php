<?php
    include ("templates/header.php");

    mysqli_select_db($db, $_SESSION['database']);

    $errores = [];

    $query = $db->query("SELECT TABLE_SCHEMA, TABLE_NAME, CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = '".$_SESSION['database']."' AND CONSTRAINT_TYPE = 'FOREIGN KEY'");

?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <?php routeDB($_SESSION['database']); ?>
                    <h2 class="text-center">Llaves Foráneas</h2>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Base de datos</th>
                                <th>Tabla</th>
                                <th>Llave foránea</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($tables = mysqli_fetch_assoc($query)): ?>
                                <tr>
                                    <th><?php echo $tables['TABLE_SCHEMA'] ?></th>
                                    <th><?php echo $tables['TABLE_NAME'] ?></th>
                                    <th><?php echo $tables['CONSTRAINT_NAME'] ?></th>
                                    <th><a href="fkDrop.php?name=<?php echo $tables['CONSTRAINT_NAME']; ?>&table=<?php echo $tables['TABLE_NAME']; ?>">Eliminar</a></th>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php
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