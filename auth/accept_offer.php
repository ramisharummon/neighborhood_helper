<?php
include('../db.php');

if (isset($_POST['accept_offer'])) {
    // Check if 'UserID' is present in the POST request
    if (!isset($_SESSION['user_id'])) {
        echo "UserID is missing.";
        exit;
    }

    // Get the UserID from the POST request
    $UserID = $_SESSION['user_id'];

    try {
        // Fetch the offer details along with the user's email
        $stmt = $conn->prepare("
            SELECT helpoffer.Title, helpoffer.UserID, user.Email 
            FROM helpoffer
            INNER JOIN user ON helpoffer.UserID = user.UserID
            WHERE helpoffer.UserID = :UserID AND helpoffer.Status = 'Active'
        ");
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        $stmt->execute();
        $offer = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($offer) {
            // Update the offer status to 'Accepted'
            $updateStmt = $conn->prepare("UPDATE helpoffer SET Status = 'Accepted' WHERE UserID = :UserID AND Status = 'Active'");
            $updateStmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $updateStmt->execute();

            // Prepare and send the email notification
            $user_email = $offer['Email'];
            $subject = "Your Help Offer Has Been Accepted!";
            $message = "Hello,\n\nYour help offer titled '{$offer['Title']}' has been accepted. Thank you for your generosity.\n\nBest regards,\nNeighborhood Helper Team";
            $headers = "From: no-reply@neighborhoodhelper.com";

            // Send the email
            if (mail($user_email, $subject, $message, $headers)) {
                echo "The help offer has been accepted, and the user has been notified.";
            } else {
                echo "Failed to send the email notification.";
            }
        } else {
            echo "No active offer found for the specified UserID.";
        }

        // Redirect to the available help page
        header("Location: request_offer.php");
        exit;

    } catch (PDOException $e) {
        echo "Error: Unable to accept the offer.".$e->getMessage();
        error_log("Database error: " . $e->getMessage());
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
?>
