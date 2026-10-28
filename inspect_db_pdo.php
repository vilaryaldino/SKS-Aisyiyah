<?php
$host = 'localhost';
$db   = 'sks-aisyiyah';
$user = 'root';
$pass = '';

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    
    echo "Connected successfully to $db\n";
    
    // Check Columns
    $stmt = $pdo->query("DESCRIBE data_siswa");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $col) {
        echo "Field: " . $col['Field'] . " Type: " . $col['Type'] . "\n";
    }
    
    // Check max NIS
    $stmt = $pdo->query("SELECT MAX(nis) as max_nis FROM data_siswa");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Max NIS: " . ($row['max_nis'] ?? 'None') . "\n";
    
} catch (\PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
?>
