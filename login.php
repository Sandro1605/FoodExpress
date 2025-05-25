<?php
session_start();
$conn = new mysqli("localhost", "root", "", "foodexpress");

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Simpan role ke sessionStorage via JS
    echo "<script>
            sessionStorage.setItem('userRole', '{$user['role']}');
            alert('Login berhasil sebagai {$user['role']}');
            window.location.href = 'index.html';
          </script>";
  } else {
    echo "<script>alert('Username atau password salah!'); window.history.back();</script>";
  }
}
?>
