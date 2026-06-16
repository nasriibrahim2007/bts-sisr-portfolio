<?php
require_once '../config.php';

// Si déjà connecté, rediriger vers le dashboard
if (isAdminLogged()) {
    header('Location: /admin/dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification - Admin</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
        }
        
        .login-container {
            background: var(--color-white);
            border-radius: var(--border-radius-xl);
            padding: var(--spacing-8);
            box-shadow: var(--shadow-2xl);
            width: 100%;
            max-width: 400px;
        }
        
        .login-container h1 {
            text-align: center;
            margin-bottom: var(--spacing-8);
            color: var(--color-primary);
        }
        
        .login-form {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-4);
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            font-weight: var(--font-weight-semibold);
            margin-bottom: var(--spacing-2);
            color: var(--color-gray-700);
        }
        
        .form-group input {
            padding: var(--spacing-3) var(--spacing-4);
            border: 1px solid var(--color-gray-300);
            border-radius: var(--border-radius-base);
            font-family: var(--font-primary);
            font-size: var(--font-size-base);
            transition: all var(--transition-fast);
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--color-accent);
            box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
        }
        
        .error-message {
            color: var(--color-danger);
            font-size: var(--font-size-sm);
            text-align: center;
            padding: var(--spacing-3);
            background-color: rgba(239, 68, 68, 0.1);
            border-radius: var(--border-radius-base);
            display: none;
        }
        
        .error-message.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <a href="/" style="display: inline-block; margin-bottom: 20px; color: var(--color-primary); text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Retour à l'accueil
        </a>

        <h1><i class="fas fa-lock"></i> Authentification</h1>
        
        <div id="errorMessage" class="error-message"></div>
        
        <form class="login-form" id="loginForm">
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required placeholder="Entrez votre mot de passe" autofocus>
            </div>
            
            <button type="submit" class="btn btn-primary" style="margin-top: var(--spacing-2);">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>
        
        <p style="text-align: center; margin-top: var(--spacing-6); color: var(--color-gray-600); font-size: var(--font-size-sm);">
            Mot de passe par défaut : <code style="background-color: var(--color-gray-100); padding: 2px 4px; border-radius: 2px;">admin123</code>
        </p>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const password = document.getElementById('password').value;
            const errorDiv = document.getElementById('errorMessage');
            
            try {
                const response = await fetch('/api/auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        action: 'login',
                        password: password
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.location.href = '/admin/dashboard.php';
                } else {
                    errorDiv.textContent = data.message;
                    errorDiv.classList.add('show');
                }
            } catch (error) {
                console.error('Erreur:', error);
                errorDiv.textContent = 'Erreur lors de la connexion';
                errorDiv.classList.add('show');
            }
        });
    </script>
</body>
</html>
