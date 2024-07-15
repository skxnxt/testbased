<?php
include 'php/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$stmt = $pdo->prepare('SELECT * FROM characters WHERE user_id = ?');
$stmt->execute([$_SESSION['user_id']]);
$character = $stmt->fetch();

if (!$character) {
    header("Location: create_character.php");
    exit();
}

function getCharacterLevel($experience) {
    return floor($experience / 100) + 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome, <?php echo htmlspecialchars($character['name']); ?>!</h1>
        <img src="<?php echo htmlspecialchars($character['avatar']); ?>" alt="Avatar" width="100">
        <p>Level: <?php echo getCharacterLevel($character['experience']); ?></p>
        <p>Experience: <?php echo $character['experience']; ?></p>
        <a href="php/logout.php" class="btn btn-danger">Logout</a>
        <hr>
        <h2>Actions</h2>
        <button class="btn btn-primary" id="exploreBtn">Explore</button>
        <button class="btn btn-danger" id="fightBtn">Fight</button>
        <div id="actionResult" class="mt-3"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
