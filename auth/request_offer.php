<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Sent</title>
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 500px;
            width: 90%;
        }

        .container h1 {
            color: #4CAF50;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 1.2em;
            margin-bottom: 30px;
            color: #555;
        }

        .container a {
            text-decoration: none;
            padding: 12px 20px;
            font-size: 1em;
            border-radius: 8px;
            margin: 5px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .container .home-link {
            background-color: #6C83C2;
            color: #fff;
        }

        .container .home-link:hover {
            background-color: #4a62a4;
        }

        .container .view-offers-link {
            background-color: #4CAF50;
            color: #fff;
        }

        .container .view-offers-link:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Request Sent!</h1>
        <p>Your request has been successfully sent to the help offerer. They will contact you soon.</p>
        <a href="home.php" class="home-link">Go to Home</a>
        <a href="available_help.php" class="view-offers-link">View Other Offers</a>
    </div>
</body>
</html>
