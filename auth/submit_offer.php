<?php
//session_start();
include('../db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "Error: You must be logged in to submit an offer.";
        exit;
    }

    // Get and sanitize form inputs
    $userID = $_SESSION['user_id']; // Assuming the session contains the logged-in user's ID
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $category = htmlspecialchars(trim($_POST['category'])); // Updated to match the 'Category' column
    $price = isset($_POST['price']) ? floatval($_POST['price']) : 0.0;
    $availability = htmlspecialchars(trim($_POST['availability']));
 
    $status = htmlspecialchars(trim($_POST['status']));

    // Input validation
    if (empty($title) || empty($description) || empty($category) || empty($availability) || empty($status)) {
        echo "Error: All fields are required.";
        exit;
    }

    if (!in_array($status, ['Active', 'Inactive'])) {
        echo "Error: Invalid status value.";
        exit;
    }

    try {
        // Prepare and execute the SQL query
        $stmt = $conn->prepare("INSERT INTO helpoffer (UserID, Title, Description, Category, Price, Availability, Status, OfferDate) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$userID, $title, $description, $category, $price, $availability,  $status]);

        echo "Offer successfully submitted!";
        // Optionally redirect to another page
        // header("Location: success_page.php");
    } catch (PDOException $e) {
        echo "Error: Unable to submit your offer. Please try again later.";
        // Log the error for debugging
        error_log("Database error: " . $e->getMessage());
    }
} else {
    echo "Invalid request method.";
}
?>
