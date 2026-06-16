<?php
/**
 * Page d'accueil - HOME
 */
$profile = $db->getProfile();
?>
<section style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%); color: var(--color-white); padding: var(--spacing-20) var(--spacing-4); text-align: center;">
    <div class="container observe-on-scroll" style="animation-delay: 0.1s;">
        <h1 style="color: var(--color-white); font-size: var(--font-size-5xl); margin-bottom: var(--spacing-4);">
            Bienvenue ! 👋
        </h1>
        <h2 style="color: var(--color-accent); font-size: var(--font-size-2xl); font-weight: var(--font-weight-normal); margin-bottom: var(--spacing-6);">
            Je suis <?php echo htmlspecialchars($profile['name']); ?>
        </h2>
        <p style="font-size: var(--font-size-lg); max-width: 600px; margin: 0 auto var(--spacing-6); color: var(--color-gray-200);">
            <?php echo nl2br(htmlspecialchars($profile['description'])); ?>
        </p>
        <div style="display: flex; gap: var(--spacing-4); justify-content: center; flex-wrap: wrap;">
            <a href="/?page=skills" class="btn btn-accent" style="color: var(--color-gray-900);">
                <i class="fas fa-star"></i> Voir mes compétences
            </a>
            <a href="/?page=contact" class="btn btn-outline" style="border-color: var(--color-white); color: var(--color-white);">
                <i class="fas fa-envelope"></i> Me contacter
            </a>
        </div>
    </div>
</section>

<!-- À propos -->
<section class="container">
    <div class="grid grid-2" style="align-items: center;">
        <div class="observe-on-scroll slide-in-left">
            <img src="/assets/images/<?php echo htmlspecialchars($profile['avatar'] ?? 'default-avatar.jpg'); ?>" alt="<?php echo htmlspecialchars($profile['name']); ?>" style="width: 100%; border-radius: var(--border-radius-xl); box-shadow: var(--shadow-xl);">
        </div>
        <div class="observe-on-scroll slide-in-right">
            <h2>À propos de moi</h2>
            <p>
                Je suis un étudiant en première année de BTS Services Informatiques aux Organisations (SIO), option Solutions d'Infrastructure, Systèmes et Réseaux (SISR).
            </p>
            <p>
                Mon objectif est d'acquérir les compétences techniques et transversales nécessaires pour devenir un professionnel de l'infrastructure informatique et des réseaux.
            </p>
            <p style="margin-bottom: var(--spacing-6);">
                À travers mes stages et projets, je développe mon expertise dans la gestion des serveurs, la virtualisation, la cybersécurité et la gestion de parc informatique.
            </p>
            <a href="/?page=stages" class="btn btn-primary">
                <i class="fas fa-briefcase"></i> Voir mes stages
            </a>
        </div>
    </div>
</section>

<!-- Compétences clés -->
<section style="background-color: var(--color-gray-100);">
    <div class="container">
        <div class="section-header">
            <h2>Compétences Clés</h2>
            <p>Les technologies et domaines sur lesquels je travaille</p>
        </div>
        
        <div class="grid grid-3">
            <?php
            $skills = $db->get('skills');
            $featured_skills = array_slice($skills, 0, 6); // Afficher les 6 premières
            
            if (empty($featured_skills)):
            ?>
            <div class="card observe-on-scroll" style="text-align: center; padding: var(--spacing-8);">
                <div style="font-size: 3rem; margin-bottom: var(--spacing-4); color: var(--color-gray-400);">
                    <i class="fas fa-server"></i>
                </div>
                <h3 style="color: var(--color-gray-600);">Infrastructure</h3>
                <p style="color: var(--color-gray-500);">Windows Server, Linux, Virtualisation</p>
            </div>
            <div class="card observe-on-scroll" style="text-align: center; padding: var(--spacing-8);">
                <div style="font-size: 3rem; margin-bottom: var(--spacing-4); color: var(--color-gray-400);">
                    <i class="fas fa-network-wired"></i>
                </div>
                <h3 style="color: var(--color-gray-600);">Réseaux</h3>
                <p style="color: var(--color-gray-500);">TCP/IP, Cisco, Commutation</p>
            </div>
            <div class="card observe-on-scroll" style="text-align: center; padding: var(--spacing-8);">
                <div style="font-size: 3rem; margin-bottom: var(--spacing-4); color: var(--color-gray-400);">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 style="color: var(--color-gray-600);">Sécurité</h3>
                <p style="color: var(--color-gray-500);">Firewalls, VPN, Authentification</p>
            </div>
            <?php
            else:
                foreach ($featured_skills as $index => $skill):
            ?>
            <div class="card observe-on-scroll" style="text-align: center; padding: var(--spacing-8); animation-delay: <?php echo $index * 0.1; ?>s;">
                <div style="font-size: 3rem; margin-bottom: var(--spacing-4); color: var(--color-accent);">
                    <i class="<?php echo htmlspecialchars($skill['icon'] ?? 'fas fa-star'); ?>"></i>
                </div>
                <h3><?php echo htmlspecialchars($skill['name']); ?></h3>
                <p style="color: var(--color-gray-600);"><?php echo htmlspecialchars($skill['category']); ?></p>
                <div style="display: flex; justify-content: space-between; font-size: var(--font-size-sm); color: var(--color-gray-600); margin-top: var(--spacing-3);">
                    <span><?php echo htmlspecialchars($skill['level']); ?></span>
                </div>
            </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>

        <div style="text-align: center; margin-top: var(--spacing-8);">
            <a href="/?page=skills" class="btn btn-primary">
                <i class="fas fa-arrow-right"></i> Voir toutes les compétences
            </a>
        </div>
    </div>
</section>

<!-- Statistiques -->
<section class="container">
    <div class="grid grid-4" style="text-align: center;">
        <div class="observe-on-scroll" style="padding: var(--spacing-6);">
            <div style="font-size: var(--font-size-4xl); font-weight: var(--font-weight-bold); color: var(--color-accent); margin-bottom: var(--spacing-2);">
                <?php echo count($db->get('stages')); ?>+
            </div>
            <p style="font-weight: var(--font-weight-semibold); color: var(--color-gray-700);">Stages Réalisés</p>
        </div>
        <div class="observe-on-scroll" style="padding: var(--spacing-6);">
            <div style="font-size: var(--font-size-4xl); font-weight: var(--font-weight-bold); color: var(--color-accent); margin-bottom: var(--spacing-2);">
                <?php echo count($db->get('projects')); ?>+
            </div>
            <p style="font-weight: var(--font-weight-semibold); color: var(--color-gray-700);">Projets Complétés</p>
        </div>
        <div class="observe-on-scroll" style="padding: var(--spacing-6);">
            <div style="font-size: var(--font-size-4xl); font-weight: var(--font-weight-bold); color: var(--color-accent); margin-bottom: var(--spacing-2);">
                <?php echo count($db->get('skills')); ?>+
            </div>
            <p style="font-weight: var(--font-weight-semibold); color: var(--color-gray-700);">Compétences</p>
        </div>
        <div class="observe-on-scroll" style="padding: var(--spacing-6);">
            <div style="font-size: var(--font-size-4xl); font-weight: var(--font-weight-bold); color: var(--color-accent); margin-bottom: var(--spacing-2);">
                2024
            </div>
            <p style="font-weight: var(--font-weight-semibold); color: var(--color-gray-700);">En cours de formation</p>
        </div>
    </div>
</section>
