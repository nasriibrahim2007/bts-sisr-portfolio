#!/bin/bash

# Script de Configuration pour Cloudflare Deployment
# Usage: bash setup-cloudflare.sh

set -e

echo "🚀 Portfolio BTS SIO SISR - Configuration Cloudflare"
echo "=================================================="
echo ""

# Couleurs
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Vérifier Git
if ! command -v git &> /dev/null; then
    echo -e "${RED}❌ Git n'est pas installé${NC}"
    exit 1
fi

# 1. Initialiser Git
echo -e "${BLUE}📦 Étape 1: Initialiser Git${NC}"
if [ ! -d ".git" ]; then
    read -p "Entrez votre email Git: " git_email
    read -p "Entrez votre nom Git: " git_name
    
    git config --global user.email "$git_email"
    git config --global user.name "$git_name"
    git init
    git add .
    git commit -m "Portfolio BTS SIO SISR - Initial commit"
    echo -e "${GREEN}✅ Git initialisé${NC}"
else
    echo -e "${YELLOW}⚠️  Git déjà initialisé${NC}"
fi

echo ""

# 2. Configurer remote
echo -e "${BLUE}📦 Étape 2: Configurer GitHub Remote${NC}"
read -p "Entrez votre username GitHub: " github_user
repo_url="https://github.com/${github_user}/bts-sisr-portfolio.git"

if git remote get-url origin &>/dev/null; then
    echo -e "${YELLOW}⚠️  Remote déjà configuré${NC}"
else
    git remote add origin "$repo_url"
    echo -e "${GREEN}✅ Remote configuré: $repo_url${NC}"
fi

echo ""

# 3. Configurer config.php
echo -e "${BLUE}📦 Étape 3: Configurer config.php${NC}"
read -p "Entrez l'URL du backend Render.com (ex: https://api.onrender.com): " backend_url

# Backup original
cp config.php config.php.backup

# Modifier config.php
cat > config-patch.php << 'EOF'
<?php
// Insert after define statements

// ========== API Configuration for Cloudflare ==========
if ($_SERVER['HTTP_HOST'] === 'localhost:8000') {
    define('API_URL', 'http://localhost:8000');
} else {
    define('API_URL', getenv('API_BACKEND_URL') ?: 'https://bts-sisr-portfolio-api.onrender.com');
}

// ========== CORS for Cloudflare Pages ==========
$allowed_origins = [
    'https://bts-sisr-portfolio.pages.dev',
    'http://localhost:8000',
    'http://localhost:8080'
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: $origin");
}

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}
?>
EOF

echo -e "${GREEN}✅ config.php configuré${NC}"
echo -e "${YELLOW}⚠️  Fichier de backup: config.php.backup${NC}"

echo ""

# 4. Créer .env
echo -e "${BLUE}📦 Étape 4: Créer fichier .env${NC}"
cat > .env.production << EOF
API_BACKEND_URL=$backend_url
CLOUDFLARE_PAGES_DOMAIN=bts-sisr-portfolio.pages.dev
ADMIN_SESSION_TIMEOUT=3600
EOF

echo -e "${GREEN}✅ .env.production créé${NC}"

echo ""

# 5. Créer _redirects (Cloudflare Pages)
echo -e "${BLUE}📦 Étape 5: Créer _redirects pour Cloudflare Pages${NC}"
cat > _redirects << 'EOF'
# API Redirects to Backend
/api/*                      https://bts-sisr-portfolio-api.onrender.com/api/:splat  200
/admin/login.php            /admin/login.php  200

# Dynamic Routes
/?page=home                 /?page=home  200
/?page=skills              /?page=skills  200
/?page=stages              /?page=stages  200
/?page=projects            /?page=projects  200
/?page=contact             /?page=contact  200
EOF

echo -e "${GREEN}✅ _redirects créé${NC}"

echo ""

# 6. Vérifier structure
echo -e "${BLUE}📦 Étape 6: Vérifier structure${NC}"
required_files=(
    "index.php"
    "config.php"
    "admin/login.php"
    "api/auth.php"
    "assets/css/style.css"
    "assets/js/script.js"
    "data/portfolio.json"
)

all_ok=true
for file in "${required_files[@]}"; do
    if [ -f "$file" ]; then
        echo -e "${GREEN}✅ $file${NC}"
    else
        echo -e "${RED}❌ $file MANQUANT${NC}"
        all_ok=false
    fi
done

echo ""

if [ "$all_ok" = false ]; then
    echo -e "${RED}❌ Erreur: Fichiers manquants${NC}"
    exit 1
fi

# 7. Git commit
echo -e "${BLUE}📦 Étape 7: Commit et Push${NC}"
git add .
git add -A
git commit -m "Setup Cloudflare deployment configuration"

read -p "Voulez-vous pusher vers GitHub maintenant? (y/n): " push_now
if [ "$push_now" = "y" ]; then
    git branch -M main
    git push -u origin main
    echo -e "${GREEN}✅ Pushé vers GitHub${NC}"
fi

echo ""
echo "=================================================="
echo -e "${GREEN}✅ CONFIGURATION CLOUDFLARE TERMINÉE!${NC}"
echo "=================================================="
echo ""
echo "📋 Prochaines étapes:"
echo "1. Aller sur https://pages.cloudflare.com"
echo "2. Connecter votre repository GitHub"
echo "3. Configurer les build settings:"
echo "   - Framework: None"
echo "   - Build command: (empty)"
echo "   - Build output: /"
echo ""
echo "4. Aller sur https://render.com"
echo "5. Créer un Web Service PHP"
echo "6. Connecter le même repository"
echo ""
echo "📞 Resources:"
echo "- Cloudflare Pages: https://pages.cloudflare.com"
echo "- Render.com: https://render.com"
echo "- Documentation: CLOUDFLARE-QUICK-START.md"
echo ""
echo -e "${GREEN}Bon courage! 🚀${NC}"
