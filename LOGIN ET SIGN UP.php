<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Uber Taxi</title>
  <style>
    :root {
      --main-color: #000;
      --accent-color: #f6f6f6;
      --button-bg: #fff;
      --button-text: #000;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: var(--accent-color);
      color: var(--main-color);
    }

    header {
      background: var(--main-color);
      color: white;
      padding: 1rem 2rem;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .logo {
      font-size: 1.5rem;
      font-weight: bold;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin: 0 1rem;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #aaa;
    }

    .auth-buttons button {
      margin-left: 1rem;
      padding: 0.5em 1em;
      border-radius: 25px;
      border: none;
      cursor: pointer;
      background: var(--button-bg);
      color: var(--button-text);
      transition: background 0.3s;
    }

    .auth-buttons button:hover {
      background: #ddd;
    }

    .hero {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      padding: 2rem;
      background: var(--accent-color);
    }

    .hero .text {
      flex: 1 1 300px;
      padding: 1rem;
    }

    .hero h1 {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }

    .hero form input,
    .hero form button {
      display: block;
      width: 100%;
      padding: 0.8rem;
      margin: 0.5rem 0;
      border-radius: 10px;
      border: 1px solid #ccc;
    }

    .hero form button {
      background-color: var(--main-color);
      color: white;
      border: none;
      cursor: pointer;
      transition: background 0.3s;
    }

    .hero-image img {
      max-width: 100%;
      height: auto;
    }

    .how-to-ride {
      padding: 2rem;
      background: #fff;
    }

    .steps {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      gap: 1rem;
    }

    .step {
      flex: 1 1 250px;
      background: #fafafa;
      border-radius: 10px;
      padding: 1rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .recent-rides, .admin-panel {
      padding: 2rem;
      background: #fdfdfd;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 0.75rem;
      border: 1px solid #ddd;
      text-align: center;
    }

    th {
      background-color: #f0f0f0;
    }

    footer {
      text-align: center;
      padding: 1rem;
      background: var(--main-color);
      color: white;
    }
  </style>
</head>
<body>
  <header>
    <div class="navbar">
      <div class="logo">Uber</div>
      <nav>
        <a href="#">Ride</a>
        <a href="#">Drive</a>
        <a href="#">Business</a>
        <a href="#">Uber Eats</a>
        <a href="#">About</a>
      </nav>
      <div class="auth-buttons">
        <?php if (!isset($_SESSION['user'])): ?>
          <button onclick="location.href='login.php'">Log in</button>
          <button onclick="location.href='signup.php'">Sign up</button>
        <?php else: ?>
          <button onclick="location.href='logout.php'">Logout</button>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <section class="hero">
    <div class="text">
      <h1>Your local taxis → now on Uber</h1>
      <p>Convenient rides in local taxis.</p>
      <form action="prices.php" method="post">
        <input type="text" name="location" placeholder="Enter location" required />
        <input type="text" name="destination" placeholder="Enter destination" required />
        <button type="submit">See prices</button>
      </form>
    </div>
    <div class="hero-image">
      <img src="taxi-illustration.png" alt="Taxi Illustration" />
    </div>
  </section>

  <section class="how-to-ride">
    <h2>How to ride with Uber Taxi</h2>
    <div class="steps">
      <div class="step">
        <h3>1. Request</h3>
        <p>Enter your destination. Confirm pickup and select Uber Taxi.</p>
      </div>
      <div class="step">
        <h3>2. Ride</h3>
        <p>Get in and enjoy your ride. Share trip or split fare via the app.</p>
      </div>
      <div class="step">
        <h3>3. Hop out</h3>
        <p>You’ll be charged automatically. Rate your driver after the ride.</p>
      </div>
    </div>
  </section>

  <?php
  $conn = new mysqli("localhost", "root", "", "uber_taxi");
  if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
  $result = $conn->query("SELECT id, location, destination, created_at FROM rides ORDER BY created_at DESC LIMIT 5");
  ?>

  <section class="recent-rides">
    <h2>Recent Rides</h2>
    <?php if ($result->num_rows > 0): ?>
      <table>
        <tr><th>Location</th><th>Destination</th><th>Date</th></tr>
        <?php while($r = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($r['location']) ?></td>
            <td><?= htmlspecialchars($r['destination']) ?></td>
            <td><?= date('Y-m-d H:i', strtotime($r['created_at'])) ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>No rides found.</p>
    <?php endif; ?>
  </section>

  <?php if (isset($_SESSION['user']) && $_SESSION['user'] === 'admin'): ?>
  <section class="admin-panel">
    <h2>Admin Panel – Manage Rides</h2>
    <?php
    $all = $conn->query("SELECT id, location, destination, created_at FROM rides ORDER BY created_at DESC");
    ?>
    <table>
      <tr><th>ID</th><th>Location</th><th>Destination</th><th>Date</th><th>Action</th></tr>
      <?php while($r = $all->fetch_assoc()): ?>
        <tr>
          <td><?= $r['id'] ?></td>
          <td><?= htmlspecialchars($r['location']) ?></td>
          <td><?= htmlspecialchars($r['destination']) ?></td>
          <td><?= $r['created_at'] ?></td>
          <td><a href="delete_ride.php?id=<?= $r['id'] ?>" onclick="return confirm('Delete this ride?');">Delete</a></td>
        </tr>
      <?php endwhile; ?>
    </table>
  </section>
  <?php endif; ?>

  <?php $conn->close(); ?>

  <footer>
    <p>&copy; 2025 Uber Technologies Inc.</p>
  </footer>
</body>
</html>
