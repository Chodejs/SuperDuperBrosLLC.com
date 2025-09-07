<?php
// This file assumes check_auth.php has already been called and a session is active.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Admin Panel'; ?> - Super Brothers LLC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a href="index.php" class="text-xl font-bold hover:text-orange-400 transition-colors">
                    <i class="fas fa-tools mr-2"></i>Super Brothers LLC Admin
                </a>
                <nav class="flex items-center space-x-4">
                    <a href="../index.php" target="_blank" class="hover:text-orange-400 transition-colors text-sm" title="View Live Site">
                        <i class="fas fa-eye mr-1"></i> View Site
                    </a>
                    <span class="text-gray-400">|</span>
                    <a href="logout.php" class="hover:text-orange-400 transition-colors text-sm">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>
                </nav>
            </div>
        </div>
    </header>
    <main class="flex-grow">
