<?php
/**
 * API - Gestion des compétences
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
    if ($action === 'add') {
        $skill = [
            'name' => sanitize($_POST['name']),
            'category' => sanitize($_POST['category']),
            'level' => sanitize($_POST['level']),
            'icon' => sanitize($_POST['icon'] ?? 'fas fa-star'),
            'description' => sanitize($_POST['description'] ?? '')
        ];
        $result = $db->add('skills', $skill);
        jsonResponse(true, 'Compétence ajoutée', $result);
    }
    elseif ($action === 'update') {
        $id = sanitize($_POST['id']);
        $skill = [
            'name' => sanitize($_POST['name']),
            'category' => sanitize($_POST['category']),
            'level' => sanitize($_POST['level']),
            'icon' => sanitize($_POST['icon'] ?? 'fas fa-star'),
            'description' => sanitize($_POST['description'] ?? '')
        ];
        $result = $db->update('skills', $id, $skill);
        jsonResponse($result !== null, $result ? 'Compétence mise à jour' : 'Erreur lors de la mise à jour', $result);
    }
    elseif ($action === 'delete') {
        $id = sanitize($_POST['id']);
        $result = $db->delete('skills', $id);
        jsonResponse($result, $result ? 'Compétence supprimée' : 'Erreur lors de la suppression');
    }
    else {
        jsonResponse(false, 'Action inconnue');
    }
} catch (Exception $e) {
    jsonResponse(false, 'Erreur : ' . $e->getMessage());
}
?>
