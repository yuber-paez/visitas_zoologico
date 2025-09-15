<?php
require_once("../../db/conection.php");
$db = new Database();
$con = $db->conectar();

$tipo        = $_FILES['dataCliente']['type'];
$tamanio      = $_FILES['dataCliente']['size'];
$archivotmp  = $_FILES['dataCliente']['tmp_name'];
$lineas      = file(filename: $archivotmp);

$i = 0;


foreach ($lineas as $linea) {
    $cantidad_registros = count(value: $lineas);
    $cantidad_regist_agregados = ($cantidad_registros - 1);

    if ($i != 0) {

        $datos = explode(separator: ",", string: $linea);

        $name     = !empty($datos[0]) ? ($datos[0]) : '';
        $documento      = !empty($datos[1]) ? ($datos[1]) : '';
        $tel    = !empty($datos[2]) ? ($datos[2]) : '';
        $fecha_entrada    = !empty($datos[3]) ? ($datos[3]) : '';
        $fecha_salida    = !empty($datos[4]) ? ($datos[4]) : '';
        $tip_entrada    = !empty($datos[5]) ? ($datos[5]) : '';
        $medio_pago    = !empty($datos[6]) ? ($datos[6]) : '';
        



       $insertData = $con->prepare(query:"INSERT INTO visitas (nombre,documento,tel,fecha_entrada,fecha_salida,tip_entrada,id_med_pago)
  VALUES ('$name', '$documento', '$tel', '$fecha_entrada', '$fecha_salida', '$tip_entrada', '$medio_pago' )");
  $insertData->execute();
        if ($insertData->execute()) {
            echo "<script>alert('Datos registrados correctamente');</script>";
        }
    }
    $i++;
}
?>

<a href="index.php">Atras</a>