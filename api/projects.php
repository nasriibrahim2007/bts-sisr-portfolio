<?php
/**
 * API - Gestion des projets
 */
require_once '../config.php';
require_once '../includes/database.php';

header('Content-Type: application/json');
requireAdminLogin();

$action = $_POST['action'] ?? '';

try {
    if ($action === 'add') {
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ALLOWED_EXTENSIONS)) {
                $filename = uniqid('project_') . '.' . $ext;
                if (move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_PATH . $filename)) {
                    $imagePath = '/assets/images/uploads/' . $filename;
                }
            }
        }

        $technologies = isset($_POST['technologies']) ? array_map('trim', explode(',', $_POST['technologies'])) : [];

        $project = [
            'title' => sanitize($_POST['title']),
            'description' => sanitize($_POST['description']),
            'technologies' => $technologies,
            'link' => sanitize($_POST['link'] ?? ''),
            'image' => $imagePath
        ];
        
        $result = $db->add('projects', $project);
        jsonResponse(true, 'Projet ajouté', $result);
    }
    
    if ($action === 'delete') {
        $id = sanitize($_POST['id']);
        // Optionnel : supprimer le fichier image physique ici
        $result = $db->delete('projects', $id);
        jsonResponse($result, 'Projet supprimé');
    }

    jsonResponse(false, 'Action non reconnue');

} catch (Exception $e) {
    jsonResponse(false, 'Erreur : ' . $e->getMessage());
}
?>