<?php
$pageTitle = "Reviews & Testimonials - Super Brothers LLC";
$metaDescription = "Read what our satisfied clients in Nashville have to say about Super Brothers LLC. Real testimonials for our drywall, painting, and flooring services.";
include 'header.php';
require 'db_connect.php'; // We need the database connection

// Fetch visible reviews from the database
$reviews = [];
try {
    // Select only reviews marked as 'is_visible = 1'
    $result = $db->query("SELECT author, review_date, rating, text, project, source FROM reviews WHERE is_visible = 1 ORDER BY review_date DESC");
    if ($result) {
        $reviews = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
    }
} catch (Exception $e) {
    // Log the error and gracefully handle the case where reviews can't be fetched
    error_log("Reviews page DB error: " . $e->getMessage());
    // $reviews will remain an empty array, and the page will show a message.
}

?>

<div class="bg-gray-100">
    <section class="page-header py-16 bg-primary-black text-text-white text-center">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold animate-on-scroll"><?php echo htmlspecialchars($pageTitle); ?></h1>
            <p class="text-lg md:text-xl mt-4 text-gray-300 animate-on-scroll" data-delay="200">Hear From Our Satisfied Clients Across Nashville.</p>
        </div>
    </section>

    <section class="content-section py-12 md:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold text-primary-black text-center mb-12 animate-on-scroll">Client Experiences</h2>
            
            <?php if (empty($reviews)): ?>
                <div class="text-center bg-white p-8 rounded-lg shadow-md">
                    <p class="text-xl text-gray-600">We are currently gathering testimonials from our recent projects. Please check back soon to see what our clients are saying!</p>
                </div>
            <?php else: ?>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($reviews as $index => $review): ?>
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col animate-on-scroll" data-delay="<?php echo $index * 100; ?>">
                        <div class="mb-4">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <i class="fas fa-star <?php echo $i < $review['rating'] ? 'text-accent-orange' : 'text-gray-300'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <p class="text-gray-700 italic mb-4 flex-grow">"<?php echo htmlspecialchars($review['text']); ?>"</p>
                        <div class="mt-auto border-t pt-4">
                            <p class="font-semibold text-primary-black"><?php echo htmlspecialchars($review['author']); ?></p>
                            <?php if (!empty($review['project'])): ?>
                                <p class="text-sm text-gray-500">Project: <?php echo htmlspecialchars($review['project']); ?></p>
                            <?php endif; ?>
                            <p class="text-xs text-gray-400">Date: <?php echo date('F j, Y', strtotime($review['review_date'])); ?> | Source: <?php echo htmlspecialchars($review['source']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="mt-16 pt-10 border-t border-gray-300 text-center animate-on-scroll">
                <h3 class="text-2xl font-semibold text-primary-black mb-6">Find More Reviews on Google</h3>
                <p class="text-gray-700 mb-6 max-w-2xl mx-auto">
                    We value transparency and feedback! Check out more reviews or leave your own on our Google Business Profile to help others in our community.
                </p>
                <a href="https://www.google.com/search?q=Super+Brothers+LLC+Nashville+TN" target="_blank" rel="noopener noreferrer" class="inline-block bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                    <p class="text-lg font-medium text-gray-800">Super Brothers LLC on Google</p>
                    <div class="my-2">
                        <span class="text-yellow-500 text-2xl">★★★★★</span>
                    </div>
                    <span class="btn bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md inline-flex items-center">
                        <i class="fab fa-google mr-2"></i> View Google Reviews
                    </span>
                </a>
            </div>
        </div>
    </section>

    <section class="content-section py-16 bg-accent-orange text-primary-black">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold mb-6 animate-on-scroll">Had a Great Experience?</h2>
            <p class="text-lg mb-8 max-w-xl mx-auto animate-on-scroll" data-delay="200">
                We'd love to hear about your project with Super Brothers LLC. Your feedback helps us grow and helps others make informed decisions.
            </p>
            <a href="contact.php?subject=ReviewSubmission" class="btn bg-primary-black hover:bg-gray-800 text-text-white text-lg font-bold py-3 px-10 rounded-lg shadow-lg transition-transform transform hover:scale-105 animate-on-scroll" data-delay="400">
                Contact Us to Leave a Review
            </a>
        </div>
    </section>

</div>

<?php include 'footer.php'; ?>
