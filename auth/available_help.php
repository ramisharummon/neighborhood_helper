<?php
include('../db.php'); // Include your database connection

try {
    // Fetch active help offers from the database
    $stmt = $conn->prepare("SELECT * FROM helpoffer WHERE Status = 'Active'");
    $stmt->execute();
    $offers = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch results as associative array
} catch (PDOException $e) {
    echo "Error: Unable to fetch available help.";
    error_log("Database error: " . $e->getMessage());
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Help</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #005f6b;
            padding: 20px 0;
            font-size: 2rem;
        }

        .offer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .offer-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .offer-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .offer-card h2 {
            font-size: 1.5rem;
            color: #00796b;
            margin-bottom: 10px;
        }

        .offer-card p {
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .price {
            font-weight: bold;
            font-size: 1.2rem;
            color: #e91e63;
        }

        .accept-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            margin-top: 10px;
        }

        .accept-btn:hover {
            background-color: #45a049;
        }

        .no-offers {
            text-align: center;
            font-size: 1.2rem;
            color: #ff5722;
        }

        @media screen and (max-width: 768px) {
            .offer-card {
                width: 100%;
                max-width: 350px;
            }
        }
    </style>
</head>
<body>
    <h1>Available Help Offers</h1>

    <div class="offer-container">
        <?php if (empty($offers)): ?>
            <p class="no-offers">No help offers are currently available. Please check back later.</p>
        <?php else: ?>
            <?php foreach ($offers as $offer): ?>
                <div class="offer-card">
                    <h2><?php echo htmlspecialchars($offer['Title']); ?></h2>
                    <p><strong>Category:</strong> <?php echo htmlspecialchars($offer['Category']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($offer['Description']); ?></p>
                    <p><strong>Availability:</strong> <?php echo htmlspecialchars($offer['Availability']); ?></p>
                    <p class="price"><strong>Price:</strong> $<?php echo number_format($offer['Price'], 2); ?></p>
                    
                    <!-- Accept Help Button -->
                    <form method="POST" action="accept_offer.php">
                        <!-- Hidden input to pass the offer_id to accept_offer.php -->
                        <input type="hidden" name="offer_id" value="<?php echo htmlspecialchars($offer['ID']); ?>">
                        <button type="submit" name="accept_offer" class="accept-btn">Accept Help</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
