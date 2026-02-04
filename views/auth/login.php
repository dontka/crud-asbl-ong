<?php $pageTitle = 'Connexion'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-header-content">
                    <div class="login-logo">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <h1>Connexion</h1>
                    <p>Accédez à votre compte</p>
                </div>
            </div>

            <div class="login-body">
                <?php if (isset($flash) && $flash): ?>
                    <div class="alert alert-<?php echo $flash['type'] === 'error' ? 'danger' : $flash['type']; ?>" role="alert">
                        <i class="fas fa-<?php echo $flash['type'] === 'error' ? 'exclamation-circle' : 'check-circle'; ?>"></i>
                        <?php echo htmlspecialchars($flash['message']); ?>
                    </div>
                <?php endif; ?>

                <form action="/login" method="post" data-validate>
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <i class="fas fa-user"></i> Nom d'utilisateur
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-user form-input-icon"></i>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="username" 
                                name="username" 
                                placeholder="Entrez votre nom d'utilisateur"
                                required
                                autocomplete="username"
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Mot de passe
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-lock form-input-icon"></i>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password" 
                                name="password" 
                                placeholder="Entrez votre mot de passe"
                                required
                                autocomplete="current-password"
                            >
                        </div>
                    </div>

                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember" value="1">
                        <label for="remember">Se souvenir de moi</label>
                    </div>

                    <button type="submit" class="login-submit">
                        <i class="fas fa-sign-in-alt"></i>
                        Se connecter
                    </button>
                </form>
            </div>

            <div class="login-footer">
                <p>Première visite? <a href="/register">Créer un compte</a></p>
                <p style="margin-top: var(--spacing-sm);">
                    <a href="/forgot-password" style="font-weight: 400;">Mot de passe oublié?</a>
                </p>
            </div>
        </div>
    </div>

    <script src="/assets/js/main.js"></script>
</body>
</html>