<?php
/**
 * API - Envoi de contact
 */
require_once '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Méthode non autorisée');
}

$name = sanitize($_POST['name'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$subject = sanitize($_POST['subject'] ?? '');
$message = sanitize($_POST['message'] ?? '');

// Validation simple
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    jsonResponse(false, 'Tous les champs sont obligatoires');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(false, 'Email invalide');
}

// Pour le moment, on simule juste l'envoi
// En production, vous pouvez utiliser PHPMailer ou envoyer un email
// mail(ADMIN_EMAIL, "Nouveau message de contact: " . $subject, "De: $name <$email>\n\n" . $message);

// Enregistrer dans un fichier de log
$logEntry = date('Y-m-d H:i:s') . " | From: $name <$email> | Subject: $subject\n";
@file_put_contents(DATA_PATH . 'contact-messages.log', $logEntry, FILE_APPEND);

jsonResponse(true, 'Message enregistré. Merci de nous avoir contacté !');
?>
