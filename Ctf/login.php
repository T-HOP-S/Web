<?php
// login.php - Includes Blind SQL Injection and Time-Based SQLi

$conn = mysqli_connect("localhost", "root", "", "ctf_challenge");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// User input (vulnerable)
$username = $_POST['username'];
$password = $_POST['password'];

// Blind SQL Injection - time-based payload
$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' AND IF(1=1, SLEEP(5), 0)";
$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo "Invalid login credentials.";
    exit;
}

if (mysqli_num_rows($result) > 0) {
    // If login succeeds
    echo "Logged in!<br>";
    echo "<a href='dump_credentials.php'>Dump User Credentials</a><br>";
    echo "<a href='upload.php'>Upload File (Shell)</a>";
} else {
    // Blind SQL Injection - check if result is successful via timing
    echo "Invalid login credentials.";
}

mysqli_close($conn);
?>
