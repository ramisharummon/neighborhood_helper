<?php
// Database connection
include('../db.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle review form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reviewed_user_id = $_POST['reviewed_user_id']; 
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Assume the reviewer’s user ID is from the session or a predefined value
    $reviewer_id = 1; // Hardcoded for now, you can replace it with session variable or authentication logic

    // Prepare SQL to insert review
    $sql = "INSERT INTO review (ReviewerID, ReviewedUserID, Rating, Comment) 
            VALUES ('$reviewer_id', '$reviewed_user_id', '$rating', '$comment')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>Review submitted successfully!</p>";
    } else {
        echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Fetch all reviews to display
$sql = "SELECT * FROM review";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit and View Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"], input[type="number"], textarea {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        input[type="submit"] {
            padding: 10px 15px;
            font-size: 16px;
            background-color:#66a2d8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #66a2d8;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #66a2d8;
            color: white;
        }

        .success {
            color: green;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }

        .review-table-container {
            margin-top: 20px;
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Rating</h1>
        
        <form action="" method="POST">
            <label for="reviewed_user_id">Reviewed User ID:</label>
            <input type="text" name="reviewed_user_id" required><br>
            
            <label for="rating">Rating (1-5):</label>
            <input type="number" name="rating" min="1" max="5" required><br>
            
            <label for="comment">Comment:</label><br>
            <textarea name="comment" rows="5" required></textarea><br>
            
            <input type="submit" value="Submit Review">
        </form>

        <div class="review-table-container">
            <h2>All Reviews</h2>
            <table>
                <thead>
                    <tr>
                        <th>Reviewer ID</th>
                        <th>Reviewed User ID</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if reviews exist
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['ReviewerID'] . "</td>";
                            echo "<td>" . $row['ReviewedUserID'] . "</td>";
                            echo "<td>" . $row['Rating'] . "</td>";
                            echo "<td>" . $row['Comment'] . "</td>";
                            echo "<td>" . $row['Timestamp'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No reviews found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
