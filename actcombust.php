<?php
    include_once("conexion.php");

    $dFecha = $_POST['dFecha'];
    $cPlacas = $_POST['cPlacas'];
    $nKilom = $_POST['nKilom'];
    $nLitros = $_POST['nLitros'];
    $nImpte = $_POST['nImpte'];
    $nPrecio = $_POST['nPrecio'];

?>
    <script>alert("aqui")</script>
<?php

    $sql = "UPDATE cab_combustible SET
    kilometraje = '$nKilom',
    litros = '$nLitros',
    importe = '$nImpte',
    precioxlitro = '$nPrecio'
    WHERE
    placas = '$cPlacas'
    AND fecha = '$dFecha'";

    odbc_exec($conn, $sql);
?>
