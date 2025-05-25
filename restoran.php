<?php
$conn = new mysqli("localhost", "root", "", "foodexpress");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data restoran
$stmt = $conn->prepare("SELECT * FROM restaurants WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$restaurant = $stmt->get_result()->fetch_assoc();

if (!$restaurant) {
  echo "Restoran tidak ditemukan."; exit;
}

// Ambil daftar menu
$menus = $conn->query("SELECT * FROM menu_items WHERE restaurant_id = $id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($restaurant['name']) ?> - FoodExpress</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1><?= htmlspecialchars($restaurant['name']) ?></h1>
    <div class="info">
      <p><strong>📍 Lokasi:</strong> <?= htmlspecialchars($restaurant['location']) ?></p>
      <p><strong>🕒 Jam Operasional:</strong> <?= $restaurant['open_time'] ?> - <?= $restaurant['close_time'] ?></p>
    </div>

    <h2>Menu dan Harga</h2>
    <div class="menu">
      <?php while ($row = $menus->fetch_assoc()): ?>
      <div class="menu-item">
        <div>
          <strong><?= htmlspecialchars($row['name']) ?></strong><br>
          Rp <?= number_format($row['price'], 0, ',', '.') ?>
        </div>
        <div class="menu-actions">
          <button class="add-btn" onclick="addToCart('<?= addslashes($row['name']) ?>', <?= $row['price'] ?>)">Add</button>
        </div>
      </div>
      <?php endwhile; ?>
    </div>

    <h2>🛒 Keranjang</h2>
    <ul id="cartList" class="cart-list"></ul>
    <p><strong>Total:</strong> Rp <span id="cartTotal">0</span></p>
    <button id="checkoutBtn" onclick="checkout()">Pesan Sekarang</button>
  </div>

  <div id="alertBox" class="alert">Harap Login sebagai Customer untuk memesan.</div>
  <script src="restaurant.js"></script>
</body>
</html>
