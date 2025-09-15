<?php
session_start();
require_once("../../db/conection.php");
$db = new Database();
$con = $db->conectar();


$idupdate = $_GET['id'];
$sql = $con->prepare(query: "SELECT * FROM visitas 
                    INNER JOIN tip_entrada ON visitas.tip_entrada = tip_entrada.id_tip_entrada
                    INNER JOIN medio_pago ON visitas.id_med_pago = medio_pago.id_medio_pago");
$sql->execute();
$usua = $sql->fetch();

?>


<?php
if (isset($_POST['update'])) {
    $name = $_POST['nombre'];
    $doc = $_POST['documento'];
    $tel = $_POST['telefono'];
    $entrada = $_POST['entrada'];
    $fecha_entrada = $_POST['fechaEntrada'];
    $fecha_salida = $_POST['fechaSalida'];
    $pago = $_POST['pago'];
    
    

    $insertSQL = $con->prepare(query: "UPDATE visitas SET
    nombre = '$name',
    documento = '$doc',
    fecha_entrada = '$fecha_entrada',
    fecha_salida = '$fecha_salida',
    tip_entrada = '$entrada',
    id_med_pago = '$pago'
    WHERE id_visi = '$idupdate'");
    $insertSQL->execute();
    if ($insertSQL->execute()) {
        echo '<script>alert ("DATOS ACTUALIZADOS");</script>';
    } else {
        echo '<script>alert ("NO FUE POSIBLE ACTUALIZAR");</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formulario Editar Visita</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-4">
  <h5 class="mb-3">Editar Visita</h5>

  <form method="post" class="border rounded p-3 bg-light">
    <div class="row g-3">
      <div class="col-md-6">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" required
        value="<?php echo $usua['nombre'] ?>">
      </div>
      <div class="col-md-6">
        <label for="documento" class="form-label">Documento</label>
        <input type="text" class="form-control form-control-sm" id="documento" name="documento" required
        value="<?php echo $usua['documento'] ?>">
      </div>
      <div class="col-md-6">
        <label for="telefono" class="form-label">Teléfono</label>
        <input type="tel" class="form-control form-control-sm" id="telefono" name="telefono"
        value="<?php echo $usua['tel'] ?>">
      </div>
      <div class="col-md-6">
        <label for="opcionEntrada" class="form-label">Opción de Entrada</label>
        <select id="rol" name="entrada" class="form-select" required>
                        <option value="<?php echo $usua['tip_entrada'] ?>"><?php echo $usua['entrada'] ?></option>
                        <?php
                        $control = $con->prepare(query: "SELECT * FROM tip_entrada");
                        $control->execute();

                        while ($fila = $control->fetch(mode: PDO::FETCH_ASSOC)) {
                            echo "<option value=" . $fila['id_tip_entrada'] . ">"
                                . $fila['entrada'] . "</option>";
                        }
                        ?>
                    </select>
      </div>
      <div class="col-md-6">
        <label for="fechaEntrada" class="form-label">Fecha Entrada</label>
        <input type="datetime-local" class="form-control form-control-sm" id="fechaEntrada" name="fechaEntrada" required
        value="<?php echo $usua['fecha_entrada'] ?>">
      </div>
      <div class="col-md-6">
        <label for="fechaSalida" class="form-label">Fecha Salida</label>
        <input type="datetime-local" class="form-control form-control-sm" id="fechaSalida" name="fechaSalida"
        value="<?php echo $usua['fecha_salida'] ?>">
      </div>
      <div class="col-md-12">
        <label for="opcionPago" class="form-label">Opción de Pago</label>
        <select id="rol" name="pago" class="form-select" required>
                        <option value="<?php echo $usua['id_medio_pago'] ?>"><?php echo $usua['pago'] ?></option>
                        <?php
                        $control = $con->prepare(query: "SELECT * FROM medio_pago");
                        $control->execute();

                        while ($fila = $control->fetch(mode: PDO::FETCH_ASSOC)) {
                            echo "<option value=" . $fila['id_medio_pago'] . ">"
                                . $fila['pago'] . "</option>";
                        }
                        ?>
                    </select>
      </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3">
      <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-sm btn-primary" name="update">Actualizar</button>
    </div>
  </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
