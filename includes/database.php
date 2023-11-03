<?php

    function connectDB($server, $user, $pass) : mysqli {

        $db = @new mysqli($server,$user,$pass);

        return $db;
    }

?>