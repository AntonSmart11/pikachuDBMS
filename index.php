<?php
    include ("includes/functions.php");

    $errores = [];

    $server = '';
    $user = '';
    $pass = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        require 'includes/database.php';

        $server = $_POST["server"];
        $user = $_POST["user"];
        $pass = $_POST["pass"];

        if(!$server) {
            $errores[] = 'Campo servidor vacío';
        }
        if(!$user) {
            $errores[] = 'Campo usuario vacío';
        }

        if(empty($errores)) {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                connectDB($server, $user, $pass);

                session_start();
                $_SESSION['server'] = $server;
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;

                header('Location: app/index.php');
            } catch (Exception $e) {
                $errores[] = 'Datos incorrectos';
            }
            
        }

    }
?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Pikachu DBMS</title>
</head>
<body>
    <header class="headerPikachu d-flex justify-content-between align-items-center">
        <div class="hero">
            <img src="img/hero_sprites.png" alt="">
        </div>
        <img class="pokeball_pixel" src="img/pokeball_pixel.png" alt="pokeball" id="image">
        <div class="pikachu">
            <img src="img/pikachu_sprites.png" alt="">
        </div>
    </header>
    <main>
        <section class="container d-flex justify-content-center align-items-center flex-wrap">  
            <div class="pikachu_hide"></div>
            <form class="formPikachu mx-auto text-center" action="index.php" method="POST">
                <div class="text-center presentation my-5">
                    <h1>---- <span class="pokemon_font">Pikachu DBMS</span> ----</h1>
                </div>

                <?php
                    echo label('text', 'server', 'Servidor');
                    echo label('text', 'user', 'Usuario');
                    echo label('password', 'pass', 'Contraseña');

                    echo submit('Iniciar Sesión');
                ?>

                <?php foreach($errores as $error): ?>
                <div class="alert alert-danger" role="alert"">
                    <?php echo $error; ?>
                    <img class="ms-2" src="img/pikachu_danger_pixel.png" alt="pikachu sad">
                </div>
                <?php endforeach; ?>
            </form>
            <img src="img/pikachu.png" alt="pikachu" id="image">
        </section>
    </main>
    <footer class="mt-5 footerPikachu d-flex align-items-center justify-content-center">
        <p>Derechos Reservados Antonio Ovando Cauich</p>
        <div class="zapdos ms-1">
            <img src="img/zapdos.png" alt="">
        </div>
    </footer>
    
    <script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>