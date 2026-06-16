<?php
require_once '../config.php';
require_once '../includes/database.php';

requireAdminLogin();

$stages = $db->get('stages');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Stages - Admin</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .admin-container { display: grid; grid-template-columns: 250px 1fr; min-height: 100vh; background-color: var(--color-gray-100); }
        .admin-sidebar { background-color: var(--color-primary); color: var(--color-white); padding: var(--spacing-6); position: sticky; top: 0; height: 100vh; overflow-y: auto; }
        .admin-sidebar h2 { color: var(--color-white); margin-bottom: var(--spacing-4); font-size: var(--font-size-lg); }
        .admin-menu { list-style: none; padding: 0; margin: 0; }
        .admin-menu li { margin-bottom: var(--spacing-3); }
        .admin-menu a { display: flex; align-items: center; gap: var(--spacing-3); color: var(--color-gray-300); padding: var(--spacing-3) var(--spacing-4); border-radius: var(--border-radius-base); transition: all var(--transition-fast); }
        .admin-menu a:hover, .admin-menu a.active { background-color: var(--color-accent); color: var(--color-gray-900); }
        .back-link { margin-bottom: var(--spacing-8); display: block; color: var(--color-accent); font-weight: 600; text-decoration: none; font-size: 14px; opacity: 0.8; }
        .back-link:hover { opacity: 1; text-decoration: underline; }
        .admin-content { padding: var(--spacing-6); }
        
        /* Grille de cartes graphiques */
        .stages-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .stage-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); border: 1px solid #eee; transition: transform 0.2s; }
        .stage-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); }
        .stage-img { width: 100%; height: 150px; object-fit: cover; background: #eee; }
        .stage-body { padding: 20px; }
        .stage-actions { display: flex; justify-content: flex-end; gap: 10px; padding: 15px; border-top: 1px solid #f5f5f5; }

        .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000; }
        .modal.show { display: flex; }
        .modal-content { background: white; padding: 30px; border-radius: 8px; width: 500px; max-width: 90%; }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <h2><i class="fas fa-user-shield"></i> Administration</h2>
            <a href="/" class="back-link"><i class="fas fa-arrow-left"></i> Retour au site</a>
            <ul class="admin-menu">
                <li><a href="/admin/dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                <li><a href="/admin/profile.php"><i class="fas fa-user"></i> Profil</a></li>
                <li><a href="/admin/skills.php"><i class="fas fa-star"></i> Compétences</a></li>
                <li><a href="/admin/stages.php" class="active"><i class="fas fa-briefcase"></i> Stages</a></li>
                <li><a href="/admin/projects.php"><i class="fas fa-code"></i> Projets</a></li>
                <li style="margin-top: var(--spacing-6);"><a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-8);">
                <h1 style="margin: 0;"><i class="fas fa-briefcase"></i> Gestion des Stages</h1>
                <button onclick="openModal()" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter un stage</button>
            </div>

            <div class="stages-grid">
                <?php foreach ($stages as $stage): ?>
                <div class="stage-card">
                    <img src="<?= !empty($stage['image']) ? $stage['image'] : '/assets/images/default-avatar.jpg' ?>" alt="Logo" class="stage-img">
                    <div class="stage-body">
                        <h3 style="margin-bottom: 5px;"><?= htmlspecialchars($stage['company']) ?></h3>
                        <p style="color: var(--color-accent); font-weight: 500; margin-bottom: 10px;"><?= htmlspecialchars($stage['title']) ?></p>
                        <p style="font-size: 13px; color: #666;"><?= date('M Y', strtotime($stage['start_date'])) ?> - <?= date('M Y', strtotime($stage['end_date'])) ?></p>
                    </div>
                    <div class="stage-actions">
                            <button onclick="deleteStage('<?= $stage['id'] ?>')" class="btn btn-danger btn-small"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <div id="stageModal" class="modal">
        <div class="modal-content">
            <h2>Ajouter un stage</h2>
            <form id="stageForm">
                <input type="hidden" name="action" value="add">
                <div class="mb-4">
                    <label>Entreprise</label>
                    <input type="text" name="company" required class="w-full">
                </div>
                <div class="mb-4">
                    <label>Intitulé du poste</label>
                    <input type="text" name="title" required class="w-full">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="mb-4">
                        <label>Date début</label>
                        <input type="date" name="start_date" required>
                    </div>
                    <div class="mb-4">
                        <label>Date fin</label>
                        <input type="date" name="end_date" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label>Image / Logo du stage</label>
                    <input type="file" name="image" accept="image/*" class="w-full">
                </div>
                <div class="mb-4">
                    <label>Missions</label>
                    <textarea name="description" required class="w-full"></textarea>
                </div>
                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="button" onclick="closeModal()" class="btn btn-outline">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <script src="/assets/js/script.js"></script>
    <script>
        function openModal() { document.getElementById('stageModal').classList.add('show'); }
        function closeModal() { document.getElementById('stageModal').classList.remove('show'); }

        document.getElementById('stageForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const formData = new FormData(e.target);
                const data = await apiCall('/api/stages.php', { method: 'POST', body: formData });
                if(data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            } catch (err) { alert("Erreur lors de l'enregistrement"); }
        });

        async function deleteStage(id) {
            if(!confirm('Supprimer ce stage ?')) return;
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);
            const resp = await fetch('/api/stages.php', { method: 'POST', body: formData });
            const data = await resp.json();
            if(data.success) location.reload();
        }

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
