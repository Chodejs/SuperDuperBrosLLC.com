<?php
session_start();

// If user is already logged in, redirect to the dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}

require_once '../db_connect.php';

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $errorMessage = 'Please enter both username and password.';
    } else {
        try {
            $stmt = $db->prepare("SELECT id, username, password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                // Verify the hashed password
                if (password_verify($password, $user['password'])) {
                    // Password is correct, start a new session
                    session_regenerate_id();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    
                    header('Location: index.php');
                    exit;
                } else {
                    $errorMessage = 'Invalid username or password.';
                }
            } else {
                $errorMessage = 'Invalid username or password.';
            }
            $stmt->close();
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            $errorMessage = 'An error occurred. Please try again later.';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Super Brothers LLC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-2xl p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Super Brothers LLC</h1>
            <p class="text-gray-600">Admin Panel Login</p>
        </div>

        <?php if (!empty($errorMessage)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative mb-6" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($errorMessage); ?></span>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-user text-gray-400"></i>
                    </span>
                    <input type="text" id="username" name="username" class="shadow-sm appearance-none border rounded-lg w-full py-3 px-4 pl-10 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="admin" required>
                </div>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                 <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fas fa-lock text-gray-400"></i>
                    </span>
                    <input type="password" id="password" name="password" class="shadow-sm appearance-none border rounded-lg w-full py-3 px-4 pl-10 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent" placeholder="************" required>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-colors duration-300">
                    Sign In
                </button>
            </div>
        </form>
    </div>
</body>
</html>
