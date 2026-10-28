<?php
// inspect_users.php
$db = new mysqli('localhost', 'root', '', 'sks-aisyiyah');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sql = "SELECT nis, username, nama, role FROM data_siswa";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    echo "Existing Users:\n";
    echo str_pad("NIS", 10) . str_pad("Username", 20) . str_pad("Role", 10) . "Nama\n";
    echo str_repeat("-", 60) . "\n";
    while($row = $result->fetch_assoc()) {
        echo str_pad($row['nis'], 10) . str_pad($row['username'], 20) . str_pad($row['role'] ?? 'NULL', 10) . $row['nama'] . "\n";
    }
} else {
    echo "No users found in data_siswa table.\n";
}
$db->close();
?>
