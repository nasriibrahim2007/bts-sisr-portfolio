<?php
/**
 * Page Compétences - SKILLS
 */
?>
<section class="container">
    <div class="section-header">
        <h2>Mes Compétences</h2>
        <p>Techniques et transversales acquises durant ma formation</p>
    </div>

    <?php
    $skills = $db->get('skills');
    
    if (empty($skills)):
    ?>
    <div style="text-align: center; padding: var(--spacing-12);">
        <p style="color: var(--color-gray-600); font-size: var(--font-size-lg);">
            Aucune compétence ajoutée pour le moment. <a href="/admin/login.php">Connectez-vous</a> pour en ajouter.
        </p>
    </div>
    <?php
    else:
        // Grouper les compétences par catégorie
        $skillsByCategory = [];
        foreach ($skills as $skill) {
            $category = $skill['category'] ?? 'Autre';
            if (!isset($skillsByCategory[$category])) {
                $skillsByCategory[$category] = [];
            }
            $skillsByCategory[$category][] = $skill;
        }
        
        foreach ($skillsByCategory as $category => $categorySkills):
    ?>
    <div class="mb-8" style="margin-bottom: var(--spacing-8);">
        <h3 style="color: var(--color-accent); margin-bottom: var(--spacing-6);">
            <i class="fas fa-folder"></i> <?php echo htmlspecialchars($category); ?>
        </h3>
        
        <div class="grid grid-2">
            <?php foreach ($categorySkills as $skill): ?>
            <div class="card observe-on-scroll">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-4);">
                    <div>
                        <h4 style="margin-bottom: var(--spacing-2);">
                            <i class="<?php echo htmlspecialchars($skill['icon'] ?? 'fas fa-star'); ?>" style="color: var(--color-accent); margin-right: var(--spacing-2);"></i>
                            <?php echo htmlspecialchars($skill['name']); ?>
                        </h4>
                        <p style="font-size: var(--font-size-sm); color: var(--color-gray-600); margin: 0;">
                            <?php echo htmlspecialchars($skill['description'] ?? ''); ?>
                        </p>
                    </div>
                    <span style="background-color: var(--color-accent); color: var(--color-gray-900); padding: var(--spacing-2) var(--spacing-3); border-radius: var(--border-radius-full); font-size: var(--font-size-sm); font-weight: var(--font-weight-semibold); white-space: nowrap;">
                        <?php echo htmlspecialchars($skill['level']); ?>
                    </span>
                </div>
                
                <!-- Barre de progression -->
                <div style="background-color: var(--color-gray-200); height: 8px; border-radius: var(--border-radius-full); overflow: hidden;">
                    <?php
                    $levelMap = ['Débutant' => 33, 'Intermédiaire' => 66, 'Avancé' => 100];
                    $progress = $levelMap[$skill['level']] ?? 50;
                    ?>
                    <div style="background: linear-gradient(90deg, var(--color-accent), var(--color-primary)); height: 100%; width: <?php echo $progress; ?>%; border-radius: var(--border-radius-full); transition: width 0.6s ease;"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
        endforeach;
    endif;
    ?>
</section>

<!-- Section descriptif -->
<section style="background-color: var(--color-gray-100);">
    <div class="container">
        <div class="grid grid-3">
            <div class="observe-on-scroll" style="text-align: center; padding: var(--spacing-6);">
                <div style="font-size: 2.5rem; color: var(--color-accent); margin-bottom: var(--spacing-4);">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h3>Infrastructure</h3>
                <p style="color: var(--color-gray-600);">Serveurs, virtualisation, cloud, systèmes d'exploitation</p>
            </div>
            <div class="observe-on-scroll" style="text-align: center; padding: var(--spacing-6);">
                <div style="font-size: 2.5rem; color: var(--color-accent); margin-bottom: var(--spacing-4);">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Cybersécurité</h3>
                <p style="color: var(--color-gray-600);">Firewalls, VPN, authentification, gestion d'accès</p>
            </div>
            <div class="observe-on-scroll" style="text-align: center; padding: var(--spacing-6);">
                <div style="font-size: 2.5rem; color: var(--color-accent); margin-bottom: var(--spacing-4);">
                    <i class="fas fa-network-wired"></i>
                </div>
                <h3>Réseaux</h3>
                <p style="color: var(--color-gray-600);">TCP/IP, routeurs, commutateurs, protocoles</p>
            </div>
        </div>
    </div>
</section>
