<?php
include 'php/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Character</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Create Your Character</h2>
        <form id="characterForm" novalidate>
            <div class="mb-3 text-center">
                <label class="form-label d-block">Select an Avatar</label>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="charAvatar" id="avatar1" value="img/base1.png" required>
                    <label class="form-check-label" for="avatar1">
                        <img src="img/base1.png" alt="Avatar 1" width="100">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="charAvatar" id="avatar2" value="img/base2.png" required>
                    <label class="form-check-label" for="avatar2">
                        <img src="img/base2.png" alt="Avatar 2" width="100">
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="charAvatar" id="avatar3" value="img/base3.png" required>
                    <label class="form-check-label" for="avatar3">
                        <img src="img/base3.png" alt="Avatar 3" width="100">
                    </label>
                </div>
                <div class="invalid-feedback d-block">Please select an avatar.</div>
            </div>
            <div class="mb-3">
                <label for="charName" class="form-label">Character Name</label>
                <input type="text" class="form-control" id="charName" required>
                <div class="invalid-feedback">Please enter a character name.</div>
            </div>
            <button type="submit" class="btn btn-primary">Create Character</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
