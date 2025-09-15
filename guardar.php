<?php 
$host = 'localhost';
$dbname = 'zoologico';
$username = 'root';
$password = '';


try {
    $pdo = new PDO(dsn: "mysql:host=$host;dbname=$dbname;charset=utf8", username: $username, password: $password);
    $pdo->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $doc = trim(string: $_POST['documento']);
        $name = trim(string: $_POST['name']);
        $user = trim(string: $_POST['usuario']);
        $email = trim(string: $_POST['email']);
        $tel = trim(string: $_POST['tel']);
        $rol = trim(string: $_POST['rol']);
        $pass = trim(string: $_POST['password']);

        $pass_cifrado=password_hash($pass,PASSWORD_DEFAULT,array("password"=>12));

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['imagen'] ['tmp_name'];
            $fileName = $_FILES['imagen']['name'];
            $fileSize = $_FILES['imagen']['size'];
            $fileType = $_FILES['imagen']['type'];


            $allowedTypes = ['image/jpeg', 'image/png'];
            if (!in_array(needle: $fileType, haystack: $allowedTypes)) {
                die(json_encode(value: ['error' => 'Solo se permiten archivos JPG O PNG.']));
            }

            if ($fileSize > 200 * 1024) {
                die(json_encode(value: ['error' => 'El archivo no debe superar los 200 KB']));
            }

            $uploadDir = 'uploads/';



            if (!is_dir(filename: $uploadDir)) {
                mkdir(directory: $uploadDir, permissions: 0777, recursive: true);
            }

            $newFileName = uniqid() . '_' . $fileName;
            $destPath = $uploadDir . $newFileName;

            if (!move_uploaded_file(from: $fileTmpPath, to:$destPath)) {
                die(json_encode(value: ['error' => 'Error al subir imagen']));
            }

            $imagen = $destPath;

            $stmt = $pdo->prepare(query:"INSERT INTO user (doc,name,email,tel,password,img,user,id_rol)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute(params: [$doc, $name, $email, $tel, $pass_cifrado, $imagen, $user, $rol]);

            echo json_encode(value: ['message' => 'Datos guardados correctamente.']);
        } else {
            echo json_encode(value: ['error' => 'Error al subir imagen.']);
        } 
    } else{
        echo json_encode(value: ['error' => 'Metodo no permitido.']);
    }
} catch (Exception $e) {
    echo json_encode(value: ['error' => 'Error en el servidor: ' . $e->getMessage()]);
}



?>