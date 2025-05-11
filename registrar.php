<?php
// Datos de conexión a la base de datos
$servername = "localhost"; // Generalmente es localhost
$database = "enfoque360_evaluacion360";
$username = "evalua360";
$password = "evalua360*";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre_completo = $_POST["nombre_completo"];
        $email = $_POST["email"];
        $password_registro = $_POST["password"];
        $organizacion = $_POST["organizacion"];

        // Generar un nombre de usuario único (podríamos mejorarlo)
        $usuario = strtolower(str_replace(' ', '', $nombre_completo)) . rand(100, 999);

        // Por ahora, guardamos la contraseña tal cual. En producción, ¡deberías usar password_hash()!
        $sql = "INSERT INTO usuarios (nombre_completo, email, password, organizacion, usuario)
                VALUES (:nombre, :email, :password, :organizacion, :usuario)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre_completo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_registro);
        $stmt->bindParam(':organizacion', $organizacion);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        echo "¡Registro exitoso! Tu nombre de usuario es: " . $usuario . ". Redirigiendo en 3 segundos...";
        header("refresh:3;url=/"); // Redirigir a la página principal (ajústala si es necesario)

    } else {
        echo "No se recibieron datos por el método POST.";
    }

} catch(PDOException $e) {
    echo "Error en la conexión o la consulta: " . $e->getMessage();
}

$conn = null;
?>
