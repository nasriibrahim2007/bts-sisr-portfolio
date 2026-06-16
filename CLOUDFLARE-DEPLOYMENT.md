# 🚀 DÉPLOIEMENT SUR CLOUDFLARE - Guide Complet

## 📌 Options de Déploiement

### Option 1️⃣ : **RECOMMANDÉE - Cloudflare Pages + Backend PHP Ailleurs**
- ✅ Facile à mettre en place
- ✅ Garde votre PHP fonctionnel
- ✅ Gratuit (avec limites)
- ⚠️ Nécessite un serveur pour le PHP

### Option 2️⃣ : **Cloudflare Workers** (JavaScript)
- ✅ Backend serverless sur Cloudflare
- ✅ Pas besoin d'autre serveur
- ⚠️ Nécessite de réécrire le PHP en JavaScript
- ⚠️ Plus complexe

### Option 3️⃣ : **Cloudflare Pages (Frontend Statique)**
- ✅ Déployer uniquement le frontend
- ✅ API backend pointant vers votre serveur PHP
- ✅ Meilleur CDN global
- ⚠️ Vous gardez le serveur PHP

---

## 🎯 OPTION 1 - RECOMMANDÉE (Pages + PHP Backend)

### Étape 1 : Créer un Repository GitHub

```bash
cd "/media/home/DIsk 02/stage/Portefolio/bts-sisr-portfolio"

# Initialiser Git
git init
git add .
git commit -m "Portfolio BTS SIO SISR - Initial commit"

# Créer un repo sur GitHub (https://github.com/new)
# Puis :
git remote add origin https://github.com/votre-username/bts-sisr-portfolio.git
git branch -M main
git push -u origin main
```

### Étape 2 : Adapter le Projet pour Cloudflare Pages

Créer un fichier `wrangler.toml` à la racine :

```toml
name = "bts-sisr-portfolio"
type = "javascript"
account_id = "votre_account_id"
workers_dev = true
route = ""
zone_id = ""

[env.production]
name = "bts-sisr-portfolio-prod"
route = "votre-domaine.com/*"
```

### Étape 3 : Créer `_redirects` (Cloudflare Pages)

Fichier `_redirects` à la racine du projet :

```
# Rediriger les routes vers index.html pour le SPA
/?page=home                   /index.html   200
/?page=skills                 /index.html   200
/?page=stages                 /index.html   200
/?page=projects               /index.html   200
/?page=contact                /index.html   200

# API calls vers votre backend PHP
/api/*                        https://votre-api-backend.com/api/:splat  200

# Admin vers le backend
/admin/*                      https://votre-api-backend.com/admin/:splat 200
```

### Étape 4 : Se Connecter à Cloudflare

1. **Créer un compte** : https://dash.cloudflare.com/sign-up
2. **Aller à Cloudflare Pages** : https://pages.cloudflare.com/
3. **"Create a Project"** → **Connect to Git**
4. **Sélectionner votre repository** `bts-sisr-portfolio`
5. **Configuration** :
   - Framework preset: `None`
   - Build command: (laisser vide)
   - Build output directory: `/` (racine)
6. **Deploy**

### Étape 5 : Pointer votre Backend PHP

**Option A : Hébergement PHP Classique**

```bash
# Utilisez OVH, Ionos, Hostinger, etc.
# Déployer le dossier sur votre serveur
# Votre API sera sur : https://votre-domaine-backend.com/

# Puis modifier dans le projet:
# assets/js/script.js - Changer les appels API
```

**Option B : Heroku/Railway/Render (Gratuit ou Freemium)**

```bash
# Exemple avec Render.com (gratuit)

# 1. Créer un account https://render.com
# 2. Créer un nouveau "Web Service"
# 3. Connecter votre GitHub
# 4. Settings:
#    - Runtime: PHP
#    - Build command: composer install (si needed)
#    - Start command: php -S 0.0.0.0:8000
# 5. Deploy

# Votre API sera: https://votre-service.onrender.com/
```

---

## 🛠️ OPTION 2 - CLOUDFLARE WORKERS (Serverless JavaScript)

### Avantages
- ✅ Aucun serveur à maintenir
- ✅ Exécution ultra-rapide
- ✅ Gratuit (50k requêtes/jour)

### Inconvénients
- ⚠️ Nécessite réécrire le PHP en JavaScript

### Étapes

#### 1. Installer Wrangler

```bash
npm install -g @cloudflare/wrangler
wrangler login
```

#### 2. Créer un Projet Wrangler

```bash
cd "/media/home/DIsk 02/stage/Portefolio/bts-sisr-portfolio"
wrangler init
```

#### 3. Créer `src/index.js` (Backend Workers)

```javascript
// Fichier: src/index.js
export default {
  async fetch(request) {
    const url = new URL(request.url);
    
    // Servir les fichiers statiques
    if (url.pathname.startsWith('/api/')) {
      return handleAPI(request);
    }
    
    // Rediriger vers index.html
    return new Response(getIndexHTML(), {
      headers: { 'Content-Type': 'text/html' }
    });
  }
};

async function handleAPI(request) {
  const url = new URL(request.url);
  const path = url.pathname;
  
  // API Auth
  if (path === '/api/auth.php') {
    return handleAuth(request);
  }
  
  // API Skills
  if (path === '/api/skills.php') {
    return handleSkills(request);
  }
  
  return new Response('Not Found', { status: 404 });
}

async function handleAuth(request) {
  if (request.method !== 'POST') {
    return new Response('Method not allowed', { status: 405 });
  }
  
  const data = await request.formData();
  const action = data.get('action');
  
  if (action === 'login') {
    const password = data.get('password');
    
    // Vérifier mot de passe (À STOCKER DANS UN VRAI SECRET!)
    if (password === 'admin123') {
      return new Response(JSON.stringify({
        success: true,
        message: 'Login successful'
      }), {
        headers: { 'Content-Type': 'application/json' }
      });
    }
  }
  
  return new Response(JSON.stringify({
    success: false,
    message: 'Invalid password'
  }), {
    headers: { 'Content-Type': 'application/json' }
  });
}

function getIndexHTML() {
  // Retourner le HTML
  return `<!DOCTYPE html>...`;
}
```

#### 4. Configurer `wrangler.toml`

```toml
name = "bts-sisr-portfolio"
type = "javascript"
account_id = "votre_account_id"
workers_dev = true

[env.production]
name = "bts-sisr-portfolio-prod"
route = "https://votre-domaine.com/*"
zone_id = "votre_zone_id"
```

#### 5. Déployer

```bash
wrangler deploy
```

---

## 📌 OPTION 3 - SOLUTION HYBRIDE (RECOMMANDÉE POUR COMMENCER)

### Architecture

```
┌─────────────────────────────────────────────────────────┐
│           Cloudflare Pages (Frontend CDN)               │
│  - HTML/CSS/JS optimisés                               │
│  - Déploiement automatique depuis GitHub               │
│  - Cache global                                        │
└──────────────────┬──────────────────────────────────────┘
                   │ API Calls
                   ▼
┌─────────────────────────────────────────────────────────┐
│        Backend PHP (Votre Serveur Perso)               │
│  - data/portfolio.json                                 │
│  - Logique authentification                            │
│  - Gestion des données                                 │
└─────────────────────────────────────────────────────────┘
```

### Mise en Place

#### 1. Modifier `config.php`

```php
<?php
// config.php - Adapter pour Cloudflare Pages

// URL de base pour les API calls
define('API_BASE_URL', 'https://votre-api-backend.com');

// ... reste du code ...
```

#### 2. Modifier `assets/js/script.js`

```javascript
// Dans script.js - Adapter les appels API

async function apiCall(endpoint, options = {}) {
    const apiUrl = window.location.hostname === 'localhost' 
        ? endpoint  // Local
        : 'https://votre-api-backend.com' + endpoint;  // Production
    
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

#### 3. Créer un fichier `functions.php` pour CORS

```php
<?php
// includes/cors.php

header('Access-Control-Allow-Origin: https://votre-cloudflare-domain.pages.dev');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}
```

#### 4. Déployer sur GitHub

```bash
cd "/media/home/DIsk 02/stage/Portefolio/bts-sisr-portfolio"
git add .
git commit -m "Adapter pour Cloudflare Pages"
git push origin main
```

#### 5. Déployer le Backend PHP

**Sur Render.com (Gratuit)**

```bash
# 1. Créer un compte https://render.com
# 2. Create New → Web Service
# 3. Connect GitHub (connecter au repo)
# 4. Configuration:
#    - Name: bts-sisr-portfolio-api
#    - Runtime: PHP
#    - Build command: (laisser vide)
#    - Start command: php -S 0.0.0.0:10000
# 5. Environment:
#    - Add: PORT=10000
# 6. Deploy
```

#### 6. Configurer Cloudflare Pages

```bash
# 1. Aller sur https://pages.cloudflare.com
# 2. Connect to Git
# 3. Sélectionner le repository
# 4. Configuration:
#    - Framework: None
#    - Build command: (vide)
#    - Build output: /
#    - Environment: 
#        API_BACKEND_URL = https://votre-service.onrender.com
# 5. Deploy
```

---

## ✅ CHECKLIST DE DÉPLOIEMENT

### Avant le Déploiement

- [ ] Code commit et push sur GitHub
- [ ] Variables sensibles (mot de passe) sécurisées
- [ ] URLs API correctes dans config
- [ ] Tests locaux validés
- [ ] HTTPS activé partout

### Pendant le Déploiement

- [ ] Cloudflare Pages connecté
- [ ] Build validé
- [ ] API Backend en ligne
- [ ] Tests de connectivité

### Après le Déploiement

- [ ] Tester toutes les pages
- [ ] Tester formulaires
- [ ] Tester login admin
- [ ] Vérifier les performances (Lighthouse)
- [ ] Configurer domaine personnalisé

---

## 🔒 SÉCURITÉ POUR PRODUCTION

### 1. Variables d'Environnement

Créer `.env.production` :

```env
API_BACKEND_URL=https://votre-api-backend.com
ADMIN_PASSWORD_HASH=votre_hash_bcrypt
CLOUDFLARE_API_TOKEN=votre_token
```

### 2. Cloudflare Nameservers

```bash
# Ajouter votre domaine à Cloudflare
# Copier les nameservers
# Les mettre chez votre registrar (GoDaddy, OVH, etc.)
```

### 3. SSL/TLS

```bash
# Cloudflare → SSL/TLS
# Full (strict) ou Full
# Auto Redirect HTTP to HTTPS activé
```

### 4. Firewall Rules

```bash
# Cloudflare → Security → WAF
# Ajouter rule pour bloquer requêtes suspectes
# Rate limiting: 100 req/min par IP
```

---

## 📊 COMPARAISON DES OPTIONS

| Option | Gratuit | Facilité | Performance | Maintenance |
|--------|---------|----------|-------------|------------|
| **Option 1** (Pages + PHP) | ✅ | ⭐⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐ |
| **Option 2** (Workers) | ✅ | ⭐⭐ | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐ |
| **Option 3** (Hybride) | ✅ | ⭐⭐⭐ | ⭐⭐⭐⭐ | ⭐⭐⭐ |

---

## 🚀 DÉMARRAGE RECOMMANDÉ

**Pour commencer rapidement (Option 1)** :

```bash
# 1. Créer repo GitHub
git init
git add .
git commit -m "Initial commit"
git remote add origin <votre-repo>
git push -u origin main

# 2. Aller sur https://pages.cloudflare.com
# 3. Connect Git repository
# 4. Deploy automatique ✅

# 5. Déployer backend PHP sur Render.com
# Puis updater config.php avec l'URL backend
```

**Résultat** :
- Frontend rapide sur Cloudflare (CDN global)
- Backend PHP fonctionnel sur Render
- Temps de déploiement : ~5 minutes

---

## 💰 COÛTS (2024)

### Cloudflare Pages
- **Gratuit** : 500 builds/mois, déploiement illimité
- **Pro** : $20/mois si vous voulez plus

### Backend (Render.com)
- **Gratuit** : 750h/mois (suffit pour un petit site)
- **Pro** : $7/mois

### Domaine personnalisé
- **Registrar** : ~10€/an (GoDaddy, OVH)
- **Cloudflare** : Gratuit si domaine

**Total** : ~10€/an pour petit projet, ou gratuit si pas de domaine perso

---

## 🔗 RESSOURCES UTILES

- **Cloudflare Pages Docs** : https://developers.cloudflare.com/pages/
- **Cloudflare Workers Docs** : https://developers.cloudflare.com/workers/
- **Render.com Docs** : https://render.com/docs
- **Git/GitHub Guide** : https://guides.github.com/

---

## ❓ QUESTIONS FRÉQUENTES

**Q: Je veux tout gratuit?**
A: Oui! Cloudflare Pages (gratuit) + Render.com (gratuit avec limites) + domaine rien (.pages.dev)

**Q: J'ai un domaine personnalisé?**
A: Ajouter à Cloudflare, puis configurer nameservers

**Q: Comment mettre à jour le contenu?**
A: Via l'admin ou en modifiant data/portfolio.json sur GitHub (redéploiement auto)

**Q: C'est sécurisé?**
A: Oui, HTTPS par défaut, WAF Cloudflare inclus, mot de passe hashé

---

**Prêt à déployer? 🚀 Commencez par l'Option 1 - HYBRIDE!**
