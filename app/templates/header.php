<?php
    require '../includes/security.php';

    require '../includes/database.php';

    include ("../includes/functions.php");

    $db = connectDB($_SESSION['server'],$_SESSION['user'],$_SESSION['pass']);

    $query = $db->query("SHOW DATABASES");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Pikachu DBMS</title>
</head>
<body>
    <div class="container1">
        <div class="navigation">
            <div class="div_face_pikachu">
                <div id="pikachu">
                    <div class="eye left"></div>
                    <div class="eye right"></div>
                    <div class="nose"></div>
                    <div class="ridiculousMouth">
                        <div></div>
                    </div>
                    <div class="cheek left"></div>
                    <div class="cheek right"></div>
                </div>
            </div>
            <a href="index.php"><h2 class="text-center"><span class="pokemon_font">Pikachu DBMS</span></h2></a>
            <div class="d-flex justify-content-center">
                <a href="../includes/logout.php" class="btn btn-danger">Cerrar sesión</a>
            </div>
            <div class="ms-2 mt-3">
                <p><span class="pokemon_font">Bases de Datos</span></p>
                <ul class="navigation_items">
                    <?php 
                        while($database = mysqli_fetch_assoc($query)): 
                            $query_tables = $db->query("SHOW TABLES FROM ".$database['Database']);
                    ?>
                        <li class="db">
                            <a href="databases.php?name=<?php echo $database['Database']; ?>"><?php echo $database['Database']; ?></a>
                        </li>
                        <div class="contain_tables">
                            <?php while($tables_list = mysqli_fetch_assoc($query_tables)): $tables_db = 'Tables_in_'.$database['Database']; ?>
                                <li class="<?php echo $database['Database']; ?>_db hidden tables">
                                    <a href="tables.php?name=<?php echo $tables_list[$tables_db]; ?>"><?php echo $tables_list[$tables_db]; ?></a>
                                </li>
                            <?php endwhile; ?>
                        </div>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
        <div class="main">
            <div class="topbar">
                <?php
                    if(str_contains($_SERVER["REQUEST_URI"], 'index') == 1) {
                        buttonModal('createDB', 'Crear Base de Datos');
                    }
                    if(str_contains($_SERVER["REQUEST_URI"], 'databases') == 1) {
                        buttonModal('createTable', 'Crear Tabla');
                        buttonModal('createFK', 'Crear Llave Foránea');
                        echo '<a href="foreignKeyInfo.php" class="btn submit">Llaves Foráneas</a>';
                    }
                ?>
                <a href="sql.php" class="btn submit">SQL</a>
            </div>