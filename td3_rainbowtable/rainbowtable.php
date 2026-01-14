<?php

$dbHost = 'localhost';
$dbName = 'td3_rainbowtable';
$dbUser = 'root';
$dbPass = 'root';
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";

$iterations = 1000000;

$start = microtime(true);

function random_password($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_[]{}<>~+=,.;:?';
    $max = strlen($chars) - 1;
    $pwd = '';
    for ($i = 0; $i < $length; $i++) {
        $pwd .= $chars[random_int(0, $max)];
    }
    return $pwd;
}

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    
    $sql = "INSERT INTO rainbow (mdp, empreintes) VALUES (:mdp, :empreintes)";
    $stmt = $pdo->prepare($sql);

    $pdo->beginTransaction();

    $countInserted = 0;
    for ($i = 0; $i < $iterations; $i++) {
        $mdp = random_password(12);

        $mdphache = hash('sha256', $mdp);
        $stmt->execute([
            ':mdp' => $mdp,
            ':empreintes' => $mdphache
        ]);

        $countInserted++;
    }
    $pdo->commit();

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Erreur : " . htmlspecialchars($e->getMessage());
    exit;
}
$end = microtime(true);
$duration = $end - $start;

echo "<p>Inséré(s) : " . intval($countInserted) . " enregistrement(s) dans <strong>rainbow</strong>.</p>";
echo "<p>Temps d'exécution : " . number_format($duration, 4) . " secondes.</p>";
?>
