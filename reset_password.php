<?php
// reset_password.php
$db = new mysqli('localhost', 'root', '', 'sks-aisyiyah');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$username = 'vilaryae_';
$new_password = '123456';
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$stmt = $db->prepare("UPDATE data_siswa SET password = ? WHERE username = ?");
$stmt->bind_param("ss", $hashed_password, $username);

if ($stmt->execute()) {
    echo "Password for user '$username' has been reset to '$new_password'.\n";
} else {
    echo "Error updating record: " . $db->error;
}

$stmt->close();
$db->close();
?>
