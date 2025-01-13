<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Options</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        /* Navbar Styling */
        .navbar {
            background-color: #7297cf;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            width: 100%;
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

        .navbar .menu-icon {
            font-size: 24px;
            color: white;
            cursor: pointer;
        }

        .navbar .menu-icon:hover {
            color: #d9d9d9;
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
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 50px;
            text-align: center;
        }

        .box {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 250px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .box a {
            text-decoration: none;
            color: white;
            display: block;
            background-color:#7297cf;
            padding: 10px;
            border-radius: 4px;
        }

        .box a:hover {
            background-color: #7297cf;;
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
        <a href="logout.php">Logout</a>
        <div class="search-bar">
            <form method="GET" action="search.php">
                <input type="text" name="query" placeholder="Search here...">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container">
        <div class="box">
            <h2>Request Help</h2>
            <p>If you need assistance, click below to request help.</p>
            <a href="request_help.php">Request Help</a>
        </div>
        <div class="box">
            <h2>Offer Help</h2>
            <p>Join our community of helpers by offering assistance.</p>
            <a href="offer_help.php">Offer Help</a>
        </div>
        <div class="box">
            <h2>Available Help</h2>
            <p>Explore the help available in your area.</p>
            <a href="available_help.php">Available Help</a>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <a href="index.php">Return to Home</a>
    </div>
</body>
</html>
