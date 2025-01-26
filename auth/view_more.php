<?php
include('../db.php');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the event details based on the EventID passed in the URL
    if (isset($_GET['event_id']) && is_numeric($_GET['event_id'])) {
        $eventID = $_GET['event_id'];
        $stmt = $pdo->prepare("SELECT e.*, u.Name as PostedByName 
                               FROM event e
                               LEFT JOIN user u ON e.PostedBy = u.UserID
                               WHERE e.EventID = :eventID");
        $stmt->execute([':eventID' => $eventID]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        die("Event not found.");
    }
} catch (PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - Neighborhood Helper</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        .event-details-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
            padding: 30px;
            margin-bottom: 20px;  /* Space between the card and the RSVP section */
            text-align: center;
        }

        .event-details-container h1 {
            font-size: 2em;
            color: #333;
            margin-bottom: 15px;
        }

        .event-details-container p {
            font-size: 1.1em;
            margin: 10px 0;
            color: #555;
        }

        .event-details-container .date,
        .event-details-container .location,
        .event-details-container .posted-by {
            color: #7297cf;
            font-weight: bold;
        }

        .event-details-container .description {
            margin-top: 20px;
            font-size: 1.1em;
            color: #333;
            line-height: 1.6;
        }

        .event-details-container .btn-back {
            display: inline-block;
            margin-top: 30px;
            background-color: #5a78a4;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .event-details-container .btn-back:hover {
            background-color: #7297cf;
        }

        .rsvp-container {
            text-align: center;
            width: 100%;
            padding: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .rsvp-container p {
            font-size: 1.2em;
            color: #333;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            color: #999;
        }

        .footer a {
            color: #007BFF;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="event-details-container">
        <?php if ($event): ?>
            <h1><?php echo htmlspecialchars($event['Title']); ?></h1>
            <p class="date">Date: <?php echo date('F d, Y h:i A', strtotime($event['EventDate'])); ?></p>
            <p class="location">Location: <?php echo htmlspecialchars($event['Location']); ?></p>
            <p class="posted-by">Posted By: <?php echo htmlspecialchars($event['PostedByName']); ?></p>

            <div class="description">
                <strong>Description:</strong>
                <p><?php echo nl2br(htmlspecialchars($event['Description'])); ?></p>
            </div>

            <div class="rsvp-container">
        <?php if ($event): ?>
            <p>RSVP Count: <?php echo intval($event['RSVPCount']); ?></p>
        <?php endif; ?>
    </div>

            <a href="viewevents.php" class="btn-back">Back to Events</a>
        <?php else: ?>
            <p>Event not found.</p>
        <?php endif; ?>
    </div>

    <!-- RSVP Section below the card -->
  

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 Neighborhood Helper. All rights reserved.</p>
    </div>

</body>
</html>
