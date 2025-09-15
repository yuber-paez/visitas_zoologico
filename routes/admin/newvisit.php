<?php
session_start();
require_once("../../db/conection.php");
$db = new Database();
$con = $db->conectar();

$id_user = $_SESSION['id_user'];
$sql = $con->prepare(query: "SELECT * FROM user 
INNER JOIN rol ON 
user.id_rol = rol.id_rol
WHERE user.id_user = '$id_user'");

$sql->execute();
$fila = $sql->fetch();
?>

<?php
if (isset($_POST['btnclose'])) {
    session_destroy();
    header('location: ../../index.html');
}
?>

<?php 
if (isset($_POST['registrar'])) {

  $name = $_POST['nombre'];
  $documento = $_POST['documento'];
  $tel = $_POST['telefono'];
  $fecha_entrada = $_POST['fecha_entrada'];
  $fecha_salida = $_POST['fecha_salida'];
  $tip_entrada = $_POST['tip_entrada'];
  $medio_pago = $_POST['med_pago'];

  $insertData = $con->prepare(query:"INSERT INTO visitas (nombre,documento,tel,fecha_entrada,fecha_salida,tip_entrada,id_med_pago)
  VALUES ('$name', '$documento', '$tel', '$fecha_entrada', '$fecha_salida', '$tip_entrada', '$medio_pago' )");
  $insertData->execute();
  if ($insertData->execute()){
    echo "<script>alert('Datos registrados correctamente');</script>";
  }

  else {
    echo "<script>alert('No fue posible registrar datos');</script>";
  }

}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Zoológico</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <style>
        .brand-text {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .brand-text span:first-child {
            color: #28a745;
            /* Verde */
        }

        .brand-text span:last-child {
            color: #ff9800;
            /* Naranja */
        }

        .nav-icons {
            display: flex;
            gap: 35px;
        }

        .nav-item {
            text-align: center;
            color: #555;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .nav-item i {
            font-size: 1.6rem;
            /* Tamaño uniforme */
            width: 30px;
            height: 30px;
            display: block;
            margin: 0 auto 5px auto;
            /* Centrado + espacio debajo */
        }

        .nav-item:hover {
            color: #28a745;
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header class="d-flex justify-content-between align-items-center px-4 py-2 bg-light shadow-sm">

        <!-- IZQUIERDA -->
        <div class="brand-text">
            <span>Zooló</span><span>gico</span>
        </div>

        <!-- CENTRO -->
        <div class="nav-icons">
            <a href="index.php" class="nav-item">
                <i class="bi bi-house-fill"></i>
                <span>Inicio</span>
            </a>
            <a href="visitas.php" class="nav-item">
                <i class="bi bi-card-checklist"></i>
                <span>Visitas</span>
            </a>
            <a href="newvisit.php" class="nav-item">
                <i class="bi bi-people-fill"></i>
                <span>Nueva visita</span>
            </a>
            
        </div>

        <!-- DERECHA -->
        <div class="d-flex align-items-center gap-3">
            <div class="text-end">
                <div class="fw-bold"><?php echo $fila['name'] ?></div>
                <small class="text-muted"><?php echo $fila['rol'] ?></small>
            </div>
            <div class="header-right">
                <form method="post">
                    <button class="logout-btn" name="btnclose">Log out</button>
                </form>
            </div>

        </div>

    </header>

        <div class="container mt-5">
    <h2 class="mb-4 text-center">Registrar Visitas - Zoológico</h2>

    <div class="row g-4">
      <!-- Formulario normal -->
      <div class="col-md-7">
        <div class="card shadow-sm p-4">
          <h5 class="mb-3 text-success">Registro Individual</h5>
          <form method="POST">
            <!-- Nombre -->
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre Completo</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <!-- Documento -->
            <div class="mb-3">
              <label for="documento" class="form-label">Documento</label>
              <input type="text" class="form-control" id="documento" name="documento" required>
            </div>

            <!-- Teléfono -->
            <div class="mb-3">
              <label for="telefono" class="form-label">Teléfono</label>
              <input type="tel" class="form-control" id="telefono" name="telefono" required>
            </div>

            <!-- Fecha Entrada -->
            <div class="mb-3">
              <label for="fecha_entrada" class="form-label">Fecha Entrada</label>
              <input type="datetime-local" class="form-control" id="fecha_entrada" name="fecha_entrada" required>
            </div>

            <!-- Fecha Salida -->
            <div class="mb-3">
              <label for="fecha_salida" class="form-label">Fecha Salida</label>
              <input type="datetime-local" class="form-control"  name="fecha_salida" required>
            </div>

            <!-- Tipo Entrada -->
            <div class="mb-3">
              <label for="tipo_entrada" class="form-label">Tipo de Entrada</label>
              <select class="form-select" id="tip_entrada" name="tip_entrada" required>
                <option value="">Seleccione...</option>
                <?php
                        $control = $con->prepare(query: "SELECT * FROM tip_entrada");
                        $control->execute();

                        while ($fila = $control->fetch(mode: PDO::FETCH_ASSOC)) {
                            echo "<option value=" . $fila['id_tip_entrada'] . ">" . $fila['entrada'] . "</option>";
                        }

                        ?>
              </select>
            </div>

            <!-- Medio de Pago -->
            <div class="mb-4">
              <label for="medio_pago" class="form-label">Medio de Pago</label>
              <select class="form-select" id="med_pago" name="med_pago" required>
                <option value="">Seleccione...</option>
                <?php
                        $control = $con->prepare(query: "SELECT * FROM medio_pago");
                        $control->execute();

                        while ($fila = $control->fetch(mode: PDO::FETCH_ASSOC)) {
                            echo "<option value=" . $fila['id_medio_pago'] . ">" . $fila['pago'] . "</option>";
                        }

                        ?>
              </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between">
              <button type="reset" class="btn btn-secondary">Cancelar</button>
              <button type="submit" class="btn btn-success" name="registrar">Guardar Visita</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Subida de archivo -->
      <div class="col-md-5">
        <div class="card shadow-sm p-4 bg-light border-success">
          <h5 class="mb-3 text-primary">Registro con archivo </h5>
          <form action="recibe_excel.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="archivo" class="form-label">Subir archivo (CSV/Excel)</label>
              <input type="file" class="form-control" id="file-input" name="dataCliente" required>
              <div class="form-text">Permite registrar varias visitas al mismo tiempo.</div>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="subir">Cargar Archivo</button>
          </form>
        </div>
      </div>
    </div>
  </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</body>

</html>