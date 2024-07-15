<?php
include 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

$user_id = $_SESSION['user_id'];
$name = $data['name'];
$avatar = $data['avatar'];

try {
    $stmt = $pdo->prepare('INSERT INTO characters (user_id, name, avatar) VALUES (?, ?, ?)');
    $stmt->execute([$user_id, $name, $avatar]);
    echo json_encode(['success' => true, 'message' => 'Character created successfully!']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Character creation failed: ' . $e->getMessage()]);
}
?>
