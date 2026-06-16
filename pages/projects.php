<?php
/**
 * Page Projets - PROJECTS
 */
?>
<section class="container">
    <div class="section-header">
        <h2>Mes Projets</h2>
        <p>Réalisations personnelles et expériences pratiques</p>
    </div>

    <?php
    $projects = $db->get('projects');
    
    if (empty($projects)):
    ?>
    <div style="text-align: center; padding: var(--spacing-12);">
        <p style="color: var(--color-gray-600); font-size: var(--font-size-lg);">
            Aucun projet ajouté pour le moment. <a href="/admin/login.php">Connectez-vous</a> pour en ajouter.
        </p>
    </div>
    <?php
    else:
        foreach ($projects as $index => $project):
    ?>
    <div class="card observe-on-scroll" style="margin-bottom: var(--spacing-6); animation-delay: <?php echo $index * 0.1; ?>s; overflow: hidden;">
        <div class="grid grid-2" style="gap: var(--spacing-6);">
            <?php if ($project['image']): ?>
            <div>
                <img src="/assets/images/uploads/<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" style="width: 100%; height: 300px; object-fit: cover; border-radius: var(--border-radius-lg);">
            </div>
            <?php endif; ?>
            
            <div>
                <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                <p style="color: var(--color-gray-600); margin-bottom: var(--spacing-4);">
                    <?php echo nl2br(htmlspecialchars($project['description'])); ?>
                </p>
                
                <?php if ($project['technologies']): ?>
                <div style="margin-bottom: var(--spacing-4);">
                    <p style="font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">Technologies :</p>
                    <div style="display: flex; flex-wrap: wrap; gap: var(--spacing-2);">
                        <?php foreach (json_decode($project['technologies'], true) ?? [] as $tech): ?>
                        <span style="background-color: var(--color-gray-200); color: var(--color-gray-700); padding: var(--spacing-1) var(--spacing-3); border-radius: var(--border-radius-full); font-size: var(--font-size-sm);">
                            <?php echo htmlspecialchars($tech); ?>
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($project['link']): ?>
                <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-accent">
                    <i class="fas fa-external-link-alt"></i> Voir le projet
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
        endforeach;
    endif;
    ?>
</section>

<!-- Galerie de projets -->
<section style="background-color: var(--color-gray-100);">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: var(--spacing-8);">Aperçu des projets</h2>
        <div class="grid grid-3">
            <?php foreach (array_slice($projects, 0, 9) as $project): ?>
            <div class="observe-on-scroll" style="position: relative; height: 250px; overflow: hidden; border-radius: var(--border-radius-lg); cursor: pointer; box-shadow: var(--shadow-md);">
                <?php if ($project['image']): ?>
                <img src="/assets/images/uploads/<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                <?php else: ?>
                <div style="width: 100%; height: 100%; background: linear-gradient(135deg, var(--color-primary), var(--color-accent)); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-code" style="font-size: 3rem; color: var(--color-white);"></i>
                </div>
                <?php endif; ?>
                <div style="position: absolute; inset: 0; background: rgba(15, 52, 96, 0.9); display: flex; align-items: center; justify-content: center; text-align: center; color: var(--color-white); opacity: 0; transition: opacity 0.3s ease;">
                    <div>
                        <h4><?php echo htmlspecialchars($project['title']); ?></h4>
                        <p style="font-size: var(--font-size-sm);">Cliquez pour plus de détails</p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
