<?php
/**
 * Configuration du Portfolio BTS SIO SISR
 */

// ============== PARAMÈTRES GÉNÉRAUX ==============
define('SITE_NAME', 'Portfolio BTS SIO SISR');
define('SITE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST']);
define('ROOT_PATH', dirname(__FILE__));
define('UPLOAD_PATH', ROOT_PATH . '/assets/images/uploads/');
define('DATA_PATH', ROOT_PATH . '/data/');

// ============== BASE DE DONNÉES ==============
define('DB_TYPE', 'json'); // 'json' ou 'sqlite'
define('DB_FILE', DATA_PATH . 'portfolio.json');
define('DB_SQLITE', DATA_PATH . 'portfolio.db');

// ============== SÉCURITÉ ==============
define('ADMIN_PASSWORD', '$2y$10$mC7G0Ot8STp5SM3Ot29uUuP99rnPi767m5T6JZ7PPmE6W/4VqL962'); 
define('SESSION_TIMEOUT', 3600); // 1 heure
define('UPLOAD_MAX_SIZE', 5242880); // 5 MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);

// ============== TIMEZONE ==============
date_default_timezone_set('Europe/Paris');

// ========== Configuration API (Local/Render) ==========
// Puisque tout est sur Render, on utilise des chemins relatifs
define('API_URL', ''); 

// Désactivation CORS car nous sommes sur le même domaine
header('Access-Control-Allow-Origin: ' . SITE_URL);
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

// ============== DÉMARRAGE SESSION ==============
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============== FONCTIONS UTILITAIRES ==============

/**
 * Nettoie une entrée utilisateur
 */
function sanitize($input) {
    return htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Vérifie si l'utilisateur est connecté à l'admin
 */
function isAdminLogged() {
    return isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true;
}

/**
 * Redirige si non authentifié
 */
function requireAdminLogin() {
    if (!isAdminLogged()) {
        header('Location: /admin/login.php');
        exit;
    }
}

/**
 * Retourne un réponse JSON
 */
function jsonResponse($success, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

?>
