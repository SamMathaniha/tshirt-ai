<?php

if(isset($_FILES['design'])) {

    $file = $_FILES['design'];
    $allowedTypes = ['image/png', 'image/jpeg'];

    if(!in_array($file['type'], $allowedTypes)) {
        die("Only PNG and JPG images are allowed!");
    }

    if($file['size'] > 100 * 1024 * 1024) {
        die("File too large! Max 2MB.");
    }

    $fileName = time() . "_" . basename($file['name']);
    $target = "uploads/" . $fileName;

    if(move_uploaded_file($file['tmp_name'], $target)) {
        header("Location: index.php?img=" . $fileName);
    } else {
        echo "Upload failed!";
    }
}
