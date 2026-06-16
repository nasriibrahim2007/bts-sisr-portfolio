# 🚀 DÉMARRAGE RAPIDE - Portfolio BTS SIO SISR

## ✅ Ce qui a été livré

Un portfolio complet, professionnel et moderne pour le BTS SIO SISR avec :

### 📱 Frontend Public
- **Page d'accueil** : Présentation, statistiques, compétences clés
- **Compétences** : Listes organisées par catégorie avec barres de progression
- **Stages** : Chronologie et descriptions détaillées
- **Projets** : Galerie et descriptions
- **Contact** : Formulaire + informations

### 🔐 Backoffice Admin
- **Login** : Authentification sécurisée (mot de passe hashé)
- **Dashboard** : Vue d'ensemble avec statistiques
- **Profil** : Gestion complète des informations
- **Compétences** : CRUD complet (Ajouter, Modifier, Supprimer)
- **Stages** : Interface de gestion
- **Projets** : Interface de gestion

### 🎨 Design UI/UX PRO MAX
- Variables CSS professionnelles (bleu nuit, cyan, gris)
- Animations fluides (fadeIn, slideIn, float, pulse)
- Responsive design (mobile-first)
- Icônes Font Awesome professionnelles
- Barre de navigation sticky
- Barre de progression de scroll
- Accessible (WCAG)

### 💾 Base de Données
- Système JSON simple et évolutif
- Données de démonstration préchargées
- Structure extensible

---

## 📦 Fichiers Créés

```
bts-sisr-portfolio/
├── index.php                 # Routeur principal
├── config.php               # Configuration
├── README.md                # Documentation complète
├── .gitignore               # Fichiers à ignorer
├── admin/
│   ├── login.php           # ✅ Page de connexion
│   ├── dashboard.php       # ✅ Tableau de bord
│   ├── profile.php         # ✅ Gestion du profil
│   ├── skills.php          # ✅ Gestion des compétences
│   ├── stages.php          # Interface (contenu modifiable)
│   └── projects.php        # Interface (contenu modifiable)
├── pages/
│   ├── home.php           # ✅ Accueil
│   ├── skills.php         # ✅ Compétences
│   ├── stages.php         # ✅ Stages
│   ├── projects.php       # ✅ Projets
│   └── contact.php        # ✅ Contact
├── api/
│   ├── auth.php           # ✅ Authentification
│   ├── profile.php        # ✅ Profil
│   ├── skills.php         # ✅ Compétences
│   ├── stages.php         # API
│   ├── projects.php       # API
│   └── send-contact.php   # ✅ Contact
├── includes/
│   └── database.php       # ✅ Gestion DB (JSON)
├── assets/
│   ├── css/
│   │   └── style.css      # ✅ Styles UI/UX PRO MAX
│   ├── js/
│   │   └── script.js      # ✅ Interactions JS
│   └── images/
│       └── uploads/       # Dossier pour les uploads
└── data/
    └── portfolio.json     # ✅ Base de données
```

---

## 🎬 DÉMARRAGE EN 5 MINUTES

### 1. Vérifier PHP
```bash
php --version
```
Vous devez avoir PHP 7.4+

### 2. Créer les dossiers uploads
```bash
cd "/media/home/DIsk 02/stage/Portefolio/bts-sisr-portfolio"
mkdir -p assets/images/uploads
chmod 755 assets/images/uploads data
```

### 3. Lancer le serveur
```bash
php -S localhost:8000
```

### 4. Ouvrir dans le navigateur
- **Site public** : http://localhost:8000
- **Admin** : http://localhost:8000/admin/login.php

### 5. Connexion Admin
- **Mot de passe** : `admin123`

---

## 🔑 Points Clés de Connexion

### Site Public
```
http://localhost:8000/?page=home
http://localhost:8000/?page=skills
http://localhost:8000/?page=stages
http://localhost:8000/?page=projects
http://localhost:8000/?page=contact
```

### Admin
```
http://localhost:8000/admin/login.php
http://localhost:8000/admin/dashboard.php
http://localhost:8000/admin/profile.php
http://localhost:8000/admin/skills.php
http://localhost:8000/admin/stages.php
http://localhost:8000/admin/projects.php
```

---

## 📝 À PERSONNALISER IMMÉDIATEMENT

### 1. **Votre Profil** (`data/portfolio.json`)
```json
{
  "name": "Votre Nom",
  "title": "Votre Titre",
  "email": "votre@email.com",
  "phone": "+33 6 XX XX XX XX",
  "description": "Votre description"
}
```

### 2. **Ajouter vos Compétences**
- Allez sur http://localhost:8000/admin/dashboard.php
- Connectez-vous avec `admin123`
- Cliquez sur "Ajouter une compétence"
- Remplissez le formulaire

### 3. **Ajouter vos Stages**
- Modifiez directement `data/portfolio.json` ou utilisez l'admin

### 4. **Ajouter vos Projets**
- Modifiez directement `data/portfolio.json` ou utilisez l'admin

---

## 🔐 Sécurité - À CHANGER EN PRODUCTION

### 1. Modifier le mot de passe admin
Dans `config.php`, ligne ~18 :
```php
// AVANT:
define('ADMIN_PASSWORD', password_hash('admin123', PASSWORD_BCRYPT));

// APRÈS:
define('ADMIN_PASSWORD', password_hash('votre_nouveau_mot_de_passe_fort', PASSWORD_BCRYPT));
```

### 2. Protéger les fichiers
Créer un `.htaccess` à la racine :
```apache
# Protéger les fichiers JSON
<FilesMatch "\.json$">
    Deny from all
</FilesMatch>

# Protéger le dossier data/
<Directory "/path/to/bts-sisr-portfolio/data">
    Deny from all
</Directory>

# Protéger l'admin
<Directory "/path/to/bts-sisr-portfolio/admin">
    Require all denied
</Directory>
<FilesMatch "^(login|index)\.php$">
    Require all granted
</FilesMatch>
```

---

## 🎨 Personnalisation du Design

### Couleurs (dans `assets/css/style.css`)
```css
:root {
    --color-primary: #0f3460;        /* Bleu nuit */
    --color-accent: #00d4ff;         /* Cyan */
}
```

Changez ces valeurs pour adapter le thème !

### Polices (dans `assets/css/style.css`)
```css
:root {
    --font-primary: 'Inter', 'Segoe UI', sans-serif;
}
```

---

## 🚀 PROCHAINES ÉTAPES

### Phase 1 (Immédiat)
- [ ] Personnaliser le profil
- [ ] Ajouter vos compétences
- [ ] Ajouter vos stages
- [ ] Tester sur mobile

### Phase 2 (Court terme)
- [ ] Changer le mot de passe admin
- [ ] Ajouter votre photo de profil
- [ ] Uploader des images pour stages/projets
- [ ] Tester les formulaires

### Phase 3 (Production)
- [ ] Déployer sur un hébergement
- [ ] Configurer HTTPS
- [ ] Sécuriser les fichiers
- [ ] Ajouter Google Analytics

---

## 📚 Documentation Complète

Voir [README.md](README.md) pour :
- Installation détaillée
- Architecture complète
- API endpoints
- Déploiement production
- Améliorations futures

---

## ✨ Fonctionnalités BONUS Incluses

✅ Barre de progression de scroll  
✅ Navigation sticky  
✅ Intersection Observer (animations au scroll)  
✅ Notifications toast  
✅ Validation de formulaire  
✅ Responsive design  
✅ Mode clair/sombre (localStorage)  
✅ Micro-interactions  
✅ Scroll to top smooth  
✅ Icônes Font Awesome  

---

## 🆘 Dépannage Rapide

### Le site ne s'affiche pas
```bash
# Vérifier PHP
php --version

# Vérifier les permissions
chmod 755 data assets/images/uploads

# Lancer le serveur
php -S localhost:8000
```

### Admin ne fonctionne pas
- Vérifier que le dossier `data/` existe et est accessible
- Vérifier que le mot de passe dans `config.php` est correct

### Les images ne s'affichent pas
- Créer le dossier : `assets/images/uploads/`
- Vérifier les permissions : `chmod 755 assets/images/uploads/`

---

## 📧 Support

Pour les questions :
1. Consultez le [README.md](README.md) complet
2. Vérifiez la structure des données dans `data/portfolio.json`
3. Ouvrez la console navigateur (F12) pour les erreurs JS

---

**Votre portfolio est prêt ! 🎉**

Personnalisez-le, ajoutez votre contenu, et présentez votre formation avec fierté !

---

*Portfolio BTS SIO SISR - UI/UX PRO MAX - Version 1.0*
