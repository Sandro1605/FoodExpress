<?php
$conn = new mysqli("localhost", "root", "", "foodexpress");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$restaurants = $conn->query("SELECT * FROM restaurants");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FoodExpress - Daftar Restoran</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <header class="navbar">
    <div class="logo">FoodExpress</div>
    <a href="login_form.html" class="login-button">Login</a>
  </header>

  <main class="restaurant-list">
    <h2>Daftar Restoran</h2>
    <div class="cards">
      <?php while ($resto = $restaurants->fetch_assoc()): ?>
      <a href="restoran.php?id=<?= $resto['id'] ?>" class="card">
  <img src="img/resto<?= $resto['id'] ?>.jpg" alt="<?= htmlspecialchars($resto['name']) ?>">
  <h3><?= htmlspecialchars($resto['name']) ?></h3>
  <p><?= htmlspecialchars($resto['location']) ?></p>
</a>

      <?php endwhile; ?>
    </div>
  </main>
</body>
</html>


