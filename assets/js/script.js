/**
 * Scripts utilitaires - Portfolio BTS SIO SISR
 */

// ========== DÉTECTION DE SCROLL AVEC INTERSECTION OBSERVER ==========
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observer tous les éléments avec la classe .observe-on-scroll
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.observe-on-scroll').forEach(el => {
        observer.observe(el);
    });
});

// ========== NAVIGATION ACTIVE ==========
function setActiveNavLink() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
}

document.addEventListener('DOMContentLoaded', setActiveNavLink);

// ========== SCROLL VERS LE HAUT ==========
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// ========== AFFICHER/MASQUER BOUTON SCROLL TO TOP ==========
const scrollToTopBtn = document.getElementById('scrollToTopBtn');
if (scrollToTopBtn) {
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.remove('hidden');
        } else {
            scrollToTopBtn.classList.add('hidden');
        }
    });

    scrollToTopBtn.addEventListener('click', scrollToTop);
}

// ========== BARRE DE PROGRESSION LORS DU SCROLL ==========
function updateScrollProgress() {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const scrollPercent = (scrollTop / docHeight) * 100;
    const progressBar = document.getElementById('scrollProgress');
    if (progressBar) {
        progressBar.style.width = scrollPercent + '%';
    }
}

window.addEventListener('scroll', updateScrollProgress);

// ========== FORMULAIRE DE CONTACT ==========
function handleContactForm(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    fetch('/api/send-contact.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Message envoyé avec succès !', 'success');
            form.reset();
        } else {
            showNotification('Erreur : ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de l\'envoi du message', 'error');
    });
}

// ========== NOTIFICATIONS TOAST ==========
function showNotification(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('show');
    }, 10);

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ========== COPIER TEXTE DANS LE PRESSE-PAPIERS ==========
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showNotification('Copié !', 'success');
    }).catch(() => {
        showNotification('Erreur lors de la copie', 'error');
    });
}

// ========== MODE CLAIR/SOMBRE ==========
function initDarkMode() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const htmlElement = document.documentElement;
    const savedTheme = localStorage.getItem('theme') || 'light';

    // Appliquer le thème sauvegardé
    if (savedTheme === 'dark') {
        htmlElement.setAttribute('data-theme', 'dark');
        if (darkModeToggle) darkModeToggle.checked = true;
    }

    // Écouter les changements
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', () => {
            const theme = darkModeToggle.checked ? 'dark' : 'light';
            htmlElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        });
    }
}

document.addEventListener('DOMContentLoaded', initDarkMode);

// ========== DEBOUNCE (utile pour les recherches) ==========
function debounce(func, delay) {
    let timeoutId;
    return function(...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
}

// ========== THROTTLE (utile pour le scroll) ==========
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// ========== FETCH WRAPPER ==========
async function apiCall(endpoint, options = {}) {
    const baseUrl = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1'
        ? '' 
        : ''; // En Docker/Apache, le chemin relatif est préférable

    const defaultOptions = {};
    
    // On n'ajoute le Content-Type JSON que si ce n'est pas un FormData (upload de fichier)
    if (!(options.body instanceof FormData)) {
        defaultOptions.headers = {
            'Content-Type': 'application/json'
        };
    }

    try {
        const response = await fetch(baseUrl + endpoint, { ...defaultOptions, ...options });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
}

// ========== FORMATAGE DE DATES ==========
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('fr-FR', options);
}

// ========== AJUSTEMENT DE LA HAUTEUR DES TEXTAREA ==========
function autoResizeTextarea(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = (textarea.scrollHeight) + 'px';
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('textarea[data-auto-resize]').forEach(textarea => {
        autoResizeTextarea(textarea);
        textarea.addEventListener('input', function() {
            autoResizeTextarea(this);
        });
    });
});

// ========== PRÉVENTIF ANIMATIONS LORS DU CHARGEMENT ==========
document.addEventListener('DOMContentLoaded', () => {
    document.body.classList.add('loaded');
});
