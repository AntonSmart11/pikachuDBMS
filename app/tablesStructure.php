<?php
    include ("templates/header.php");

    mysqli_select_db($db, $_SESSION['database']);

    $_SESSION['table'] = $_GET['name'];

    $query = $db->query("SHOW COLUMNS FROM ".$_GET['name']);

    $fields = mysqli_fetch_all($query);
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
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Nulo</th>
                                <th>Llave</th>
                                <th>Default</th>
                                <th>Extra</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<count($fields); $i++): ?>
                                <tr>
                                    <th><div class="img-key">
                                        <?php if($fields[$i][3] == 'PRI'):?>
                                        <img src="../img/key_pk.png" alt="">
                                        <?php endif;?>
                                        <?php if($fields[$i][3] == 'MUL'):?>
                                        <img src="../img/key_fk.png" alt="">
                                        <?php endif;?>
                                        </div>
                                        <?php echo $fields[$i][0]; ?></th>
                                    <th><?php echo $fields[$i][1]; ?></th>
                                    <th><?php echo $fields[$i][2]; ?></th>
                                    <th><?php echo $fields[$i][3]; ?></th>
                                    <th><?php echo $fields[$i][4]; ?></th>
                                    <th><?php echo $fields[$i][5]; ?></th>
                                    <th><a href="tablesEdit.php?table=<?php echo $_GET['name']; ?>&name=<?php echo $fields[$i][0]; ?>&type=<?php echo $fields[$i][1]; ?>&null=<?php echo $fields[$i][2]; ?>&pk=<?php echo $fields[$i][3]; ?>&extra=<?php echo $fields[$i][5]; ?>">Cambiar</a> <a href="tablesDropColumn.php?table=<?php echo $_GET['name']; ?>&name=<?php echo $fields[$i][0]; ?>">Eliminar</a></th>
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