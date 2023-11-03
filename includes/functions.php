<?php
    
    function label($type, $id, $placeholder) {
        return
        '<div class="form-outline mb-4">
            <input type="'.$type.'" id="'.$id.'" class="form-control" name="'.$id.'">
            <label class="form-label" for="'.$id.'">'.$placeholder.'</label>
        </div>';
    }

    function labelSimple($type, $id, $value) {
        echo
        '<input value="'.$value.'" class="labelSimple form-control" type="'.$type.'" id="'.$id.'" name="'.$id.'">';
    }

    function selectSimple($text, $id) {
        return
        '<select name="'.$id.'" class="form-select " aria-label="select">
            <option value="" selected disabled>Selecciona</option>
            '.$text.'
        </select>';
    }

    function select($id, $placeholder, $text) {
        return
        '<div class="form-outline mb-4">
            <select name="'.$id.'" class="form-select " aria-label="select">
                <option value="" selected disabled>Selecciona</option>
                '.$text.'
            </select>
            <label class="form-label" for="'.$id.'">'.$placeholder.'</label>
        </div>';
    }

    function optionSimple($value, $title) {
        return
        '<option value="'.$value.'">'.$title.'</option>';
    }

    function optionSimpleSelected($value, $title, $selected) {
        $q = '';

        if($selected) {
            $q = 'selected';
        }

        return
        '<option value="'.$value.'" '.$q.'>'.$title.'</option>';
    }

    function optionSimpleDisabled($title) {
        return
        '<option class="fw-bold" value="" disabled>'.$title.'</option>';
    }

    function checkboxSimple($value, $id) {
        echo
        '<input name="'.$id.'" class="form-check-input" type="checkbox" value="'.$value.'" id="'.$id.'">';
    }

    function checkboxSimpleSelected($value, $id, $cheked) {
        $q = '';

        if($cheked) {
            $q = 'checked';
        }

        echo
        '<input name="'.$id.'" class="form-check-input" type="checkbox" value="'.$value.'" id="'.$id.'" '.$q.'>';
    }

    function submit($value) {
        return
        '<input type="submit" value="'.$value.'" class="btn submit mb-4">';
    }

    function card($title, $text) {
        echo
        '<div class="card">
            <div class="card-body">
                <h5 class="card-title">'.$title.'</h5>
                <p class="card-text">'.$text.'</p>
            </div>
        </div>';
    }

    function alert($type, $text) {
        echo
        '<div class="alert alert-'.$type.'" role="alert">
            '.$text.'
            <img class="ms-2" src="../img/pikachu_'.$type.'_pixel.png" alt="pikachu sad">
        </div>';
    }

    function routeDB($db) {
        echo
        '<p class="route">Base de datos: <a href="databases.php?name='.$db.'">'.$db.'</a></p>';
    }

    function routeDBTable($db, $table) {
        echo
        '<p class="route">Base de datos: <a href="databases.php?name='.$db.'">'.$db.'</a> -> Tabla: <a href="tables.php?name='.$table.'">'.$table.'</a></p>';
    }

    function routeDBTableStructure($db, $table) {
        echo
        '<p class="route">Base de datos: <a href="databases.php?name='.$db.'">'.$db.'</a> -> Tabla: <a href="tablesStructure.php?name='.$table.'">'.$table.'</a></p>';
    }

    function buttonModal($id, $text) {
        echo
        '<button type="button" class="btn submit" data-bs-toggle="modal" data-bs-target="#'.$id.'">
            '.$text.'
        </button>';
    }

    function modal($id, $title, $text) {
        echo
        '<div class="modal fade" id="'.$id.'" tabindex="-1" aria-labelledby="'.$title.'" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="'.$title.'">'.$title.'</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        '.$text.'
                    </div>
                </div>
            </div>
        </div>';
    }

    function formGet($page, $text) {
        return
        '<form method="GET" action="'.$page.'">
            '.$text.'
        </form>';
    }

    function formPost($page, $text) {
        return
        '<form method="POST" action="'.$page.'">
            '.$text.'
        </form>';
    }
?>