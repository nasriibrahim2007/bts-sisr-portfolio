<?php
require_once '../config.php';
require_once '../includes/database.php';

requireAdminLogin();

$profile = $db->getProfile();
$skills_count = count($db->get('skills'));
$stages_count = count($db->get('stages'));
$projects_count = count($db->get('projects'));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Portfolio</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .admin-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
            background-color: var(--color-gray-100);
        }
        
        .admin-sidebar {
            background-color: var(--color-primary);
            color: var(--color-white);
            padding: var(--spacing-6);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        
        .admin-sidebar h2 {
            color: var(--color-white);
            margin-bottom: var(--spacing-6);
            font-size: var(--font-size-lg);
        }
        
        .admin-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .admin-menu li {
            margin-bottom: var(--spacing-3);
        }
        
        .admin-menu a {
            display: flex;
            align-items: center;
            gap: var(--spacing-3);
            color: var(--color-gray-300);
            padding: var(--spacing-3) var(--spacing-4);
            border-radius: var(--border-radius-base);
            transition: all var(--transition-fast);
        }
        
        .admin-menu a:hover,
        .admin-menu a.active {
            background-color: var(--color-accent);
            color: var(--color-gray-900);
        }
        
        .admin-content {
            padding: var(--spacing-6);
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: var(--spacing-8);
            background-color: var(--color-white);
            padding: var(--spacing-4) var(--spacing-6);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-sm);
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-6);
            margin-bottom: var(--spacing-8);
        }
        
        .stat-card {
            background-color: var(--color-white);
            padding: var(--spacing-6);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-base);
            text-align: center;
        }
        
        .stat-card i {
            font-size: 2rem;
            color: var(--color-accent);
            margin-bottom: var(--spacing-3);
        }
        
        .stat-number {
            font-size: var(--font-size-3xl);
            font-weight: var(--font-weight-bold);
            color: var(--color-primary);
            margin-bottom: var(--spacing-2);
        }
        
        @media (max-width: 768px) {
            .admin-container {
                grid-template-columns: 1fr;
            }
            
            .admin-sidebar {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <h2><i class="fas fa-cog"></i> Admin</h2>
            <ul class="admin-menu">
                <li><a href="/admin/dashboard.php" class="active"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                <li><a href="/admin/profile.php"><i class="fas fa-user"></i> Profil</a></li>
                <li><a href="/admin/skills.php"><i class="fas fa-star"></i> Compétences</a></li>
                <li><a href="/admin/stages.php"><i class="fas fa-briefcase"></i> Stages</a></li>
                <li><a href="/admin/projects.php"><i class="fas fa-code"></i> Projets</a></li>
                <li style="margin-top: var(--spacing-6);"><a href="#" id="logoutBtn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
            </ul>
        </aside>

        <!-- Contenu principal -->
        <main class="admin-content">
            <div class="admin-header">
                <div>
                    <h1>Dashboard</h1>
                    <p style="color: var(--color-gray-600); margin: 0;">Bienvenue dans l'administration de votre portfolio</p>
                </div>
                <button id="logoutBtn2" class="btn btn-outline" style="gap: var(--spacing-2);">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </div>

            <!-- Statistiques -->
            <div class="dashboard-grid">
                <div class="stat-card">
                    <i class="fas fa-star"></i>
                    <div class="stat-number"><?php echo $skills_count; ?></div>
                    <p style="margin: 0; color: var(--color-gray-600);">Compétences</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-briefcase"></i>
                    <div class="stat-number"><?php echo $stages_count; ?></div>
                    <p style="margin: 0; color: var(--color-gray-600);">Stages</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-code"></i>
                    <div class="stat-number"><?php echo $projects_count; ?></div>
                    <p style="margin: 0; color: var(--color-gray-600);">Projets</p>
                </div>
            </div>

            <!-- Actions rapides -->
            <div style="background-color: var(--color-white); padding: var(--spacing-6); border-radius: var(--border-radius-lg); box-shadow: var(--shadow-base);">
                <h2 style="margin-top: 0;">Actions rapides</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-4);">
                    <a href="/admin/profile.php" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Modifier le profil
                    </a>
                    <a href="/admin/skills.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajouter une compétence
                    </a>
                    <a href="/admin/stages.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajouter un stage
                    </a>
                    <a href="/admin/projects.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Ajouter un projet
                    </a>
                </div>
            </div>

            <!-- Info -->
            <div style="margin-top: var(--spacing-8); padding: var(--spacing-6); background-color: var(--color-gray-100); border-radius: var(--border-radius-lg); border-left: 4px solid var(--color-accent);">
                <h3 style="margin-top: 0;">
                    <i class="fas fa-info-circle"></i> À propos
                </h3>
                <p>
                    Cette interface d'administration vous permet de gérer l'ensemble du contenu de votre portfolio BTS SIO SISR. 
                    Vous pouvez ajouter, modifier ou supprimer vos compétences, stages et projets.
                </p>
                <p style="margin-bottom: 0;">
                    Les modifications sont enregistrées automatiquement et apparaissent immédiatement sur votre site public.
                </p>
            </div>
        </main>
    </div>

    <script>
        // Gestion de la déconnexion
        document.getElementById('logoutBtn').addEventListener('click', logout);
        document.getElementById('logoutBtn2').addEventListener('click', logout);
        
        function logout(e) {
            e.preventDefault();
            fetch('/api/auth.php', {
                method: 'POST',
                body: new URLSearchParams({ action: 'logout' })
            }).then(() => {
                window.location.href = '/admin/login.php';
            });
        }
    </script>
</body>
</html>
