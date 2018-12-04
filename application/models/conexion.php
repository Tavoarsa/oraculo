<?php
    $mysqli=new mysqli("localhost","root","Gas/1234","restaurante");
    if(mysqli_connect_errno()){
        echo 'Conexion FAllida: ',mysqli_connect_error();
        exit();
    }

?>