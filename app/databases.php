<?php
    include ("templates/header.php");

    $_SESSION['database'] = $_GET['name'];

    mysqli_select_db($db, $_SESSION['database']);

    $query = $db->query("SHOW TABLES");

    $query = $db->query("SELECT TABLE_NAME, TABLE_ROWS, ENGINE, DATA_LENGTH FROM information_schema.tables WHERE TABLE_SCHEMA = '".$_SESSION['database']."'");

    $tables = mysqli_fetch_all($query);

    $tables_db = 'Tables_in_'.$_GET['name'];
?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <h2 class="text-center">Base de Datos: <?php echo $_GET['name']; ?></h2>
                </div>
                <div class="table-responsive">
                    <table id="databases" class="table">
                        <thead>
                            <tr>
                                <th>Tabla</th>
                                <th>Filas</th>
                                <th>Motor</th>
                                <?php 
                                    if($_SESSION['database'] != 'information_schema'): 
                                    if($_SESSION['database'] != 'performance_schema'):
                                ?>
                                <th>Acciones</th>
                                <?php 
                                    endif; 
                                    endif; 
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                for ($i=0; $i < count($tables); $i++):
                            ?>
                                <tr>
                                    <th><a href="tables.php?name=<?php echo $tables[$i][0]; ?>"><?php echo $tables[$i][0]; ?></a></th>
                                    <th><?php 
                                        if($_SESSION['database'] != 'information_schema') {
                                            $query2 = $db->query('SELECT * FROM '.$tables[$i][0]);

                                            echo $query2->num_rows;
                                        } else {
                                            echo '~0';
                                        }
                                        
                                    ?></th>
                                    <th><?php echo $tables[$i][2]; ?></th>
                                    <?php 
                                        if($_SESSION['database'] != 'information_schema'): 
                                        if($_SESSION['database'] != 'performance_schema'):
                                    ?>
                                        <th><a href="tables.php?name=<?php echo $tables[$i][0]; ?>">Examinar</a> <a href="tablesStructure.php?name=<?php echo $tables[$i][0]; ?>">Estructura</a> <a href="tablesInsert.php?name=<?php echo $tables[$i][0]; ?>">Insertar</a> <a href="tablesDrop.php?name=<?php echo $tables[$i][0]; ?>">Eliminar</a></th>
                                    <?php 
                                        endif; 
                                        endif; 
                                    ?>
                                </tr>
                            <?php
                                endfor;
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                    if(isset($_GET['create'])) {
                        if($_GET['create'] == 1) {
                            alert('success', 'Se ha creado correctamente');
                        }
                    }
                    if(isset($_GET['delete'])) {
                        if($_GET['delete'] == 1) {
                            alert('success', 'Se ha eliminado correctamente');
                        }
                    }
                    if(isset($_GET['error'])) {
                        if($_GET['error'] == 1) {
                            alert('danger', 'Campo vacío');
                        }
                    }
                ?>
            </div>
        </div>
    </div>
<?php
    modal('createTable', 'Crear Tabla', 
        formGet('tablesCreate.php', 
            label('text', 'table', 'Nombre de la Tabla').
            label('number', 'num', 'Número de Columnas').
            '<div class="d-flex justify-content-end">'.
                submit('Confirmar').
            '</div>'
        )
    );

    $options = '';

    $queryOptions = $db->query("SHOW TABLES");

    if($queryOptions->num_rows > 0) {
        while($tables = mysqli_fetch_assoc($queryOptions)) {
            $options .= optionSimple($tables[$tables_db], $tables[$tables_db]);
        }
    }

    modal('createFK', 'Crear Llave Foránea', 
        formGet('foreignKey.php', 
            select('table1', 'Tabla madre', $options).
            select('table2', 'Tabla foránea', $options).
            '<div class="d-flex justify-content-end mt-3">'.
                submit('Confirmar').
            '</div>'
        )
    );

    include ("templates/footer.php");
?>