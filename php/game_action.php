<?php
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'];

try {
    $stmt = $pdo->prepare('SELECT * FROM characters WHERE user_id = ?');
    $stmt->execute([$user_id]);
    $character = $stmt->fetch();

    if (!$character) {
        echo json_encode(['success' => false, 'message' => 'Character not found']);
        exit();
    }

    $new_experience = $character['experience'];
    $message = '';

    if ($action === 'explore') {
        $exp_gain = rand(5, 15);
        $new_experience += $exp_gain;
        $message = "You explored and gained $exp_gain experience!";
    } elseif ($action === 'fight') {
        $exp_gain = rand(10, 30);
        $new_experience += $exp_gain;
        $message = "You fought and gained $exp_gain experience!";
    }

    $stmt = $pdo->prepare('UPDATE characters SET experience = ? WHERE user_id = ?');
    $stmt->execute([$new_experience, $user_id]);

    echo json_encode(['success' => true, 'message' => $message, 'new_experience' => $new_experience]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Action failed: ' . $e->getMessage()]);
}
?>
