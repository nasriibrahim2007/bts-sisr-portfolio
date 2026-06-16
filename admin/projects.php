<?php
require_once '../config.php';
require_once '../includes/database.php';

requireAdminLogin();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Projets - Admin</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .admin-container { display: grid; grid-template-columns: 250px 1fr; min-height: 100vh; background-color: var(--color-gray-100); }
        .admin-sidebar { background-color: var(--color-primary); color: var(--color-white); padding: var(--spacing-6); position: sticky; top: 0; height: 100vh; overflow-y: auto; }
        .admin-sidebar h2 { color: var(--color-white); margin-bottom: var(--spacing-6); font-size: var(--font-size-lg); }
        .admin-menu { list-style: none; padding: 0; margin: 0; }
        .admin-menu li { margin-bottom: var(--spacing-3); }
        .admin-menu a { display: flex; align-items: center; gap: var(--spacing-3); color: var(--color-gray-300); padding: var(--spacing-3) var(--spacing-4); border-radius: var(--border-radius-base); transition: all var(--transition-fast); }
        .admin-menu a:hover, .admin-menu a.active { background-color: var(--color-accent); color: var(--color-gray-900); }
        .admin-content { padding: var(--spacing-6); }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <h2><i class="fas fa-cog"></i> Admin</h2>
            <ul class="admin-menu">
                <li><a href="/admin/dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                <li><a href="/admin/profile.php"><i class="fas fa-user"></i> Profil</a></li>
                <li><a href="/admin/skills.php"><i class="fas fa-star"></i> Compétences</a></li>
                <li><a href="/admin/stages.php"><i class="fas fa-briefcase"></i> Stages</a></li>
                <li><a href="/admin/projects.php" class="active"><i class="fas fa-code"></i> Projets</a></li>
                <li style="margin-top: var(--spacing-6);"><a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-8);">
                <h1 style="margin: 0;"><i class="fas fa-code"></i> Gestion des Projets</h1>
                <button id="addProjectBtn" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter un projet</button>
            </div>

            <div style="background-color: var(--color-white); padding: var(--spacing-8); border-radius: var(--border-radius-lg); box-shadow: var(--shadow-base);">
                <p style="color: var(--color-gray-600); margin-bottom: var(--spacing-4);">
                    La gestion des projets sera disponible très bientôt. Vous pouvez gérer directement dans le fichier <code>data/portfolio.json</code> pour le moment.
                </p>
                <p style="color: var(--color-gray-500); font-size: var(--font-size-sm);">
                    Structure d'un projet :
                </p>
                <pre style="background-color: var(--color-gray-100); padding: var(--spacing-4); border-radius: var(--border-radius-base); overflow-x: auto;"><code>{
  "id": "unique-id",
  "title": "Titre du projet",
  "description": "Description du projet",
  "technologies": ["Technologie 1", "Technologie 2"],
  "link": "https://github.com/...",
  "image": "image.jpg"
}</code></pre>
            </div>
        </main>
    </div>

    <script src="/assets/js/script.js"></script>
    <script>
        document.getElementById('logoutBtn').addEventListener('click', function(e) {
            e.preventDefault();
            fetch('/api/auth.php', {
                method: 'POST',
                body: new URLSearchParams({ action: 'logout' })
            }).then(() => {
                window.location.href = '/admin/login.php';
            });
        });
    </script>
</body>
</html>
