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

?>

<!DOCTYPE html>
<html>
<head>
  <title>Перегляд існуючих евакуацій</title>
  <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
  <header>
    <!-- Ваше меню -->
  </header>
  <main>
  <a href="index.php" class = "back_button">Назад на головну</a>
    <h2>Перегляд існуючих евакуацій</h2>
    <!-- Код для відображення інформації про евакуації -->
    <table>
      <tr>
        <th>Маршрут</th>
        <th>Група людей</th>
        <th>Дата початку</th>
        <th>Розрахункова дата завершення</th>
        <th>Фактична дата завершення</th>
        <!-- Інші необхідні колонки -->
      </tr>

      <?php
      $sql = "SELECT Routes.Name AS RouteName, Evacuation.FK_People_Group, Evacuation.Start_Date, Evacuation.Estimated_End_Date, Evacuation.Actual_End_Date 
              FROM Evacuation 
              JOIN Routes ON Evacuation.FK_Route = Routes.ID";

      $result = $conn->query($sql); // Виконання запиту до бази даних

      if ($result->num_rows > 0) {
        // Виведення даних у вигляді таблиці
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["RouteName"] . "</td>";
          echo "<td>" . $row["FK_People_Group"] . "</td>";
          echo "<td>" . $row["Start_Date"] . "</td>";
          echo "<td>" . $row["Estimated_End_Date"] . "</td>";
          echo "<td>" . $row["Actual_End_Date"] . "</td>";
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
