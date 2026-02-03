<?php

if(isset($_FILES['design'])) {

    $file = $_FILES['design'];
    $fileName = time() . "_" . $file['name'];
    $target = "uploads/" . $fileName;

    move_uploaded_file($file['tmp_name'], $target);

    header("Location: index.php?img=" . $fileName);
}
