<?php
/**
 * API - Authentification
 */
require_once '../config.php';
require_once '../includes/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Méthode non autorisée');
}

$action = $_POST['action'] ?? '';
$password = $_POST['password'] ?? '';

if ($action === 'login') {
    if (password_verify($password, ADMIN_PASSWORD)) {
        $_SESSION['admin_logged'] = true;
        $_SESSION['login_time'] = time();
        jsonResponse(true, 'Authentification réussie');
    } else {
        jsonResponse(false, 'Mot de passe incorrect');
    }
}
elseif ($action === 'logout') {
    session_destroy();
    jsonResponse(true, 'Déconnexion réussie');
}
else {
    jsonResponse(false, 'Action inconnue');
}
?>
