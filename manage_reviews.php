<?php
require_once 'partials/check_auth.php';
require_once '../db_connect.php';

$formMessage = '';
$formError = false;

// Handle form submission for adding a new review
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_review'])) {
    $author = trim($_POST['author'] ?? '');
    $project = trim($_POST['project'] ?? '');
    $rating = (int)($_POST['rating'] ?? 5);
    $text = trim($_POST['text'] ?? '');
    $review_date = trim($_POST['review_date'] ?? '');

    if (empty($author) || empty($text) || empty($review_date)) {
        $formMessage = 'Please fill out all required fields (Author, Date, and Text).';
        $formError = true;
    } elseif ($rating < 1 || $rating > 5) {
        $formMessage = 'Rating must be between 1 and 5.';
        $formError = true;
    } else {
        try {
            $stmt = $db->prepare("INSERT INTO reviews (author, project, rating, text, review_date, is_visible) VALUES (?, ?, ?, ?, ?, 1)");
            $stmt->bind_param("ssiss", $author, $project, $rating, $text, $review_date);
            if ($stmt->execute()) {
                $formMessage = 'Successfully added the new review!';
                $formError = false;
            } else {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            error_log("Add review error: " . $e->getMessage());
            $formMessage = 'An error occurred while adding the review. Please try again.';
            $formError = true;
        }
    }
}

// Handle review deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_review'])) {
    $review_id = (int)$_POST['review_id'];
    try {
        $stmt = $db->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $review_id);
        if ($stmt->execute()) {
            $formMessage = "Review successfully deleted.";
            $formError = false;
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log("Delete review error: " . $e->getMessage());
        $formMessage = 'An error occurred while deleting the review.';
        $formError = true;
    }
}

// Fetch all reviews from the database to display
$reviews = [];
try {
    $result = $db->query("SELECT id, author, project, rating, text, review_date, is_visible FROM reviews ORDER BY review_date DESC");
    if ($result) {
        $reviews = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
    }
} catch (Exception $e) {
    error_log("Fetch reviews error: " . $e->getMessage());
    $reviewsFetchError = "Could not fetch reviews from the database.";
}


$pageTitle = "Manage Reviews";
include 'partials/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manage Client Reviews</h1>

    <?php if (!empty($formMessage)): ?>
        <div class="mb-6 p-4 rounded-md <?php echo $formError ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700'; ?>" role="alert">
            <?php echo htmlspecialchars($formMessage); ?>
        </div>
    <?php endif; ?>

    <!-- Add New Review Form -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Add a New Review</h2>
        <form action="manage_reviews.php" method="POST" class="space-y-4">
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700">Author Name *</label>
                    <input type="text" name="author" id="author" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                </div>
                 <div>
                    <label for="review_date" class="block text-sm font-medium text-gray-700">Review Date *</label>
                    <input type="date" name="review_date" id="review_date" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                </div>
                <div>
                    <label for="project" class="block text-sm font-medium text-gray-700">Project Type</label>
                    <input type="text" name="project" id="project" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                </div>
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating (1-5) *</label>
                    <input type="number" name="rating" id="rating" min="1" max="5" value="5" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                </div>
            </div>
            <div>
                <label for="text" class="block text-sm font-medium text-gray-700">Review Text *</label>
                <textarea name="text" id="text" rows="4" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500"></textarea>
            </div>
            <div>
                <button type="submit" name="add_review" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition-colors">
                    <i class="fas fa-plus mr-2"></i>Add Review
                </button>
            </div>
        </form>
    </div>

    <!-- Existing Reviews List -->
    <div class="bg-white p-6 rounded-lg shadow-md">
         <h2 class="text-2xl font-semibold text-gray-700 mb-4">Existing Reviews</h2>
         <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (isset($reviewsFetchError)): ?>
                        <tr><td colspan="5" class="text-center py-4 text-red-500"><?php echo $reviewsFetchError; ?></td></tr>
                    <?php elseif (empty($reviews)): ?>
                         <tr><td colspan="5" class="text-center py-4 text-gray-500">No reviews found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($reviews as $review): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($review['author']); ?></td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-600 max-w-sm truncate"><?php echo htmlspecialchars($review['text']); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                        <i class="fas fa-star <?php echo $i < $review['rating'] ? 'text-orange-400' : 'text-gray-300'; ?>"></i>
                                    <?php endfor; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"><?php echo htmlspecialchars(date('M j, Y', strtotime($review['review_date']))); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="manage_reviews.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                                        <button type="submit" name="delete_review" class="text-red-600 hover:text-red-900" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <!-- Edit functionality can be added here -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
         </div>
    </div>
</div>

<?php include 'partials/footer.php'; ?>
