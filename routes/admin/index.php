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

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container mt-4">
        <h1 class="mb-4">Bienvenido al Panel de Administración</h1>
        <p></p>
    </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</body>

</html>