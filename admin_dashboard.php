<?php
require_once 'partials/check_auth.php';
$pageTitle = "Admin Dashboard";
include 'partials/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>
    
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-2xl font-semibold text-gray-700">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p class="text-gray-600 mt-2">This is the control panel for the Super Brothers LLC website. From here, you can manage content that appears on the public site.</p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Manage Reviews Card -->
        <a href="manage_reviews.php" class="block p-6 bg-white rounded-lg shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-full">
                    <i class="fas fa-star fa-2x text-orange-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-800">Manage Reviews</h3>
                    <p class="text-gray-600 mt-1">Add, edit, or remove client testimonials.</p>
                </div>
            </div>
        </a>

        <!-- Manage Portfolio Card (Placeholder) -->
        <div class="block p-6 bg-gray-200 rounded-lg shadow-lg cursor-not-allowed opacity-60">
            <div class="flex items-center">
                <div class="p-3 bg-gray-300 rounded-full">
                    <i class="fas fa-image fa-2x text-gray-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-600">Manage Portfolio</h3>
                    <p class="text-gray-500 mt-1">Coming Soon: Update project photos.</p>
                </div>
            </div>
        </div>

        <!-- Site Settings Card (Placeholder) -->
        <div class="block p-6 bg-gray-200 rounded-lg shadow-lg cursor-not-allowed opacity-60">
            <div class="flex items-center">
                <div class="p-3 bg-gray-300 rounded-full">
                    <i class="fas fa-palette fa-2x text-gray-500"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-600">Site Settings</h3>
                    <p class="text-gray-500 mt-1">Coming Soon: Change website colors.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
