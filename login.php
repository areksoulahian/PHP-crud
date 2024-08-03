<?php
require 'functions.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    if (login($_POST['username'], $_POST['password'])) {
        header('Location: index.php');
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container text-center p-5 bg-primary text-white text-left rounded">
        <h1>Login</h1>
    </div>
    <?php if (isset($error)): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <br>
    <main class="container text-center card form-signin" style="width: 100%; max-width: 330px; padding: 15px; margin: auto;">
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input class="form-control" type="text" name="username" placeholder="Username" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password:</label>
                    <input class="form-control" type="password" name="password" placeholder="Password" required>
                </div>
                <br>
                <button class="w-100 btn btn-primary" type="submit">Login</button>
            </form>
            <br>
            <a href="register.php" class="w-100 btn btn-success">Register</a>
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-4">
        <div class="container">
            <p>&copy; 2024 PHP todo list app</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>