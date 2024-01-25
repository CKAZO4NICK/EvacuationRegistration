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
  <title>Перегляд маршрутів</title>
  <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
  <header>
    <!-- Ваше меню -->
  </header>
  <main>
  <a href="index.php" class = "back_button">Назад на головну</a>
    <h2>Перегляд маршрутів</h2>
    <!-- Код для відображення інформації про маршрути -->
    <table>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <!-- Інші необхідні колонки -->
      </tr>

      <?php
      $sql = "SELECT Name, Description FROM Routes";

      $result = $conn->query($sql); // Виконання запиту до бази даних

      if ($result->num_rows > 0) {
        // Виведення даних у вигляді таблиці
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["Name"] . "</td>";
          echo "<td>" . $row["Description"] . "</td>";
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
