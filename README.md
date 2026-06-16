# Portfolio BTS SIO SISR - UI/UX PRO MAX

Un portfolio professionnel, moderne et dynamique pour les étudiants en BTS Services Informatiques aux Organisations, option Solutions d'Infrastructure, Systèmes et Réseaux (SISR).

## 🎯 Objectifs

- ✅ Portfolio dynamique et évolutif
- ✅ Panneau d'administration sécurisé (login/mot de passe)
- ✅ Design UI/UX PRO MAX (ergonomie, accessibilité, animations fluides)
- ✅ Gestion complète du contenu (compétences, stages, projets, contact)
- ✅ Responsive design (mobile-first)
- ✅ Icônes professionnelles (Font Awesome)
- ✅ Animations modernes et fluides
- ✅ Barre de navigation sticky
- ✅ Barre de progression de scroll
- ✅ Mode clair/sombre (localStorage)

## 📋 Structure du Projet

```
bts-sisr-portfolio/
├── index.php                    # Page d'accueil (routeur principal)
├── config.php                   # Configuration générale
├── admin/
│   ├── login.php               # Page de connexion
│   ├── dashboard.php           # Tableau de bord admin
│   ├── profile.php             # Gestion du profil
│   ├── skills.php              # Gestion des compétences
│   ├── stages.php              # Gestion des stages
│   └── projects.php            # Gestion des projets
├── pages/
│   ├── home.php                # Page d'accueil
│   ├── skills.php              # Page des compétences
│   ├── stages.php              # Page des stages
│   ├── projects.php            # Page des projets
│   └── contact.php             # Formulaire de contact
├── includes/
│   └── database.php            # Gestion de la base de données (JSON)
├── api/
│   ├── auth.php                # API d'authentification
│   ├── profile.php             # API du profil
│   ├── skills.php              # API des compétences
│   ├── stages.php              # API des stages
│   ├── projects.php            # API des projets
│   └── send-contact.php        # API contact
├── assets/
│   ├── css/
│   │   └── style.css           # Styles CSS (variables UI/UX PRO MAX)
│   ├── js/
│   │   └── script.js           # Scripts JavaScript
│   └── images/
│       ├── uploads/            # Images uploadées
│       └── default-avatar.jpg  # Avatar par défaut
└── data/
    ├── portfolio.json          # Base de données (JSON)
    └── contact-messages.log    # Messages de contact
```

## 🚀 Installation

### Prérequis

- PHP 7.4+
- Serveur web (Apache, Nginx, etc.)
- Navigateur moderne

### Étapes

1. **Cloner ou télécharger le projet**
   ```bash
   git clone <repo-url> bts-sisr-portfolio
   cd bts-sisr-portfolio
   ```

2. **Créer les dossiers requis**
   ```bash
   mkdir -p assets/images/uploads
   mkdir -p data
   chmod 755 data assets/images/uploads
   ```

3. **Configurer les permissions**
   ```bash
   chmod 644 config.php
   chmod 644 includes/database.php
   ```

4. **Lancer le serveur PHP (développement)**
   ```bash
   php -S localhost:8000
   ```

5. **Accéder au site**
   - Site public: `http://localhost:8000`
   - Admin: `http://localhost:8000/admin/login.php`

## 🔐 Authentification

### Identifiants par défaut

- **Mot de passe** : `admin123`

> ⚠️ **Important** : Changez le mot de passe en production !

Pour modifier le mot de passe, éditez `config.php` :

```php
define('ADMIN_PASSWORD', password_hash('votre_nouveau_mot_de_passe', PASSWORD_BCRYPT));
```

## 📄 Pages du Portfolio

### 1. Accueil (Home)
- Présentation personnelle
- Photo de profil
- Accroche dynamique
- Compétences clés
- Statistiques
- Appels à l'action

### 2. Compétences (Skills)
- Liste des compétences par catégorie
- Niveau (Débutant, Intermédiaire, Avancé)
- Barre de progression visuelle
- Icônes professionnelles
- Gestion complète via l'admin

### 3. Stages
- Chronologie des stages
- Missions et descriptions
- Compétences utilisées
- Dates et entreprises
- Gestion via l'admin

### 4. Projets
- Galerie de projets
- Descriptions détaillées
- Technologies utilisées
- Liens (GitHub, portfolio, etc.)
- Images de présentation

### 5. Contact
- Formulaire de contact
- Informations de contact
- Liens sociaux (LinkedIn, GitHub)
- Disponibilités

## ⚙️ Panneau d'Administration

### Accès

1. Allez sur `http://localhost:8000/admin/login.php`
2. Entrez le mot de passe : `admin123`
3. Accédez au dashboard

### Fonctionnalités

#### Dashboard
- Vue d'ensemble des statistiques
- Actions rapides
- Liens vers les sections d'administration

#### Profil
- Modifier votre nom et titre
- Mettre à jour la description
- Gérer les informations de contact
- Ajouter les liens sociaux (LinkedIn, GitHub)

#### Compétences
- Ajouter/modifier/supprimer des compétences
- Sélectionner une catégorie
- Définir le niveau (Débutant, Intermédiaire, Avancé)
- Choisir une icône Font Awesome
- Ajouter une description

#### Stages
- Ajouter/modifier/supprimer des stages
- Définir dates de début et fin
- Ajouter une description des missions
- Lister les compétences utilisées
- Uploader une image (logo entreprise, etc.)

#### Projets
- Ajouter/modifier/supprimer des projets
- Ajouter une description
- Lister les technologies utilisées
- Ajouter un lien (GitHub, portfolio, etc.)
- Uploader une image

## 🎨 UI/UX PRO MAX - Principes Appliqués

### 1. Variables CSS Personnalisées
- Palette de couleurs cohérente (bleu nuit, cyan, gris)
- Typographie professionnelle (Inter, Poppins)
- Espacement généreux et hiérarchique
- Ombres subtiles et cohérentes

### 2. Animations Fluides
- `fadeIn` : Apparition progressive des éléments
- `slideInLeft/Right` : Glissement latéral
- `float` : Flottement subtil
- `pulse` : Pulsation discrète
- Transitions CSS lisses sur les interactions

### 3. Micro-interactions
- Hover sur les boutons et cartes
- Focus sur les champs de formulaire
- Feedback utilisateur (notifications toast)
- Animations de chargement
- Changements de page fluides (SPA-like)

### 4. Accessibilité
- Contraste suffisant
- Textes alternatifs sur les images
- Navigation au clavier
- Sémantique HTML correcte
- Support des lecteurs d'écran

### 5. Responsive Design
- Mobile-first
- Grilles fluides
- Media queries adaptées
- Images responsives
- Menu mobile accessible

### 6. Performance
- CSS optimisé
- JavaScript minifié (optionnel)
- Lazy loading des images
- Scroll observer pour les animations
- Debounce/throttle sur les événements

## 📊 Structure des Données (JSON)

### Profil

```json
{
  "profile": {
    "name": "Votre Nom",
    "title": "Étudiant BTS SIO SISR",
    "email": "votre.email@example.com",
    "phone": "+33 6 XX XX XX XX",
    "linkedin": "https://linkedin.com/in/votre-profile",
    "github": "https://github.com/votreusername",
    "description": "Description personnelle...",
    "avatar": "avatar.jpg"
  }
}
```

### Compétence

```json
{
  "id": "unique-id",
  "name": "Windows Server 2019",
  "category": "Infrastructure",
  "level": "Avancé",
  "icon": "fas fa-server",
  "description": "Description...",
  "created_at": "2024-01-15 10:30:00"
}
```

### Stage

```json
{
  "id": "unique-id",
  "title": "Titre du stage",
  "company": "Nom de l'entreprise",
  "start_date": "2024-01-15",
  "end_date": "2024-03-31",
  "description": "Description des missions...",
  "skills": ["Compétence 1", "Compétence 2"],
  "image": "company-logo.jpg",
  "created_at": "2024-01-15 10:30:00"
}
```

### Projet

```json
{
  "id": "unique-id",
  "title": "Titre du projet",
  "description": "Description détaillée...",
  "technologies": ["Technologie 1", "Technologie 2"],
  "link": "https://github.com/...",
  "image": "project-preview.jpg",
  "created_at": "2024-01-15 10:30:00"
}
```

## 🌐 Déploiement en Production

### 1. Hébergement Recommandé
- OVH, Ionos, Hostinger, 1&1
- Support PHP 7.4+
- Certificat SSL/TLS

### 2. Configuration de Sécurité

**Modifier le mot de passe admin** (`config.php`):
```php
define('ADMIN_PASSWORD', password_hash('votre_nouveau_mot_de_passe', PASSWORD_BCRYPT));
```

**Créer un fichier `.htaccess`** (Apache):
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?page=$1 [QSA,L]
</IfModule>

# Protéger les fichiers sensibles
<FilesMatch "\.php$">
    Deny from all
</FilesMatch>
<FilesMatch "^index\.php$">
    Allow from all
</FilesMatch>
```

**Protéger le dossier `data/`**:
```apache
<FilesMatch "\.(json|log)$">
    Deny from all
</FilesMatch>
```

### 3. Upload de Fichiers
- Vérifier les types de fichiers autorisés
- Limiter la taille des images
- Renommer les fichiers uploadés
- Stocker en dehors de la racine web (optionnel)

### 4. SSL/HTTPS
- Activer HTTPS obligatoirement
- Rediriger HTTP vers HTTPS
- Certificate auto-renouvellement

## 🔧 API Endpoints

### Authentification
- `POST /api/auth.php` (action: login, password | logout)

### Profil
- `POST /api/profile.php` (action: update, name, title, email, phone, description, linkedin, github)

### Compétences
- `POST /api/skills.php` (action: add/update/delete)

### Stages
- `POST /api/stages.php` (action: add/update/delete)

### Projets
- `POST /api/projects.php` (action: add/update/delete)

### Contact
- `POST /api/send-contact.php` (name, email, subject, message)

## 💡 Améliorations Possibles

- [ ] Upload d'images avec redimensionnement
- [ ] Export PDF du portfolio
- [ ] Mode clair/sombre avancé
- [ ] Blog/Veille technologique
- [ ] Analytics légère
- [ ] Multi-langue
- [ ] Gravatar intégration
- [ ] Feed social automatisé
- [ ] SEO optimisation
- [ ] Sitemap XML
- [ ] RSS feed

## 🎓 Points Clés pour le BTS

### Points forts pour la présentation
1. **Infrastructure** : Démonstration de la gestion de contenu
2. **Sécurité** : Authentification, sanitization, protection
3. **Bases de données** : Gestion JSON (évolutif vers DB)
4. **Frontend** : Animations, responsive, accessibilité
5. **Développement web** : PHP, HTML, CSS, JavaScript

### Sections à personnaliser
- **Profil** : Votre photo, description, objectifs
- **Compétences** : Technologies du BTS SISR
- **Stages** : Vos expériences professionnelles
- **Projets** : TP, projets perso, lab réseaux

## 🤝 Support & Améliorations

Pour les questions ou améliorations :
1. Vérifiez les fichiers `data/portfolio.json`
2. Consultez les logs `data/contact-messages.log`
3. Débuggez avec la console navigateur (F12)
4. Vérifiez les permissions des dossiers

## 📚 Ressources

- [Font Awesome Icons](https://fontawesome.com/icons)
- [Google Fonts](https://fonts.google.com/)
- [MDN Web Docs](https://developer.mozilla.org/)
- [PHP Documentation](https://www.php.net/manual/en/)
- [CSS Variables](https://developer.mozilla.org/en-US/docs/Web/CSS/--*)

## 📄 Licence

Ce projet est fourni à titre éducatif pour les étudiants du BTS SIO SISR.

---

**Créé avec ❤️ pour les étudiants du BTS SIO SISR**

Version 1.0 - 2024
