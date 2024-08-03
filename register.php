<?php
require 'functions.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    if (register($_POST['username'], $_POST['password'])) {
        header('Location: login.php');
        exit();
    } else {
        $error = 'Username already exists.';
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>

<body class="container min-vh-100">
    <div class="p-5 bg-primary text-white text-left rounded">
        <h1>Register</h1>
    </div>
    <?php if (isset($error)): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <div class="card">
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input class="form-control" type="text" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                </div>
                <button class="btn btn-primary" type="submit">Register</button>
            </form>
            <a href="login.php">Login</a>
        </div>
    </div>
</body>

</html>