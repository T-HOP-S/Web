<?php
// dump_credentials.php

$conn = mysqli_connect("localhost", "root", "", "ctf_challenge");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to dump all credentials (encrypted)
$sql = "SELECT username, password FROM users";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Dumped Credentials:</h2><pre>";
    while ($row = mysqli_fetch_assoc($result)) {
        // Password is encrypted using base64 encoding (just as an example)
        echo "Username: " . $row['username'] . " | Encrypted Password: " . base64_decode($row['password']) . "\n";
    }
    echo "</pre>";
} else {
    echo "No user data found.";
}

mysqli_close($conn);
?>
