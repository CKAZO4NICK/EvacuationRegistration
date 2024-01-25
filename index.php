<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "KP2023";

// Створення з'єднання
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка з'єднання
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Система евакуації</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link rel="stylesheet" type="text/css" href="container.css">
  <link rel="stylesheet" type="text/css" href="bg.css">
</head>
<body>
  <header>
    <h1>Автоматизована система для збереження даних щодо маршруів для евакуації груп людей з небезпечних територій</h1>
    <nav>
      <ul>
        <li><a href="registration.php" >Реєстрація евакуації</a></li>
        <li><a href="create_route.php" >Створення маршруту</a></li>
        <li><a href="view_routes.php" >Перегляд існуючих маршрутів</a></li>
        <li><a href="view_points.php" >Перегляд існуючих точок</a></li>
        <li><a href="view_evacuations.php" >Перегляд існуючих евакуацій</a></li>
        <li><a href="update_evacuation.php" >Оновлення фактичного часу закінчення евакуацій</a></li>
        <li><a href="view_group.php" >Перегляд груп людей</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <div  class = "background_image">
</div>
  </main>
  <footer>
  <p>KP2023</p>
  </footer>
</body>
</html>
