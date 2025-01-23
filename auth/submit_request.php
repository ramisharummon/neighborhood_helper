<?php
include('../db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in.");
}

// Retrieve UserID from the session
$UserID = $_SESSION['user_id'];

// Retrieve form data
$title = $_POST['title'];
$description = $_POST['description'];
$type = $_POST['type'];
$urgency = $_POST['urgency'];
$date = $_POST['date'];
$time = $_POST['time'];
$location = $_POST['location'];
$status = 'Pending'; // Default status for a new request
$requestDate = date('Y-m-d H:i:s'); // Current date and time

try {
    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO helprequest (UserID, Title, Description, Category, UrgencyLevel, Location, RequestDate, TimeFrame, Status) 
                            VALUES (:UserID, :title, :description, :type, :urgency, :location, :requestDate, :time, :status)");

    // Bind parameters
    $stmt->bindParam(':UserID', $UserID);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':urgency', $urgency);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':requestDate', $requestDate);
    $stmt->bindParam(':time', $time);
    $stmt->bindParam(':status', $status);

    // Execute the query
    $stmt->execute();

    echo "Request successfully submitted!";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
