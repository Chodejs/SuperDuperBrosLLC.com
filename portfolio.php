<?php
$pageTitle = "Portfolio - Audin's Construction Co.";
$metaDescription = "View our portfolio of completed drywall, painting, and flooring projects. See the quality craftsmanship of Audin's Construction Co.";
include 'header.php';

// Placeholder for portfolio items. In a real application, this would come from a database.
$portfolioItems = [
    [
        'title' => 'Modern Kitchen Remodel - Drywall & Painting',
        'category' => 'Drywall, Painting',
        'image_url' => 'https://placehold.co/600x400/E8A87C/4A4A4A?text=Kitchen+Project',
        'thumb_url' => 'https://placehold.co/400x300/E8A87C/4A4A4A?text=Kitchen',
        'description' => 'Complete drywall installation for a newly remodeled kitchen, followed by a two-tone professional paint job.'
    ],
    [
        'title' => 'Hardwood Flooring Installation - Living Area',
        'category' => 'Flooring',
        'image_url' => 'https://placehold.co/600x400/C38D9E/4A4A4A?text=Living+Room+Flooring',
        'thumb_url' => 'https://placehold.co/400x300/C38D9E/4A4A4A?text=Flooring',
        'description' => 'Installation of beautiful oak hardwood flooring throughout a spacious living and dining area.'
    ],
    [
        'title' => 'Exterior House Painting - Full Repaint',
        'category' => 'Painting',
        'image_url' => 'https://placehold.co/600x400/41B3A3/FFFFFF?text=Exterior+Paint+Job',
        'thumb_url' => 'https://placehold.co/400x300/41B3A3/FFFFFF?text=Exterior',
        'description' => 'Full exterior repaint including siding, trim, and doors, giving this home a fresh, modern look.'
    ],
    [
        'title' => 'Commercial Office Space - Drywall & Finishing',
        'category' => 'Drywall',
        'image_url' => 'https://placehold.co/600x400/A2DED0/4A4A4A?text=Office+Drywall',
        'thumb_url' => 'https://placehold.co/400x300/A2DED0/4A4A4A?text=Office',
        'description' => 'Drywall partitioning and finishing for a new commercial office layout.'
    ],
    [
        'title' => 'Basement Renovation - LVP Flooring',
        'category' => 'Flooring',
        'image_url' => 'https://placehold.co/600x400/F5A623/4A4A4A?text=Basement+Flooring',
        'thumb_url' => 'https://placehold.co/400x300/F5A623/4A4A4A?text=Basement',
        'description' => 'Luxury Vinyl Plank (LVP) flooring installed in a renovated basement, providing a durable and waterproof solution.'
    ],
    [
        'title' => 'Accent Wall & Interior Painting',
        'category' => 'Painting',
        'image_url' => 'https://placehold.co/600x400/D0E1F9/4A4A4A?text=Accent+Wall',
        'thumb_url' => 'https://placehold.co/400x300/D0E1F9/4A4A4A?text=Accent',
        'description' => 'Creating a stunning accent wall with bold color and precision painting in a master bedroom.'
    ]
];

// Get unique categories for filtering
$categories = array_unique(array_column($portfolioItems, 'category'));
sort($categories); // Optional: sort categories alphabetically

// Handle filtering
$filterCategory = $_GET['category'] ?? 'all';
$filteredItems = $portfolioItems;
if ($filterCategory !== 'all') {
    $filteredItems = array_filter($portfolioItems, function($item) use ($filterCategory) {
        // Check if the category string contains the filter category (for items with multiple categories like "Drywall, Painting")
        return strpos($item['category'], $filterCategory) !== false;
    });
}

?>
<style>
    /* Basic lightbox styles */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 10000;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.9);
    }
    .lightbox-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 800px;
        max-height: 80vh;
    }
    .lightbox-caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 800px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
    }
    .lightbox-close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }
    .lightbox-close:hover,
    .lightbox-close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }
    .portfolio-item img { cursor: pointer; }
</style>

<div class="bg-background-light">
    <section class="page-header py-16 bg-primary-black text-text-white text-center">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold animate-on-scroll"><?php echo htmlspecialchars($pageTitle); ?></h1>
            <p class="text-lg md:text-xl mt-4 text-gray-300 animate-on-scroll" data-delay="200">A Showcase of Our Quality Workmanship.</p>
        </div>
    </section>

    <section class="content-section py-12 md:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-wrap justify-center gap-2 mb-12 animate-on-scroll">
                <a href="portfolio.php?category=all" class="filter-btn <?php echo ($filterCategory === 'all') ? 'bg-accent-orange text-primary-black' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?> py-2 px-4 rounded-md font-semibold transition-colors">All Projects</a>
                <?php 
                // Create a flat list of all categories mentioned, split by comma, trim, unique, and filter empty
                $allIndividualCategories = [];
                foreach ($portfolioItems as $item) {
                    $cats = explode(',', $item['category']);
                    foreach ($cats as $cat) {
                        $trimmedCat = trim($cat);
                        if (!empty($trimmedCat)) {
                            $allIndividualCategories[] = $trimmedCat;
                        }
                    }
                }
                $uniqueIndividualCategories = array_unique($allIndividualCategories);
                sort($uniqueIndividualCategories);

                foreach ($uniqueIndividualCategories as $cat): ?>
                    <a href="portfolio.php?category=<?php echo urlencode($cat); ?>" class="filter-btn <?php echo ($filterCategory === $cat) ? 'bg-accent-orange text-primary-black' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?> py-2 px-4 rounded-md font-semibold transition-colors">
                        <?php echo htmlspecialchars($cat); ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if (empty($filteredItems)): ?>
                <p class="text-center text-gray-600 text-xl">No projects found for the selected category. Please try another filter.</p>
            <?php else: ?>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($filteredItems as $index => $item): ?>
                    <div class="portfolio-item bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 group animate-on-scroll" data-delay="<?php echo $index * 100; ?>">
                        <div class="relative">
                            <img src="<?php echo htmlspecialchars($item['thumb_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                 class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105"
                                 onclick="openLightbox('<?php echo htmlspecialchars($item['image_url']); ?>', '<?php echo htmlspecialchars(addslashes($item['title'])); ?>')">
                            <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-10 transition-opacity duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <i class="fas fa-search-plus fa-3x text-white"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-primary-black mb-2"><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p class="text-sm text-accent-orange font-medium mb-3"><?php echo htmlspecialchars($item['category']); ?></p>
                            <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($item['description']); ?></p>
                            </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <div id="myLightbox" class="lightbox">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <img class="lightbox-content" id="lightboxImg" src="#" alt="Lightbox image">
        <div id="lightboxCaption" class="lightbox-caption"></div>
    </div>


    <section class="content-section py-16 bg-primary-black text-text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold mb-6 animate-on-scroll">Inspired by Our Work?</h2>
            <p class="text-lg mb-8 max-w-xl mx-auto text-gray-300 animate-on-scroll" data-delay="200">
                Let Audin's Construction Co. bring this level of quality and dedication to your next project.
            </p>
            <a href="contact.php" class="btn bg-accent-orange hover:bg-orange-600 text-primary-black text-lg font-bold py-3 px-10 rounded-lg shadow-lg transition-transform transform hover:scale-105 animate-on-scroll" data-delay="400">
                Get Your Free Quote
            </a>
        </div>
    </section>
</div>

<script>
    // Lightbox functionality
    function openLightbox(imageUrl, captionText) {
        document.getElementById('lightboxImg').src = imageUrl;
        document.getElementById('lightboxCaption').innerHTML = captionText;
        document.getElementById('myLightbox').style.display = "block";
        document.body.style.overflow = 'hidden'; // Prevent scrolling background
    }

    function closeLightbox() {
        document.getElementById('myLightbox').style.display = "none";
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    // Close lightbox if user clicks outside the image
    document.getElementById('myLightbox').addEventListener('click', function(event) {<?php
$pageTitle = "Portfolio - Super Brothers LLC | Nashville Construction Projects";
$metaDescription = "View our portfolio of completed commercial and residential drywall, painting, and flooring projects by Super Brothers LLC in Nashville and surrounding areas. See our quality craftsmanship.";
include 'header.php';

// Placeholder for portfolio items. In a real application, this would come from a database.
// User will update these with actual project details and image src links later.
$portfolioItems = [
    [
        'title' => 'Modern Kitchen Remodel - Drywall & Painting',
        'category' => 'Drywall, Painting, Residential', // Added Residential
        'image_url' => 'https://placehold.co/600x400/E8A87C/4A4A4A?text=Kitchen+Project',
        'thumb_url' => 'https://placehold.co/400x300/E8A87C/4A4A4A?text=Kitchen',
        'description' => 'Complete drywall installation for a newly remodeled kitchen, followed by a two-tone professional paint job, showcasing precision and a clean finish.'
    ],
    [
        'title' => 'Hardwood Flooring Installation - Living Area',
        'category' => 'Flooring, Residential', // Added Residential
        'image_url' => 'https://placehold.co/600x400/C38D9E/4A4A4A?text=Living+Room+Flooring',
        'thumb_url' => 'https://placehold.co/400x300/C38D9E/4A4A4A?text=Flooring',
        'description' => 'Installation of beautiful oak hardwood flooring throughout a spacious living and dining area, enhancing the home\'s warmth and value.'
    ],
    [
        'title' => 'Exterior House Painting - Full Repaint',
        'category' => 'Painting, Residential', // Added Residential
        'image_url' => 'https://placehold.co/600x400/41B3A3/FFFFFF?text=Exterior+Paint+Job',
        'thumb_url' => 'https://placehold.co/400x300/41B3A3/FFFFFF?text=Exterior',
        'description' => 'Full exterior repaint including siding, trim, and doors, giving this home a fresh, modern look and durable protection.'
    ],
    [
        'title' => 'Commercial Office Space - Drywall & Finishing',
        'category' => 'Drywall, Commercial', // Added Commercial
        'image_url' => 'https://placehold.co/600x400/A2DED0/4A4A4A?text=Office+Drywall',
        'thumb_url' => 'https://placehold.co/400x300/A2DED0/4A4A4A?text=Office',
        'description' => 'Drywall partitioning and finishing for a new commercial office layout, completed on time and to exact specifications.'
    ],
    [
        'title' => 'Basement Renovation - LVP Flooring',
        'category' => 'Flooring, Residential', // Added Residential
        'image_url' => 'https://placehold.co/600x400/F5A623/4A4A4A?text=Basement+Flooring',
        'thumb_url' => 'https://placehold.co/400x300/F5A623/4A4A4A?text=Basement',
        'description' => 'Luxury Vinyl Plank (LVP) flooring installed in a renovated basement, providing a stylish, durable, and waterproof solution.'
    ],
    [
        'title' => 'Accent Wall & Interior Painting - Master Suite',
        'category' => 'Painting, Residential', // Added Residential
        'image_url' => 'https://placehold.co/600x400/D0E1F9/4A4A4A?text=Accent+Wall',
        'thumb_url' => 'https://placehold.co/400x300/D0E1F9/4A4A4A?text=Accent',
        'description' => 'Creating a stunning accent wall with bold color and precision painting in a master bedroom, adding character and depth.'
    ]
];

// Get unique categories for filtering
$allIndividualCategories = [];
foreach ($portfolioItems as $item) {
    $cats = explode(',', $item['category']);
    foreach ($cats as $cat) {
        $trimmedCat = trim($cat);
        if (!empty($trimmedCat) && !in_array($trimmedCat, $allIndividualCategories)) {
            $allIndividualCategories[] = $trimmedCat;
        }
    }
}
sort($allIndividualCategories); // Sort categories alphabetically

// Handle filtering
$filterCategory = $_GET['category'] ?? 'all';
$filteredItems = $portfolioItems;
if ($filterCategory !== 'all') {
    $filteredItems = array_filter($portfolioItems, function($item) use ($filterCategory) {
        return strpos($item['category'], $filterCategory) !== false;
    });
}

?>
<style>
    /* Basic lightbox styles - these should remain functional */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 10000; /* Ensure it's on top */
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.9);
    }
    .lightbox-content {
        margin: auto;
        display: block;
        width: 90%; /* More responsive for various image sizes */
        max-width: 800px;
        max-height: 85vh; /* Ensure space for caption and close button */
        object-fit: contain; /* Ensures entire image is visible */
    }
    .lightbox-caption {
        margin: 10px auto; /* Adjusted margin */
        display: block;
        width: 80%;
        max-width: 800px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        font-size: 0.9rem; /* Slightly smaller caption */
    }
    .lightbox-close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }
    .lightbox-close:hover,
    .lightbox-close:focus {
        color: #bbb;
        text-decoration: none;
    }
    .portfolio-item img { cursor: pointer; }
</style>

<div class="bg-background-light">
    <section class="page-header py-16 bg-primary-black text-text-white text-center">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold animate-on-scroll"><?php echo htmlspecialchars($pageTitle); ?></h1>
            <p class="text-lg md:text-xl mt-4 text-gray-300 animate-on-scroll" data-delay="200">A Showcase of Our Quality Workmanship & Dedication.</p>
        </div>
    </section>

    <section class="content-section py-12 md:py-20">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-wrap justify-center gap-2 mb-12 animate-on-scroll">
                <a href="portfolio.php?category=all" class="filter-btn <?php echo ($filterCategory === 'all') ? 'bg-accent-orange text-primary-black' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?> py-2 px-4 rounded-md font-semibold transition-colors">All Projects</a>
                <?php foreach ($allIndividualCategories as $cat): ?>
                    <a href="portfolio.php?category=<?php echo urlencode($cat); ?>" class="filter-btn <?php echo ($filterCategory === $cat) ? 'bg-accent-orange text-primary-black' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?> py-2 px-4 rounded-md font-semibold transition-colors">
                        <?php echo htmlspecialchars($cat); ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <?php if (empty($filteredItems)): ?>
                <p class="text-center text-gray-600 text-xl py-10">No projects found for the selected category. Please try another filter or check back soon for new additions!</p>
            <?php else: ?>
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($filteredItems as $index => $item): ?>
                    <div class="portfolio-item bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 group animate-on-scroll" data-delay="<?php echo $index * 100; ?>">
                        <div class="relative">
                            <img src="<?php echo htmlspecialchars($item['thumb_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?> - by Super Brothers LLC" 
                                 class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105"
                                 onclick="openLightbox('<?php echo htmlspecialchars($item['image_url']); ?>', '<?php echo htmlspecialchars(addslashes($item['title'])); ?>')">
                            <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-10 transition-opacity duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <i class="fas fa-search-plus fa-3x text-white"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-primary-black mb-2"><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p class="text-sm text-accent-orange font-medium mb-3"><?php echo htmlspecialchars($item['category']); ?></p>
                            <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($item['description']); ?></p>
                            </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <div id="myLightbox" class="lightbox" onclick="closeLightboxOutside(event)">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <img class="lightbox-content" id="lightboxImg" src="#" alt="Enlarged portfolio image by Super Brothers LLC">
        <div id="lightboxCaption" class="lightbox-caption"></div>
    </div>


    <section class="content-section py-16 bg-primary-black text-text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold mb-6 animate-on-scroll">Inspired by Our Work?</h2>
            <p class="text-lg mb-8 max-w-xl mx-auto text-gray-300 animate-on-scroll" data-delay="200">
                Let Super Brothers LLC bring this level of quality and dedication to your next commercial or residential project in the Nashville area.
            </p>
            <a href="contact.php" class="btn bg-accent-orange hover:bg-orange-600 text-primary-black text-lg font-bold py-3 px-10 rounded-lg shadow-lg transition-transform transform hover:scale-105 animate-on-scroll" data-delay="400">
                Get Your Free Estimate
            </a>
        </div>
    </section>
</div>

<script>
    // Lightbox functionality
    const lightbox = document.getElementById('myLightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxCaption = document.getElementById('lightboxCaption');

    function openLightbox(imageUrl, captionText) {
        if (!lightbox || !lightboxImg || !lightboxCaption) return; // Safety check
        lightboxImg.src = imageUrl;
        lightboxCaption.innerHTML = captionText;
        lightbox.style.display = "block";
        document.body.style.overflow = 'hidden'; // Prevent scrolling background
    }

    function closeLightbox() {
        if (!lightbox) return; // Safety check
        lightbox.style.display = "none";
        document.body.style.overflow = 'auto'; // Restore scrolling
    }

    // Close lightbox if user clicks outside the image (on the backdrop)
    function closeLightboxOutside(event) {
        if (event.target === lightbox) {
            closeLightbox();
        }
    }

    // Close lightbox with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape" && lightbox && lightbox.style.display === "block") {
            closeLightbox();
        }
    });
</script>

<?php include 'footer.php'; ?>

        if (event.target === this) { // Check if the click is on the backdrop itself
            closeLightbox();
        }
    });
     // Close lightbox with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape" && document.getElementById('myLightbox').style.display === "block") {
            closeLightbox();
        }
    });
</script>

<?php include 'footer.php'; ?>
