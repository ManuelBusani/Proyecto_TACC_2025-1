<?php
// Procesa el token para acceder con google

session_start();

require_once '../vendor/autoload.php';
require_once '../config/db.php';
use GuzzleHttp\Client;
use Google_Client;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$token = $data['credential'] ?? null;

// checar si se envió un token
if (!$token) {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'No se proporcionó un token']);
    exit;
}

$client = new Google_Client(['client_id' => '964633068946-rer6fh6j09259582nd89ci582ngnjp7i.apps.googleusercontent.com']);

$httpClient = new Client([
    'verify' => __DIR__ . '/../certs/cacert.pem'
]);

$client->setHttpClient($httpClient);

$payload = $client->verifyIdToken($token);
// Checar si el token es válido
if ($payload) {
    $email = $payload['email'];
    $google_id = $payload['sub'];

    $stmt = $pdo->prepare("SELECT * FROM equipoPi_users WHERE google_id = :google_id OR email = :email LIMIT 1");
    $stmt->execute(['google_id' => $google_id, 'email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Checar si el usuario esta registrado en la base de datos
    if (!$user) {
        // Registrar un nuevo usuario
        $first_name = $payload['given_name'];
        $last_name = $payload['family_name'];

        $stmt = $pdo->prepare("INSERT INTO equipoPi_users (email, google_id, first_name, last_name, is_verified) 
                               VALUES (:email, :google_id, :first_name, :last_name, :is_verified)");
        $stmt->execute([
            'email' => $email,
            'google_id' => $google_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'is_verified' => 1]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['is_admin'] = 0;
        $_SESSION['first_name'] = $first_name;
    } else {
        // Actualizar el google id si el usuario existe pero no tiene google_id,
        // esto sucede cuando un usuario se registró manualmente antes.
        if(!$user['google_id']){
            $stmt = $pdo->prepare("UPDATE equipoPi_users SET google_id = :google_id WHERE id = :id");
            $stmt->execute(['google_id' => $google_id, 'id' => $user['id']]);
        }


        $_SESSION['user_id']= $user['id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['first_name'] = $user['first_name'];
    }

    ob_clean();
    echo json_encode(['success' => true]);

} else {
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'El token proporcionado no es válido']);
}
