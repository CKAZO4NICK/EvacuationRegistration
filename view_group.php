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
  <title>Перегляд груп людей</title>
  <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
  <header>
    <!-- Ваше меню -->
  </header>
  <main>
  <a href="index.php" class = "back_button">Назад на головну</a>
    <h2>Перегляд груп людей</h2>
    <!-- Код для відображення інформації про групи людей -->
    <table>
      <tr>
        <th>ID</th>
        <th>Опис</th>
        <th>Кількість людей</th>
        <!-- Інші необхідні колонки -->
      </tr>

      <?php
      $sql = "SELECT * FROM People_Groups";

      $result = $conn->query($sql); // Виконання запиту до бази даних

      if ($result->num_rows > 0) {
        // Виведення даних у вигляді таблиці
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["Id"] . "</td>";
          echo "<td>" . $row["General_Description"] . "</td>";
          echo "<td>" . $row["Number_of_People"] . "</td>";
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
