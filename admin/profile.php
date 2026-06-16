<?php
require_once '../config.php';
require_once '../includes/database.php';

requireAdminLogin();

$profile = $db->getProfile();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Profil - Admin</title>
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
        .form-container { background-color: var(--color-white); padding: var(--spacing-8); border-radius: var(--border-radius-lg); box-shadow: var(--shadow-base); max-width: 800px; }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <h2><i class="fas fa-cog"></i> Admin</h2>
            <ul class="admin-menu">
                <li><a href="/admin/dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                <li><a href="/admin/profile.php" class="active"><i class="fas fa-user"></i> Profil</a></li>
                <li><a href="/admin/skills.php"><i class="fas fa-star"></i> Compétences</a></li>
                <li><a href="/admin/stages.php"><i class="fas fa-briefcase"></i> Stages</a></li>
                <li><a href="/admin/projects.php"><i class="fas fa-code"></i> Projets</a></li>
                <li style="margin-top: var(--spacing-6);"><a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <h1 style="margin-bottom: var(--spacing-8);"><i class="fas fa-user"></i> Gestion du Profil</h1>

            <div class="form-container">
                <form id="profileForm">
                    <div style="margin-bottom: var(--spacing-6);">
                        <label for="name" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Votre nom</label>
                        <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($profile['name']); ?>" style="width: 100%;">
                    </div>

                    <div style="margin-bottom: var(--spacing-6);">
                        <label for="title" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Titre / Fonction</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($profile['title']); ?>" style="width: 100%;" placeholder="Ex: Étudiant BTS SIO SISR">
                    </div>

                    <div style="margin-bottom: var(--spacing-6);">
                        <label for="email" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Email</label>
                        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($profile['email']); ?>" style="width: 100%;">
                    </div>

                    <div style="margin-bottom: var(--spacing-6);">
                        <label for="phone" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Téléphone</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($profile['phone']); ?>" style="width: 100%;" placeholder="+33 6 XX XX XX XX">
                    </div>

                    <div style="margin-bottom: var(--spacing-6);">
                        <label for="description" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Description / À propos</label>
                        <textarea id="description" name="description" style="width: 100%;" data-auto-resize><?php echo htmlspecialchars($profile['description']); ?></textarea>
                    </div>

                    <div style="margin-bottom: var(--spacing-6);">
                        <label for="linkedin" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Profil LinkedIn</label>
                        <input type="url" id="linkedin" name="linkedin" value="<?php echo htmlspecialchars($profile['linkedin'] ?? ''); ?>" style="width: 100%;" placeholder="https://linkedin.com/in/votre-profile">
                    </div>

                    <div style="margin-bottom: var(--spacing-6);">
                        <label for="github" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Profil GitHub</label>
                        <input type="url" id="github" name="github" value="<?php echo htmlspecialchars($profile['github'] ?? ''); ?>" style="width: 100%;" placeholder="https://github.com/votreusername">
                    </div>

                    <div style="display: flex; gap: var(--spacing-4);">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                        <a href="/admin/dashboard.php" class="btn btn-outline">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="/assets/js/script.js"></script>
    <script>
        document.getElementById('profileForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'update');
            
            try {
                const response = await fetch('/api/profile.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotification('Profil mis à jour avec succès !', 'success');
                } else {
                    showNotification('Erreur : ' + data.message, 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                showNotification('Erreur lors de la mise à jour', 'error');
            }
        });

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
