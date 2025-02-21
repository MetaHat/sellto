<?php
require_once '../config/_config.php'; // Include database connection
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Your domain URL - Replace with your actual domain
$base_url = "https://taken.2pl.store/"; 

// Get report ID from request
$report_id = isset($_GET['report_id']) ? intval($_GET['report_id']) : 0;

if ($report_id <= 0) {
    die("Invalid Report ID.");
}

// Fetch images for the given report
$query = "SELECT photo_1, photo_2, photo_3 FROM client_visits WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $report_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if records exist
if ($result->num_rows == 0) {
    die("No images found for this report.");
}

// Fetch data
$images = $result->fetch_assoc();

// Function to get correct image path
// Function to get correct image path
function getImagePath($image)
{
    global $base_url;
    
    if (!empty($image)) {
        // Ensure "uploads/" is not added twice
        $cleanedImage = preg_replace("~^uploads/~", "", $image); // Remove "uploads/" if already present
        return $base_url . "uploads/" . $cleanedImage;
    }
    return null;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Report Images</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        .gallery {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .gallery img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .back-link {
            margin-top: 20px;
            display: block;
            text-decoration: none;
            color: white;
            background: #007BFF;
            padding: 10px 15px;
            border-radius: 5px;
            width: 120px;
            text-align: center;
            margin: 20px auto;
        }
        .back-link:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Report Images</h2>
    <div class="gallery">
    <?php 
    $imageFound = false;
    foreach (['photo_1', 'photo_2', 'photo_3'] as $photo) {
        $imagePath = getImagePath($images[$photo]);

        if ($imagePath) { 
            $imageFound = true; ?>
            <a href="<?php echo $imagePath; ?>" target="_blank">
                <img src="<?php echo $imagePath; ?>" alt="Report Image">
            </a>
        <?php }
    }
    if (!$imageFound) {
        echo "<p>No Images Available</p>";
    }
    ?>
    </div>

    <a href="view_reports.php" class="back-link">Back to Reports</a>

</body>
</html>
