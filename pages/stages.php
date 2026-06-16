<?php
/**
 * Page Stages - STAGES
 */
?>
<section class="container">
    <div class="section-header">
        <h2>Mes Stages</h2>
        <p>Expériences professionnelles et apprentissages en entreprise</p>
    </div>

    <?php
    $stages = $db->get('stages');
    
    if (empty($stages)):
    ?>
    <div style="text-align: center; padding: var(--spacing-12);">
        <p style="color: var(--color-gray-600); font-size: var(--font-size-lg);">
            Aucun stage ajouté pour le moment. <a href="/admin/login.php">Connectez-vous</a> pour en ajouter.
        </p>
    </div>
    <?php
    else:
        foreach ($stages as $index => $stage):
    ?>
    <div class="card observe-on-scroll" style="margin-bottom: var(--spacing-6); animation-delay: <?php echo $index * 0.1; ?>s;">
        <div style="display: grid; grid-template-columns: auto 1fr; gap: var(--spacing-6); align-items: start;">
            <?php if ($stage['image']): ?>
            <img src="/assets/images/uploads/<?php echo htmlspecialchars($stage['image']); ?>" alt="<?php echo htmlspecialchars($stage['company']); ?>" style="width: 120px; height: 120px; border-radius: var(--border-radius-lg); object-fit: cover;">
            <?php endif; ?>
            
            <div>
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: var(--spacing-3);">
                    <div>
                        <h3><?php echo htmlspecialchars($stage['title']); ?></h3>
                        <p style="color: var(--color-accent); font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-2);">
                            <i class="fas fa-building"></i> <?php echo htmlspecialchars($stage['company']); ?>
                        </p>
                    </div>
                    <span style="background-color: var(--color-gray-200); color: var(--color-gray-700); padding: var(--spacing-2) var(--spacing-3); border-radius: var(--border-radius-base); font-size: var(--font-size-sm); white-space: nowrap;">
                        <i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($stage['start_date'])); ?> - <?php echo date('d/m/Y', strtotime($stage['end_date'])); ?>
                    </span>
                </div>
                
                <p style="margin-bottom: var(--spacing-4);">
                    <?php echo nl2br(htmlspecialchars($stage['description'])); ?>
                </p>
                
                <?php if ($stage['skills']): ?>
                <div style="display: flex; flex-wrap: wrap; gap: var(--spacing-2);">
                    <?php foreach (json_decode($stage['skills'], true) ?? [] as $skill): ?>
                    <span style="background-color: var(--color-accent); color: var(--color-gray-900); padding: var(--spacing-1) var(--spacing-3); border-radius: var(--border-radius-full); font-size: var(--font-size-sm);">
                        <?php echo htmlspecialchars($skill); ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
        endforeach;
    endif;
    ?>
</section>

<!-- Timeline -->
<section style="background-color: var(--color-gray-100);">
    <div class="container">
        <h2 style="text-align: center; margin-bottom: var(--spacing-8);">Chronologie</h2>
        <div style="position: relative; padding: var(--spacing-6) 0;">
            <div style="position: absolute; left: 50%; transform: translateX(-50%); width: 3px; height: 100%; background: linear-gradient(180deg, var(--color-accent), var(--color-primary)); display: none;"></div>
            
            <div style="display: flex; flex-direction: column; gap: var(--spacing-6);">
                <?php foreach ($stages as $stage): ?>
                <div class="observe-on-scroll" style="display: flex; align-items: center; gap: var(--spacing-4);">
                    <div style="flex: 1; text-align: right; padding-right: var(--spacing-4);">
                        <h4><?php echo htmlspecialchars($stage['company']); ?></h4>
                        <p style="color: var(--color-gray-600); font-size: var(--font-size-sm); margin: 0;">
                            <?php echo date('M Y', strtotime($stage['start_date'])); ?> - <?php echo date('M Y', strtotime($stage['end_date'])); ?>
                        </p>
                    </div>
                    <div style="width: 20px; height: 20px; background-color: var(--color-accent); border-radius: 50%; border: 4px solid var(--color-background);"></div>
                    <div style="flex: 1; padding-left: var(--spacing-4);">
                        <p style="color: var(--color-gray-600); margin: 0;">
                            <?php echo htmlspecialchars($stage['title']); ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
