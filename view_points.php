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
  <title>Перегляд існуючих точок</title>
  <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
  <header>
    <!-- Ваше меню -->
  </header>
  <main>
  <a href="index.php" class = "back_button">Назад на головну</a>
    <h2>Перегляд існуючих точок</h2>
    <!-- Код для відображення інформації про точки -->
    <table class ="scroll-table">
      <tr>
        <th>Маршрут</th>
        <th>Вулиця</th>
        <th>Умови</th>
        <!-- Інші необхідні колонки -->
      </tr>

      <?php
      $sql = "SELECT Route_Point.ID, Routes.Name AS RouteName, Streets.Name AS StreetName, Conditions.Name AS ConditionName 
              FROM Route_Point 
              JOIN Routes ON Route_Point.FK_Route = Routes.ID 
              JOIN Streets ON Route_Point.FK_Street = Streets.ID 
              JOIN Conditions ON Route_Point.FK_Condition = Conditions.ID"; 

      $result = $conn->query($sql); // Виконання запиту до бази даних

      if ($result->num_rows > 0) {
        // Виведення даних у вигляді таблиці
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["RouteName"] . "</td>";
          echo "<td>" . $row["StreetName"] . "</td>";
          echo "<td>" . $row["ConditionName"] . "</td>";
          // Виведення інших необхідних полів
          echo "</tr>";
        }
      } else {
        echo "0 results";
      }
      $conn->close(); // Закриття з'єднання
      ?>

    </table>
  </main>
  <footer>
  <p>KP2023</p>
  </footer>
</body>
</html>
