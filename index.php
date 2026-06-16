<?php
require_once 'config.php';
require_once 'includes/database.php';

// Gestion du routage simple
$page = $_GET['page'] ?? 'home';
$valid_pages = ['home', 'skills', 'stages', 'projects', 'contact'];

if (!in_array($page, $valid_pages)) {
    $page = 'home';
}

// Vérifier que la page est activée dans le menu
$menu = $db->getAll()['menu'] ?? [];
if ($page !== 'home' && !isset($menu[$page])) {
    $page = 'home';
}

// Récupérer les données du profil
$profile = $db->getProfile();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($profile['description'] ?? 'Portfolio BTS SIO SISR'); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($profile['name'] ?? 'Étudiant'); ?>">
    
    <title><?php echo htmlspecialchars($profile['name'] ?? 'Portfolio'); ?> - BTS SIO SISR</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Barre de progression scroll -->
    <div id="scrollProgress" style="position: fixed; top: 0; left: 0; height: 3px; background: linear-gradient(90deg, var(--color-accent), var(--color-primary)); z-index: 9999; width: 0%; transition: width 0.1s ease;"></div>

    <!-- Navigation -->
    <header>
        <nav class="container">
            <div class="nav-brand">
                <i class="fas fa-server"></i> <?php echo htmlspecialchars($profile['name'] ?? 'Portfolio'); ?>
            </div>
            <ul class="nav-links">
                <li><a href="/?page=home" <?php echo $page === 'home' ? 'class="active"' : ''; ?>><i class="fas fa-home"></i> Accueil</a></li>
                <?php if ($menu['skills'] ?? true): ?>
                <li><a href="/?page=skills" <?php echo $page === 'skills' ? 'class="active"' : ''; ?>><i class="fas fa-star"></i> Compétences</a></li>
                <?php endif; ?>
                <?php if ($menu['stages'] ?? true): ?>
                <li><a href="/?page=stages" <?php echo $page === 'stages' ? 'class="active"' : ''; ?>><i class="fas fa-briefcase"></i> Stages</a></li>
                <?php endif; ?>
                <?php if ($menu['projects'] ?? true): ?>
                <li><a href="/?page=projects" <?php echo $page === 'projects' ? 'class="active"' : ''; ?>><i class="fas fa-code"></i> Projets</a></li>
                <?php endif; ?>
                <?php if ($menu['contact'] ?? true): ?>
                <li><a href="/?page=contact" <?php echo $page === 'contact' ? 'class="active"' : ''; ?>><i class="fas fa-envelope"></i> Contact</a></li>
                <?php endif; ?>
                <li><a href="/admin/login.php" title="Panneau Admin"><i class="fas fa-lock"></i></a></li>
            </ul>
        </nav>
    </header>

    <!-- Contenu principal -->
    <main>
        <?php
        switch ($page) {
            case 'home':
                include 'pages/home.php';
                break;
            case 'skills':
                include 'pages/skills.php';
                break;
            case 'stages':
                include 'pages/stages.php';
                break;
            case 'projects':
                include 'pages/projects.php';
                break;
            case 'contact':
                include 'pages/contact.php';
                break;
            default:
                include 'pages/home.php';
        }
        ?>
    </main>

    <!-- Footer -->
    <footer style="background-color: var(--color-gray-900); color: var(--color-white); padding: var(--spacing-8) var(--spacing-4); text-align: center; margin-top: var(--spacing-20);">
        <div class="container">
            <div class="flex flex-col gap-4" style="gap: var(--spacing-4);">
                <div>
                    <h3 style="color: var(--color-accent); margin-bottom: var(--spacing-2);">Contactez-moi</h3>
                    <p>
                        <a href="mailto:<?php echo htmlspecialchars($profile['email']); ?>" style="color: var(--color-accent);">
                            <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($profile['email']); ?>
                        </a>
                    </p>
                    <p>
                        <i class="fas fa-phone"></i> <?php echo htmlspecialchars($profile['phone']); ?>
                    </p>
                </div>
                <div>
                    <?php if ($profile['linkedin']): ?>
                    <a href="<?php echo htmlspecialchars($profile['linkedin']); ?>" target="_blank" rel="noopener noreferrer" style="margin: 0 var(--spacing-3); color: var(--color-accent);">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a>
                    <?php endif; ?>
                    <?php if ($profile['github']): ?>
                    <a href="<?php echo htmlspecialchars($profile['github']); ?>" target="_blank" rel="noopener noreferrer" style="margin: 0 var(--spacing-3); color: var(--color-accent);">
                        <i class="fab fa-github"></i> GitHub
                    </a>
                    <?php endif; ?>
                </div>
                <div style="border-top: 1px solid var(--color-gray-700); padding-top: var(--spacing-4);">
                    <p style="color: var(--color-gray-400); margin: 0;">
                        © <?php echo date('Y'); ?> <?php echo htmlspecialchars($profile['name']); ?>. Portfolio BTS SIO SISR.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bouton retour au sommet -->
    <button id="scrollToTopBtn" class="btn btn-accent hidden" style="position: fixed; bottom: 30px; right: 30px; border-radius: var(--border-radius-full); width: 50px; height: 50px; padding: 0; display: flex; align-items: center; justify-content: center; z-index: var(--z-fixed); box-shadow: var(--shadow-lg);" title="Retour au sommet">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="/assets/js/script.js"></script>
</body>
</html>
