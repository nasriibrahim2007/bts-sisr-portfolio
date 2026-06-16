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
define('ADMIN_PASSWORD', '$2y$10$8K1p/a0P1pBfL.n1eY6p9.2Z6K9Q2Z6K9Q2Z6K9Q2Z6K9Q2Z6K9Q.'); // Hash de 'admin123'
define('SESSION_TIMEOUT', 3600); // 1 heure
define('UPLOAD_MAX_SIZE', 5242880); // 5 MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);

// ============== TIMEZONE ==============
date_default_timezone_set('Europe/Paris');

// ========== API Configuration for Cloudflare ==========
if ($_SERVER['HTTP_HOST'] === 'localhost:8000') {
    define('API_URL', 'http://localhost:8000');
} else {
    // Utilisez l'URL de votre service Render.com ici
    define('API_URL', 'https://bts-sisr-portfolio-api.onrender.com');
}

// ========== CORS for Cloudflare Pages ==========
$allowed_origins = [
    'https://bts-sisr-portfolio.pages.dev',
    'https://nasriibrahim2007.pages.dev', // Si vous avez un sous-domaine pages.dev
    'https://votre-domaine-personnalise.com', // Ajoutez votre domaine ici
    'http://localhost:8000',
    'http://localhost:8080'
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: $origin");
}
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

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
