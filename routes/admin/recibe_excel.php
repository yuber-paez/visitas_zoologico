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

        $nombre     = !empty($datos[0]) ? ($datos[0]) : '';
        $correo      = !empty($datos[1]) ? ($datos[1]) : '';
        $celular    = !empty($datos[2]) ? ($datos[2]) : '';

        if ( !empty($celular) ){
            $checkemail_duplicado = $con->prepare(query:"SELECT celular FROM user WHERE celular='".($celular)."' ");
                $checkemail_duplicado->execute();
                $ca_dupli = $checkemail_duplicado->fetchAll(PDO::FETCH_ASSOC);
                $cant_duplicidad = count($ca_dupli);
        }

        if ( $cant_duplicidad == 0 ) {
            $insertData = $con->prepare(query:"INSERT INTO 
            visitas(nombre,documento,tel,fecha_entrada,fecha_salida,tip_entrada,id_med_pago) VALUES
            ");
            $insertData->execute();

        }
        else {
            $updateData = $con->prepare(query:"UPDATE user SET 
            name='".$nombre."',
            correo='".$correo."',
            celular='".$celular."'
            WHERE celular='".$celular."'");
            $updateData->execute();
        }
    }
    $i++;
}
?>

<a href="index.php">Atras</a>