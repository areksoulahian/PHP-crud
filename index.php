<?php
require 'functions.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Handle form submission for adding or editing tasks
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title']) && !isset($_POST['index'])) {
        // Adding a new task
        addTodo($_POST['title']);
    } elseif (isset($_POST['title']) && isset($_POST['index'])) {
        // Editing an existing task
        updateTodo($_POST['index'], $_POST['title']);
    }
    header('Location: index.php');
    exit();
}

// Retrieve tasks
$todos = getTodos();

// Handle displaying a specific task for editing
$editIndex = isset($_GET['edit']) ? (int) $_GET['edit'] : null;
$editTask = null;
if ($editIndex !== null && isset($todos[$editIndex])) {
    $editTask = $todos[$editIndex];
}

// Handle search query
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
if ($searchQuery !== '') {
    $todos = array_filter($todos, function ($todo) use ($searchQuery) {
        return stripos($todo['title'], $searchQuery) !== false;
    });
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="container navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">To-Do List</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <main class="container mt-4 flex-fill">
        <h1>Welcome, <?php echo htmlspecialchars(getUser()); ?></h1>

        <!-- Search Form -->
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search tasks"
                    value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button type="submit" class="btn btn-secondary">Search</button>
            </div>
        </form>

        <!-- Form for adding a new task or editing an existing one -->
        <form method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" name="title" class="form-control" placeholder="Task title"
                    value="<?php echo htmlspecialchars($editTask['title'] ?? ''); ?>" required>
                <?php if ($editTask !== null): ?>
                    <input type="hidden" name="index" value="<?php echo htmlspecialchars($editIndex); ?>">
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">
                    <?php echo $editTask !== null ? 'Update Task' : 'Add Task'; ?>
                </button>
            </div>
        </form>

        <!-- Task List -->
        <ul class="list-group mt-3">
            <?php foreach ($todos as $index => $todo): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($todo['title']); ?>
                    <span>
                        <a href="?edit=<?php echo $index; ?> " class="btn btn-sm btn-warning">Edit</a>
                        <a href="todos.php?action=delete&index=<?php echo $index; ?>"
                            class="btn btn-sm btn-danger">Delete</a>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
        <!-- <a href="logout.php">Logout</a> -->
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