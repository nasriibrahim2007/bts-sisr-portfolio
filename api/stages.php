<?php
/**
 * API - Gestion des stages
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
        $stage = [
            'title' => sanitize($_POST['title']),
            'company' => sanitize($_POST['company']),
            'start_date' => sanitize($_POST['start_date']),
            'end_date' => sanitize($_POST['end_date']),
            'description' => sanitize($_POST['description']),
            'skills' => json_encode(json_decode($_POST['skills'] ?? '[]')),
            'image' => sanitize($_POST['image'] ?? '')
        ];
        $result = $db->add('stages', $stage);
        jsonResponse(true, 'Stage ajouté', $result);
    }
    elseif ($action === 'update') {
        $id = sanitize($_POST['id']);
        $stage = [
            'title' => sanitize($_POST['title']),
            'company' => sanitize($_POST['company']),
            'start_date' => sanitize($_POST['start_date']),
            'end_date' => sanitize($_POST['end_date']),
            'description' => sanitize($_POST['description']),
            'skills' => json_encode(json_decode($_POST['skills'] ?? '[]')),
            'image' => sanitize($_POST['image'] ?? '')
        ];
        $result = $db->update('stages', $id, $stage);
        jsonResponse($result !== null, $result ? 'Stage mis à jour' : 'Erreur', $result);
    }
    elseif ($action === 'delete') {
        $id = sanitize($_POST['id']);
        $result = $db->delete('stages', $id);
        jsonResponse($result, 'Stage supprimé');
    }
    else {
        jsonResponse(false, 'Action inconnue');
    }
} catch (Exception $e) {
    jsonResponse(false, 'Erreur : ' . $e->getMessage());
}
?>
