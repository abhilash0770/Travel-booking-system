<?php include 'header.php'; ?>

<style>
    body {
        background-image: url('data:image/jpeg;base64,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'); /* Make sure the image exists in this path */
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .overlay {
        background-color: rgba(0, 0, 0, 0.6); /* dark overlay */
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .welcome-container {
        text-align: center;
        color: #fff;
        padding: 40px;
        border-radius: 15px;
    }

    .welcome-container h1 {
        font-size: 3em;
        margin-bottom: 20px;
    }

    .welcome-container p {
        font-size: 1.2em;
        margin-bottom: 30px;
    }

    .welcome-container button {
        padding: 12px 24px;
        font-size: 1em;
        border: none;
        border-radius: 25px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .welcome-container button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
</style>

<div class="overlay">
    <div class="welcome-container">
        <h1>Welcome to Travel Booking System</h1>
        <p>Explore amazing travel packages and book your next adventure!</p>
        <a href="packages.php"><button>View Packages</button></a>
    </div>
</div>

<?php include 'footer.php'; ?>
