<?php
/**
 * API - Authentification
 */
require_once '../config.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

if ($action === 'login') {
    $password = $_POST['password'] ?? '';
    
    // Vérification sécurisée du mot de passe
    if (password_verify($password, ADMIN_PASSWORD)) {
        $_SESSION['admin_logged'] = true;
        jsonResponse(true, 'Connexion réussie');
    } else {
        // Petit délai pour éviter les attaques par brute force
        sleep(1);
        jsonResponse(false, 'Mot de passe incorrect');
    }
}

if ($action === 'logout') {
    $_SESSION = array();
    session_destroy();
    jsonResponse(true, 'Déconnexion réussie');
}

jsonResponse(false, 'Action non autorisée');
?>