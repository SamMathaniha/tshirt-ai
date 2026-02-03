<?php
$conn = new mysqli("localhost", "root", "", "tshirt_system");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $conn->prepare("INSERT INTO designs (image, position_left, position_top, width, rotation, view) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiis", $data['img'], $data['left'], $data['top'], $data['width'], $data['rotation'], $data['view']);
    $stmt->execute();
    echo json_encode(["status" => "success"]);
}
