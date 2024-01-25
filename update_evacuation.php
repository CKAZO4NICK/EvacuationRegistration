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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $evacuation_id = $_POST["evacuation_id"];
    $actual_end_date = $_POST["actual_end_date"];

    // Перевірка на введення коректної дати
    $current_date = date('Y-m-d H:i:s');
    if ($actual_end_date > $current_date) {
        echo "Фактичний час закінчення не може бути більший за поточний час!";
    } else {
        $sql = "UPDATE Evacuation 
                SET Actual_End_Date = '$actual_end_date' 
                WHERE ID = '$evacuation_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Фактичний час закінчення евакуації успішно оновлено!";
            header("Location: update_evacuation.php");
            exit();
        } else {
            echo "Помилка оновлення фактичного часу закінчення: " . $conn->error;
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Оновлення фактичного часу закінчення евакуації</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <link rel="stylesheet" type="text/css" href="container_update_point.css">
</head>
<body>
  <header>
    <!-- Ваше меню -->
  </header>
  <main class = "container">
    <div class = "left_container">
  <a href="index.php" class = "back_button">Назад на головну</a>
    <h2>Оновлення фактичного часу закінчення евакуації</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class = "evac_form">
      <label for="evacuation_id">ID евакуації:</label>
      <select id="evacuation_id" name="evacuation_id" class ="create_button">
        <?php
        $sql = "SELECT ID, Start_Date, FK_Route FROM Evacuation";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["ID"] . "'>" . $row["FK_Route"] . " - " . $row["Start_Date"] . "</option>";
            }
        } else {
            echo "<option value=''>Немає доступних евакуацій</option>";
        }
        ?>
      </select>
      <br><br>
      <label for="actual_end_date">Новий фактичний час закінчення евакуації:</label>
      <input type="datetime-local" id="actual_end_date" name="actual_end_date" required class ="create_button">
      <br><br>
      <input type="submit" value="Оновити фактичний час закінчення" class = "create_button">
    </form>
      </div>
      <div class = "right_container">
        <ul class = "right_list"><li>Фактичний час закінчення евакуації - це час, коли евакуація рахується повністю закінченою і її цілі рахуються повністю виконаними. Навідміну від розрахункового часу евакуації, де кажеться приблизний час кінця евакуації, фактичний час виставляється коли подадуть команду про кінець операції.</li></ul>
        <p class = "right_p">Є деякі фактори, що впливають на час евакуації:</p>
        <ul class = "right_container">
          <li>Кількість людей: Більше людей - більше часу, який потрібно для того, щоб усі вони вийшли безпечно.</li>
          <li>Наявність інфраструктури для евакуації: Чи є чіткі маршрути евакуації, достатньо виходів, чи легко знаходити шлях виходу.</li>
          <li>Тип небезпеки чи надзвичайної ситуації: Деякі надзвичайні ситуації можуть потребувати швидкого виходу, тоді як інші можуть допускати більше часу для організації евакуації.</li>
          <li>Об'єм катастрофи: Від того, наскільки великі були масштаби катастрофи, що привела до запуску операції евакуації, залежить і час самої евакуації, адже люди можуть боятися, ховатися, або бути не в змозі покинути деякі місця і їм потрібна окрема допомога.</li>
        </ul>
      </div>
  </main>
  <footer>
  <p>KP2023</p>
  </footer>
</body>
</html>
