<?php
require_once '../config.php';
require_once '../includes/database.php';

requireAdminLogin();

$skills = $db->get('skills');
$categories = ['Infrastructure', 'Réseaux', 'Sécurité', 'Cloud', 'Scripting', 'Outils', 'Soft Skills'];
$levels = ['Débutant', 'Intermédiaire', 'Avancé'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Compétences - Admin</title>
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
        .skills-table { width: 100%; border-collapse: collapse; background-color: var(--color-white); border-radius: var(--border-radius-lg); overflow: hidden; box-shadow: var(--shadow-base); }
        .skills-table thead { background-color: var(--color-gray-100); }
        .skills-table th { padding: var(--spacing-4); text-align: left; font-weight: var(--font-weight-semibold); }
        .skills-table td { padding: var(--spacing-4); border-top: 1px solid var(--color-gray-200); }
        .skills-table tr:hover { background-color: var(--color-gray-50); }
        .action-buttons { display: flex; gap: var(--spacing-2); }
        .action-buttons button { padding: var(--spacing-2) var(--spacing-3); font-size: var(--font-size-sm); border-radius: var(--border-radius-base); border: none; cursor: pointer; transition: all var(--transition-fast); }
        .btn-edit { background-color: var(--color-accent); color: var(--color-gray-900); }
        .btn-delete { background-color: var(--color-danger); color: var(--color-white); }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: var(--z-modal); align-items: center; justify-content: center; }
        .modal.show { display: flex; }
        .modal-content { background-color: var(--color-white); padding: var(--spacing-8); border-radius: var(--border-radius-lg); max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <h2><i class="fas fa-cog"></i> Admin</h2>
            <ul class="admin-menu">
                <li><a href="/admin/dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                <li><a href="/admin/profile.php"><i class="fas fa-user"></i> Profil</a></li>
                <li><a href="/admin/skills.php" class="active"><i class="fas fa-star"></i> Compétences</a></li>
                <li><a href="/admin/stages.php"><i class="fas fa-briefcase"></i> Stages</a></li>
                <li><a href="/admin/projects.php"><i class="fas fa-code"></i> Projets</a></li>
                <li style="margin-top: var(--spacing-6);"><a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-8);">
                <h1 style="margin: 0;"><i class="fas fa-star"></i> Gestion des Compétences</h1>
                <button id="addSkillBtn" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter une compétence</button>
            </div>

            <!-- Tableau des compétences -->
            <table class="skills-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Niveau</th>
                        <th>Icône</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="skillsTableBody">
                    <?php if (empty($skills)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: var(--spacing-8); color: var(--color-gray-600);">
                            Aucune compétence ajoutée. <button id="addSkillBtn2" class="btn btn-accent btn-small" style="margin-left: var(--spacing-2);"><i class="fas fa-plus"></i> En ajouter une</button>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($skills as $skill): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($skill['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($skill['category']); ?></td>
                            <td><span style="background-color: var(--color-accent); color: var(--color-gray-900); padding: var(--spacing-1) var(--spacing-2); border-radius: var(--border-radius-base); font-size: var(--font-size-sm);"><?php echo htmlspecialchars($skill['level']); ?></span></td>
                            <td><i class="<?php echo htmlspecialchars($skill['icon']); ?>"></i> <?php echo htmlspecialchars($skill['icon']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-edit" onclick="editSkill('<?php echo htmlspecialchars($skill['id']); ?>')"><i class="fas fa-edit"></i></button>
                                    <button class="btn-delete" onclick="deleteSkill('<?php echo htmlspecialchars($skill['id']); ?>')"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Modal Ajout/Édition -->
    <div id="skillModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">Ajouter une compétence</h2>
            <form id="skillForm">
                <input type="hidden" id="skillId" value="">

                <div style="margin-bottom: var(--spacing-4);">
                    <label for="skillName" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Nom de la compétence *</label>
                    <input type="text" id="skillName" name="name" required style="width: 100%;" placeholder="Ex: Windows Server 2019">
                </div>

                <div style="margin-bottom: var(--spacing-4);">
                    <label for="skillCategory" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Catégorie *</label>
                    <select id="skillCategory" name="category" required style="width: 100%;">
                        <option value="">-- Sélectionner une catégorie --</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="margin-bottom: var(--spacing-4);">
                    <label for="skillLevel" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Niveau *</label>
                    <select id="skillLevel" name="level" required style="width: 100%;">
                        <option value="">-- Sélectionner un niveau --</option>
                        <?php foreach ($levels as $level): ?>
                        <option value="<?php echo htmlspecialchars($level); ?>"><?php echo htmlspecialchars($level); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="margin-bottom: var(--spacing-4);">
                    <label for="skillIcon" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Icône (Font Awesome)</label>
                    <input type="text" id="skillIcon" name="icon" style="width: 100%;" placeholder="fas fa-server" value="fas fa-star">
                </div>

                <div style="margin-bottom: var(--spacing-6);">
                    <label for="skillDescription" style="display: block; font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Description</label>
                    <textarea id="skillDescription" name="description" style="width: 100%;" placeholder="Description de la compétence (optionnel)"></textarea>
                </div>

                <div style="display: flex; gap: var(--spacing-4);">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
                    <button type="button" class="btn btn-outline" onclick="closeModal()"><i class="fas fa-times"></i> Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <script src="/assets/js/script.js"></script>
    <script>
        const modal = document.getElementById('skillModal');
        const form = document.getElementById('skillForm');

        document.getElementById('addSkillBtn').addEventListener('click', openAddModal);
        document.getElementById('addSkillBtn2').addEventListener('click', openAddModal);

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Ajouter une compétence';
            document.getElementById('skillId').value = '';
            form.reset();
            modal.classList.add('show');
        }

        function closeModal() {
            modal.classList.remove('show');
        }

        function editSkill(id) {
            // À implémenter: charger la compétence et remplir le formulaire
            document.getElementById('modalTitle').textContent = 'Modifier la compétence';
            document.getElementById('skillId').value = id;
            modal.classList.add('show');
        }

        async function deleteSkill(id) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?')) return;

            try {
                const response = await fetch('/api/skills.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'delete',
                        id: id
                    })
                });

                const data = await response.json();
                if (data.success) {
                    showNotification('Compétence supprimée', 'success');
                    setTimeout(() => location.reload(), 500);
                } else {
                    showNotification('Erreur : ' + data.message, 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                showNotification('Erreur lors de la suppression', 'error');
            }
        }

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const id = document.getElementById('skillId').value;
            
            formData.append('action', id ? 'update' : 'add');
            if (id) formData.append('id', id);

            try {
                const response = await fetch('/api/skills.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    showNotification(id ? 'Compétence mise à jour' : 'Compétence ajoutée', 'success');
                    closeModal();
                    setTimeout(() => location.reload(), 500);
                } else {
                    showNotification('Erreur : ' + data.message, 'error');
                }
            } catch (error) {
                console.error('Erreur:', error);
                showNotification('Erreur lors de l\'enregistrement', 'error');
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

        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });
    </script>
</body>
</html>
