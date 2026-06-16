# 🚀 DÉPLOIEMENT CLOUDFLARE - ÉTAPES CONCRÈTES (5 MIN)

## ✨ Méthode Rapide : Cloudflare Pages + Render.com Backend

### 📋 CHECKLIST PRÉ-DÉPLOIEMENT

- [ ] Compte GitHub créé (https://github.com/signup)
- [ ] Compte Cloudflare créé (https://dash.cloudflare.com/signup)
- [ ] Compte Render.com créé (https://render.com)
- [ ] Repo GitHub avec ce projet

---

## 🎯 ÉTAPE 1 : CRÉER LE REPOSITORY GITHUB (2 MIN)

### Option A : Via Interface GitHub

1. **Aller sur** https://github.com/new
2. **Créer un repo** `bts-sisr-portfolio`
3. **Initialiser avec** : `Add a README file`
4. **Créer**

### Option B : Via Terminal

```bash
cd "/media/home/DIsk 02/stage/Portefolio/bts-sisr-portfolio"

# Initialiser Git
git config --global user.email "votre@email.com"
git config --global user.name "Votre Nom"
git init

# Ajouter fichiers
git add .
git commit -m "Portfolio BTS SIO SISR - Initial commit"

# Ajouter remote (remplacer USERNAME)
git remote add origin https://github.com/USERNAME/bts-sisr-portfolio.git
git branch -M main
git push -u origin main
```

**✅ Résultat** : Repo visible sur https://github.com/USERNAME/bts-sisr-portfolio

---

## 🎯 ÉTAPE 2 : DÉPLOYER FRONTEND SUR CLOUDFLARE PAGES (2 MIN)

### Étapes

1. **Aller sur** https://pages.cloudflare.com
2. **Cliquer** "Create a project"
3. **Sélectionner** "Connect to Git"
4. **Autoriser Cloudflare** à accéder votre GitHub
5. **Sélectionner repo** `bts-sisr-portfolio`
6. **Configuration** :
   ```
   Framework: None
   Build command: (laisser vide)
   Build output directory: /
   ```
7. **Variables d'environnement** (optionnel) :
   ```
   API_BACKEND_URL = https://votre-backend.onrender.com
   ```
8. **Cliquer** "Save and deploy"

**✅ Résultat** : Site visible sur `https://bts-sisr-portfolio.pages.dev`

---

## 🎯 ÉTAPE 3 : DÉPLOYER BACKEND SUR RENDER.COM (1 MIN)

### Étapes

1. **Aller sur** https://render.com
2. **Sign up** avec GitHub
3. **Dashboard** → **"New +"** → **"Web Service"**
4. **Sélectionner repo** `bts-sisr-portfolio`
5. **Configuration** :
   ```
   Name: bts-sisr-portfolio-api
   Environment: PHP
   Build Command: (laisser vide)
   Start Command: php -S 0.0.0.0:$PORT
   ```
6. **Cliquer** "Create Web Service"

**✅ Résultat** : API visible sur `https://bts-sisr-portfolio-api.onrender.com`

---

## 🎯 ÉTAPE 4 : CONNECTER FRONTEND + BACKEND

### Modifier `config.php`

```php
<?php
// À la ligne ~10, ajouter:

// Déterminer l'URL API
if ($_SERVER['HTTP_HOST'] === 'localhost:8000') {
    // Développement local
    define('API_URL', 'http://localhost:8000');
} else {
    // Production (Cloudflare)
    define('API_URL', 'https://bts-sisr-portfolio-api.onrender.com');
}

// ... reste du code ...
```

### Modifier `assets/js/script.js`

Chercher la fonction `apiCall` et la remplacer :

```javascript
async function apiCall(endpoint, options = {}) {
    const apiUrl = window.location.hostname === 'localhost' 
        ? endpoint  
        : 'https://bts-sisr-portfolio-api.onrender.com' + endpoint;
    
    const defaultOptions = {
        headers: {
            'Content-Type': 'application/json'
        }
    };

    try {
        const response = await fetch(apiUrl, { ...defaultOptions, ...options });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
}
```

### Ajouter CORS à `config.php`

```php
<?php
// Tout en haut de config.php, ajouter:

// ========== CORS (pour Cloudflare Pages) ==========
header('Access-Control-Allow-Origin: https://bts-sisr-portfolio.pages.dev');
header('Access-Control-Allow-Origin: http://localhost:8000');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

// ... reste du code ...
```

### Commit et Push

```bash
cd "/media/home/DIsk 02/stage/Portefolio/bts-sisr-portfolio"

git add .
git commit -m "Setup Cloudflare + Render deployment"
git push origin main
```

**✅ Résultat** : Redéploiement auto sur Cloudflare Pages

---

## 🎯 ÉTAPE 5 : TESTER

### Tests Frontend

Ouvrir https://bts-sisr-portfolio.pages.dev

- [ ] Page d'accueil visible
- [ ] Navigation fonctionne
- [ ] Compétences s'affichent
- [ ] Images chargées
- [ ] Mobile responsive

### Tests Admin

1. Aller sur https://bts-sisr-portfolio.pages.dev/admin/login.php
2. Entrer mot de passe : `admin123`
3. Tester :
   - [ ] Connexion OK
   - [ ] Dashboard affiche stats
   - [ ] Clicker sur "Ajouter une compétence"
   - [ ] Formulaire fonctionne

### Tests Formulaire Contact

1. Aller sur page Contact
2. Remplir le formulaire
3. Soumettre
4. [ ] Message "Succès" s'affiche

---

## 🔐 SÉCURITÉ - ÉTAPE 6 (5 MIN)

### Ajouter un Domaine Personnalisé

1. **Acheter domaine** : GoDaddy, OVH, Namecheap (~10€/an)
2. **Sur Cloudflare** :
   - Ajouter site (https://dash.cloudflare.com/add-site)
   - Copier nameservers
   - Aller chez registrar
   - Remplacer nameservers
   - Attendre 24-48h

3. **Configurer DNS** :
   ```
   CNAME: pages.cloudflare.com
   CNAME: bts-sisr-portfolio.pages.dev
   ```

### Activer HTTPS

Cloudflare → SSL/TLS → Flexible ou Full ✅ (par défaut)

### Rate Limiting

Cloudflare → Security → WAF → Create custom rule

```
(cf.threat_score >= 30) OR
(ip.geoip.country eq "CN")
```

Action: Challenge or Block

### Protéger l'Admin

Créer `.htaccess` dans `/admin` :

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP:CF-Connecting-IP} !^203\.0\.113\.42$ [OR]
    RewriteCond %{REQUEST_METHOD} !^(GET|POST|HEAD)$
    RewriteRule ^.*$ - [F]
</IfModule>
```

---

## 📱 METTRE À JOUR LE CONTENU

### Option 1 : Via Admin Panel (Facile)

1. Aller sur admin login
2. Ajouter/modifier compétences
3. Les données se sauvegardent dans `data/portfolio.json`
4. C'est live immédiatement ✅

### Option 2 : Modifier Directement JSON

```bash
# Éditer data/portfolio.json localement
nano data/portfolio.json

# Commit et push
git add data/portfolio.json
git commit -m "Update portfolio content"
git push origin main

# Redéploiement auto (quelques secondes)
```

---

## 📊 RÉSUMÉ DÉPLOIEMENT

| Étape | Service | Temps | Gratuit? |
|-------|---------|-------|----------|
| Repository | GitHub | 1 min | ✅ |
| Frontend | Cloudflare Pages | 1 min | ✅ |
| Backend | Render.com | 1 min | ✅ |
| Configuration | Modifications | 2 min | ✅ |
| Tests | Manuel | 5 min | - |
| **TOTAL** | - | **~10 min** | **✅ 100%** |

---

## 🎯 URLS FINALES

```
🌐 Public Site:    https://bts-sisr-portfolio.pages.dev
🔐 Admin Panel:    https://bts-sisr-portfolio.pages.dev/admin/login.php
📊 API Backend:    https://bts-sisr-portfolio-api.onrender.com
👤 Mon Profil:     https://bts-sisr-portfolio.pages.dev/?page=home
```

---

## 🐛 DÉPANNAGE RAPIDE

### "404 Not Found"
→ Vérifier que Cloudflare Pages build est ✅

### "API not working"
→ Vérifier URL API dans config.php
→ Vérifier que Render.com service est ✅

### "Admin login ne fonctionne pas"
→ Vérifier CORS settings dans config.php
→ Vérifier que mot de passe PHP est hashé

### "Styles CSS manquent"
→ Vérifier que assets/css/style.css est compilé
→ Vérifier chemins relatifs

---

## 📞 SUPPORT

Besoin d'aide?

1. **Cloudflare Pages Docs** : https://developers.cloudflare.com/pages/
2. **Render Documentation** : https://render.com/docs/web-services
3. **Console Navigateur** : F12 → Console → Voir les erreurs
4. **Logs Render.com** : Dashboard → Logs

---

## 🎉 VOUS ÊTES PRÊT!

Votre portfolio est maintenant **en production** sur Cloudflare! 🚀

**Prochaines étapes** :
- [ ] Domaine personnalisé
- [ ] Activer mode clair/sombre
- [ ] Analytics Cloudflare
- [ ] Ajouter vos stages/projets

---

**Besoin de clarifications? Consultez [CLOUDFLARE-DEPLOYMENT.md](CLOUDFLARE-DEPLOYMENT.md) pour plus de détails!**
