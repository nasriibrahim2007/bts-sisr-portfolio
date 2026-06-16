<?php
/**
 * API - Gestion du profil
 */
require_once '../config.php';
require_once '../includes/database.php';

header('Content-Type: application/json');

requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Méthode non autorisée');
}

$action = $_POST['action'] ?? '';

try {
    if ($action === 'update') {
        $profileData = [
            'name' => sanitize($_POST['name']),
            'title' => sanitize($_POST['title']),
            'email' => sanitize($_POST['email']),
            'phone' => sanitize($_POST['phone']),
            'description' => sanitize($_POST['description']),
            'linkedin' => sanitize($_POST['linkedin'] ?? ''),
            'github' => sanitize($_POST['github'] ?? '')
        ];
        
        $result = $db->updateProfile($profileData);
        jsonResponse(true, 'Profil mis à jour', $result);
    }
    else {
        jsonResponse(false, 'Action inconnue');
    }
} catch (Exception $e) {
    jsonResponse(false, 'Erreur : ' . $e->getMessage());
}
?>
