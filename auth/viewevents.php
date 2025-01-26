<?php

 include('../db.php');


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user is logged in (this is just an example)
    $userID = 1; // This should be dynamic based on logged-in user, e.g. from session

    // Fetch events with user who posted the event
    $searchQuery = '';
    $events = [];

    if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
        $searchQuery = trim($_GET['search']);
        $stmt = $pdo->prepare("SELECT e.*, u.Name as PostedByName 
                               FROM event e
                               LEFT JOIN user u ON e.PostedBy = u.UserID
                               WHERE e.Title LIKE :search 
                                  OR e.Description LIKE :search 
                                  OR e.Location LIKE :search
                               ORDER BY e.EventDate ASC");
        $stmt->execute([':search' => '%' . $searchQuery . '%']);
    } else {
        $stmt = $pdo->query("SELECT e.*, u.Name as PostedByName 
                             FROM event e
                             LEFT JOIN user u ON e.PostedBy = u.UserID
                             ORDER BY e.EventDate ASC");
    }

    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle 'Interested' button click
    if (isset($_POST['interested_event'])) {
        $eventID = $_POST['interested_event'];

        // Update the RSVP count for the selected event
        $stmt = $pdo->prepare("UPDATE event SET RSVPCount = RSVPCount + 1 WHERE EventID = :eventID");
        $stmt->execute([':eventID' => $eventID]);
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
    <title>Upcoming Events - Neighborhood Helper</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #7297cf;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            width: 100%;
            position: fixed; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo {
            color: white;
            font-size: 1.5em;
            font-weight: bold;
            margin-right: auto;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .navbar a:hover {
            background-color: #5a78a4; /* Slightly darker blue on hover */
        }

        .navbar .search-bar {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .navbar input[type="text"] {
            padding: 5px;
            border: none;
            border-radius: 5px;
            outline: none;
        }

        .navbar button {
            background-color: white;
            color: #5D3A9B;
            border: none;
            padding: 6px 12px;
            margin-left: 5px;
            border-radius: 5px;
            cursor: pointer;
        }

        .navbar button:hover {
            background-color: #E3E3E3;
        }

        /* Page Content Styling */
        .container {
            padding: 20px;
            max-width: 1200px;
            width: 100%;
            text-align: center;
            margin: 80px auto 20px;
        }

        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .event-box {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .event-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .event-box h2 {
            font-size: 1.2em;
            margin-bottom: 10px;
            color: #333;
        }

        .event-box p {
            margin: 5px 0;
            color: #666;
        }

        .event-box .btn {
            text-decoration: none;
            color: white;
            background-color: #7297cf;
            padding: 10px 15px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 10px;
        }

        .event-box .btn:hover {
            background-color: #5a78a4;
        }

        .footer {
            margin-top: auto;
            padding: 20px;
            text-align: center;
        }

        .footer a {
            text-decoration: none;
            color: #007BFF;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Neighborhood Helper</div>
        <a href="home.php">Home</a>
        <a href="help_portal.php">View Help</a>
        <a href="group.php">Group</a>
        <a href="createevents.php">Event</a>
        <a href="review.php">Review</a>
        <a href="logout.php">Logout</a>
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search events..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <!-- Page Header -->
    <div class="container">
        <h1 class="text-3xl font-bold mb-6">Upcoming Community Events</h1>
        
        <!-- Event Grid -->
        <div class="event-grid">
            <?php if (empty($events)): ?>
                <p>No events found.</p>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <div class="event-box">
                        <h2><?php echo htmlspecialchars($event['Title']); ?></h2>
                        <p><strong>Date:</strong> <?php echo date('F d, Y h:i A', strtotime($event['EventDate'])); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($event['Location']); ?></p>
                        <p><strong>Posted By:</strong> <?php echo htmlspecialchars($event['PostedByName']); ?></p>
                        <p><?php echo htmlspecialchars(substr($event['Description'], 0, 100) . '...'); ?></p>
                        <p><strong>RSVP Count:</strong> <?php echo intval($event['RSVPCount']); ?></p>
                        <form method="POST" action="">
                        <a href="view_more.php?event_id=<?php echo $event['EventID']; ?>" class="btn">Interested</a>
                       

                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>