<?php
/**
 * Page Contact - CONTACT
 */
$profile = $db->getProfile();
?>
<section class="container">
    <div class="section-header">
        <h2>Contactez-moi</h2>
        <p>N'hésitez pas à me joindre pour discuter de collaborations ou d'opportunités</p>
    </div>

    <div class="grid grid-2" style="align-items: start; gap: var(--spacing-8);">
        <!-- Formulaire -->
        <form id="contactForm" style="display: flex; flex-direction: column; gap: var(--spacing-4);">
            <div>
                <label for="name" style="display: block; margin-bottom: var(--spacing-2); font-weight: var(--font-weight-semibold);">Votre nom</label>
                <input type="text" id="name" name="name" required style="width: 100%;" placeholder="Jean Dupont">
            </div>

            <div>
                <label for="email" style="display: block; margin-bottom: var(--spacing-2); font-weight: var(--font-weight-semibold);">Votre email</label>
                <input type="email" id="email" name="email" required style="width: 100%;" placeholder="jean@example.com">
            </div>

            <div>
                <label for="subject" style="display: block; margin-bottom: var(--spacing-2); font-weight: var(--font-weight-semibold);">Sujet</label>
                <input type="text" id="subject" name="subject" required style="width: 100%;" placeholder="Sujet de votre message">
            </div>

            <div>
                <label for="message" style="display: block; margin-bottom: var(--spacing-2); font-weight: var(--font-weight-semibold);">Message</label>
                <textarea id="message" name="message" required style="width: 100%;" placeholder="Votre message..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="align-self: flex-start;">
                <i class="fas fa-paper-plane"></i> Envoyer le message
            </button>
        </form>

        <!-- Informations de contact -->
        <div style="display: flex; flex-direction: column; gap: var(--spacing-6);">
            <div class="card observe-on-scroll">
                <h3 style="margin-bottom: var(--spacing-4);">Informations de contact</h3>
                
                <div style="margin-bottom: var(--spacing-4);">
                    <p style="font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-1);">
                        <i class="fas fa-envelope" style="color: var(--color-accent); margin-right: var(--spacing-2);"></i>Email
                    </p>
                    <p style="margin: 0;">
                        <a href="mailto:<?php echo htmlspecialchars($profile['email']); ?>">
                            <?php echo htmlspecialchars($profile['email']); ?>
                        </a>
                    </p>
                </div>

                <div style="margin-bottom: var(--spacing-4);">
                    <p style="font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-1);">
                        <i class="fas fa-phone" style="color: var(--color-accent); margin-right: var(--spacing-2);"></i>Téléphone
                    </p>
                    <p style="margin: 0;">
                        <?php echo htmlspecialchars($profile['phone']); ?>
                    </p>
                </div>

                <div style="border-top: 1px solid var(--color-gray-200); padding-top: var(--spacing-4);">
                    <p style="font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-3);">Réseaux sociaux</p>
                    <div style="display: flex; gap: var(--spacing-3); flex-wrap: wrap;">
                        <?php if ($profile['linkedin']): ?>
                        <a href="<?php echo htmlspecialchars($profile['linkedin']); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-small">
                            <i class="fab fa-linkedin"></i> LinkedIn
                        </a>
                        <?php endif; ?>
                        <?php if ($profile['github']): ?>
                        <a href="<?php echo htmlspecialchars($profile['github']); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-small">
                            <i class="fab fa-github"></i> GitHub
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Localisation -->
            <div class="card observe-on-scroll" style="text-align: center;">
                <div style="font-size: 2rem; color: var(--color-accent); margin-bottom: var(--spacing-3);">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <p style="font-weight: var(--font-weight-semibold);">Disponible pour :</p>
                <ul style="list-style: none; padding: 0;">
                    <li><i class="fas fa-check" style="color: var(--color-success); margin-right: var(--spacing-2);"></i>Stages</li>
                    <li><i class="fas fa-check" style="color: var(--color-success); margin-right: var(--spacing-2);"></i>Alternance</li>
                    <li><i class="fas fa-check" style="color: var(--color-success); margin-right: var(--spacing-2);"></i>Projets</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<script>
// Gestion du formulaire de contact
document.getElementById('contactForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/api/send-contact.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Message envoyé avec succès !', 'success');
            document.getElementById('contactForm').reset();
        } else {
            showNotification('Erreur : ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de l\'envoi du message', 'error');
    });
});
</script>
