<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "KP2023";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Запит для отримання списку маршрутів
$sql_routes = "SELECT ID, Name FROM Routes";
$result_routes = $conn->query($sql_routes);

// Запит для отримання списку груп людей
$sql_groups = "SELECT ID FROM People_Groups";
$result_groups = $conn->query($sql_groups);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_evacuation'])) {
    $route = $_POST['route'];
    $group = $_POST['group'];
    $start_date = $_POST['start_date'];
    $estimated_end_date = $_POST['estimated_end_date'];
    $actual_end_date = $_POST['actual_end_date'] ? $_POST['actual_end_date'] : null;

    // Запит для вставки даних з урахуванням NULL для actual_end_date
    $sql_insert = "INSERT INTO Evacuation (FK_Route, FK_People_Group, Start_Date, Estimated_End_Date, Actual_End_Date)
    VALUES ('$route', '$group', '$start_date', '$estimated_end_date', ";

    if ($actual_end_date) {
        $sql_insert .= "'$actual_end_date')";
    } else {
        $sql_insert .= "NULL)";
    }

    if ($conn->query($sql_insert) === TRUE) {
        echo "Евакуацію успішно зареєстровано";
    } else {
        echo "Помилка при реєстрації евакуації: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Реєстрація евакуації</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="container.css">
</head>
<body>
    <header>
        <!-- Ваше меню -->
    </header>
    <main class = "container">
        <div class = "left_container">
    <a href="index.php" class = "back_button">Назад на головну</a>
        <h2>Реєстрація евакуації</h2>
        <form action="" method="POST" class = "evac_form">
            <label for="route">Маршрут:</label>
            <select id="route" name="route" class ="create_button">
                <?php
                if ($result_routes->num_rows > 0) {
                    while ($row = $result_routes->fetch_assoc()) {
                        echo "<option value='" . $row["ID"] . "'>" . $row["Name"] . "</option>";
                    }
                } else {
                    echo "<option value=''>Немає доступних маршрутів</option>";
                }
                ?>
            </select>
            <br><br>
            <label for="group">Група людей:</label>
            <select id="group" name="group" class ="create_button">
                <?php
                if ($result_groups->num_rows > 0) {
                    while ($row = $result_groups->fetch_assoc()) {
                        echo "<option value='" . $row["ID"] . "'>" . $row["ID"] . "</option>";
                    }
                } else {
                    echo "<option value=''>Немає доступних груп людей</option>";
                }
                ?>
            </select>
            <br><br>
            <label for="start_date">Дата початку:</label>
            <input type="date" id="start_date" name="start_date" required class ="create_button">
            <br><br>
            <label for="estimated_end_date">Прогнозована дата завершення:</label>
            <input type="date" id="estimated_end_date" name="estimated_end_date" required class ="create_button">
            <br><br>
            <label for="actual_end_date">Фактична дата завершення:</label>
            <input type="date" id="actual_end_date" name="actual_end_date" class ="create_button">
            <br><br>
            <input type="submit" name="register_evacuation" value="Зареєструвати евакуацію" class = "create_button" >
        </form>
            </div>
            <div class = "right_container">
                <ul class = "right_list">
                    <li>Евакуація - це процес виходу людей або населення з небезпечних або загрозливих обставин, таких як пожежа, стихійні лиха, військові конфлікти, техногенні аварії або інші надзвичайні ситуації. Це може статися з будь-яких причин, коли проживання чи перебування в певному місці стає небезпечним для життя чи здоров'я людей. </li>
                </ul>
                <p class = "">Етапи Евакуації</p>
                <ul class = "right_list">
                    <li>Оголошення тривоги: Це може бути спеціальне повідомлення, сигнал від владних органів або виявлення загрози, яке спонукає до евакуації. </li>
                    <li>Підготовка до евакуації: Люди повинні вжити необхідні заходи для підготовки до виходу, включаючи збирання особистих речей, документів, медичних препаратів тощо. </li>
                    <li>Вихід з небезпечної зони: Люди виходять з місця небезпечної ситуації за встановленими маршрутами евакуації та вказівками від владних структур.</li>
                    <li>Перевірка та збір на пункті збору: Після евакуації люди збираються на визначеному пункті збору для перевірки наявності всіх осіб та подальших інструкцій. </li>
                    <li>Допомога та підтримка після евакуації: Після евакуації може знадобитися медична або психологічна допомога для людей, які були у стресовій ситуації. </li>
                </ul>
            </div>
    </main>
    <footer>
        <p>KP2023</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
