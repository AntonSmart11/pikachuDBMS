<?php
    include ("templates/header.php");

    $page = '';
    $errores = [];
    $query = "";
    $result = false;

    $route = $db->host_info;

    if(isset($_SESSION['database'])) {
        if($_SESSION['database'] != '') {
            $route = 'la base de datos <span class="fw-bold">'.$_SESSION['database'].'</span>';

            mysqli_select_db($db, $_SESSION['database']);
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        $query = $_POST['query'];

        if($query == '') {
            $errores[] = 'Campo vacío';
        }

        if(empty($errores)) {
            try {
                $result = $db->query($query);
            } catch (Exception $e) {
                $errores[] = mysqli_error($db);
            }
        }

        if($result) {

            $keyValue = [];

            if(isset($result->num_rows)) {
                $key = mysqli_fetch_fields($result);
    
                for ($i=0; $i < count($key); $i++) { 
                    $keyValue[] = $key[$i]->name;
                }
                    
                $value = mysqli_fetch_all($result);
            } else {
                $keyValue[] = "Consulta realizada correctamente";
                $value = [];
            }
            
        }
    }
?>
    <div class="row">
        <div class="col-12">
            <div class="orders">
                <div class="cardHeader">
                    <h2 class="text-center">SQL</h2>
                    <div>
                        <?php
                            if(isset($_SESSION['database'])) {
                                if($_SESSION['database'] != '') {
                                    routeDB($_SESSION['database']);
                                }
                            }
                        ?>
                        <p class="sql">Ejecute la consulta SQL en <?php echo $route ?>:</p>
                    </div>
                    
                    <form action="sql.php" method="POST">
                        <div class="editor">
                            <div class="line-numbers">
                                <span></span>
                            </div>
                            <textarea class="form-control mb-3" name="query" id="inputTextarea" rows="15"><?php echo $query ?></textarea>
                        </div>
                        
                        <?php
                            foreach($errores as $error): 
                                echo alert("danger", $error);
                            endforeach;
                        ?>

                        <div class="d-flex justify-content-end">
                            <?php echo submit('Consultar'); ?>
                        </div>
                    </form>
                </div>
            </div>

            <?php
                if($result):
            ?>
            <div class="orders mt-2">
                <div class="cardHeader">
                    <h2 class="text-center">Resultado</h2>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <?php for($i=0; $i<count($keyValue); $i++): ?>
                                    <th><?php echo $keyValue[$i]; ?></th>
                                <?php endfor; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<count($value); $i++): ?>
                                <tr>
                                    <?php for($j=0; $j<count($value[$i]); $j++): ?>
                                        <th><?php echo $value[$i][$j]; ?></th>
                                    <?php endfor; ?>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
                endif;
            ?>
        </div>
    </div>
<?php

    include ("templates/footer.php");
?>