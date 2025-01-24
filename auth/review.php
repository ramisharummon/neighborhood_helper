<?php
include('../db.php');

// Insert review into database when form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $review_text = $_POST['review_text'];
    $user_id = 1; // Replace this with session-based user ID if needed

    if ($rating > 0 && !empty($review_text)) {
        try {
            $stmt = $conn->prepare("INSERT INTO review (user_id, rating, review_text, created_at) VALUES (:user_id, :rating, :review_text, NOW())");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':review_text', $review_text);
            $stmt->execute();
            echo "<script>alert('Review submitted successfully!');</script>";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Please select a rating and write a review!');</script>";
    }
}

// Retrieve all reviews from the database
try {
    $stmt = $conn->query("SELECT r.rating, r.review_text, u.username FROM review r JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC");
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating and Reviews System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .review-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .review-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .stars {
            display: flex;
            gap: 5px;
            justify-content: center;
            margin-bottom: 15px;
        }
        .stars span {
            font-size: 30px;
            cursor: pointer;
            color: #ccc;
        }
        .stars span.selected {
            color: gold;
        }
        textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: none;
        }
        .submit-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .review-list {
            margin-top: 30px;
        }
        .review {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .review .stars span {
            font-size: 20px;
        }
        .review-meta {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="review-container">
            <h2>Rate and Review</h2>
            <form method="POST" action="review.php">
                <div class="stars" id="rating-stars">
                    <span data-value="1">&#9733;</span>
                    <span data-value="2">&#9733;</span>
                    <span data-value="3">&#9733;</span>
                    <span data-value="4">&#9733;</span>
                    <span data-value="5">&#9733;</span>
                </div>
                <textarea id="review-text" name="review_text" placeholder="Write your review here..."></textarea>
                <input type="hidden" name="rating" id="rating">
                <button class="submit-btn" type="submit">Submit</button>
            </form>

            <div class="review-list" id="review-list">
                <h3>Recent Reviews:</h3>
                <?php if (count($reviews) > 0): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review">
                            <div class="stars">
                                <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                                    <span>&#9733;</span>
                                <?php endfor; ?>
                                <?php for ($i = $review['rating']; $i < 5; $i++): ?>
                                    <span>&#9734;</span>
                                <?php endfor; ?>
                            </div>
                            <div class="review-meta">
                                <strong><?= htmlspecialchars($review['username']) ?></strong>
                            </div>
                            <p><?= htmlspecialchars($review['review_text']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews yet. Be the first to review!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        const stars = document.querySelectorAll('#rating-stars span');
        const ratingInput = document.getElementById('rating');
        let selectedRating = 0;

        stars.forEach(star => {
            star.addEventListener('click', () => {
                selectedRating = star.getAttribute('data-value');
                stars.forEach(s => s.classList.remove('selected'));
                for (let i = 0; i < selectedRating; i++) {
                    stars[i].classList.add('selected');
                }
                ratingInput.value = selectedRating; // Set hidden input for the rating
            });
        });

        // Optional: Clear the selected rating when the review text box is clicked
        const reviewText = document.getElementById('review-text');
        reviewText.addEventListener('focus', () => {
            if (selectedRating === 0) {
                stars.forEach(star => star.classList.remove('selected'));
            }
        });
    </script>
</body>
</html>
