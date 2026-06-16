<?php
/**
 * API - Gestion des projets
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
        $project = [
            'title' => sanitize($_POST['title']),
            'description' => sanitize($_POST['description']),
            'technologies' => json_encode(json_decode($_POST['technologies'] ?? '[]')),
            'link' => sanitize($_POST['link'] ?? ''),
            'image' => sanitize($_POST['image'] ?? '')
        ];
        $result = $db->add('projects', $project);
        jsonResponse(true, 'Projet ajouté', $result);
    }
    elseif ($action === 'update') {
        $id = sanitize($_POST['id']);
        $project = [
            'title' => sanitize($_POST['title']),
            'description' => sanitize($_POST['description']),
            'technologies' => json_encode(json_decode($_POST['technologies'] ?? '[]')),
            'link' => sanitize($_POST['link'] ?? ''),
            'image' => sanitize($_POST['image'] ?? '')
        ];
        $result = $db->update('projects', $id, $project);
        jsonResponse($result !== null, $result ? 'Projet mis à jour' : 'Erreur', $result);
    }
    elseif ($action === 'delete') {
        $id = sanitize($_POST['id']);
        $result = $db->delete('projects', $id);
        jsonResponse($result, 'Projet supprimé');
    }
    else {
        jsonResponse(false, 'Action inconnue');
    }
} catch (Exception $e) {
    jsonResponse(false, 'Erreur : ' . $e->getMessage());
}
?>
