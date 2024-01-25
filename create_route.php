<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "KP2023";

// Перевірка з'єднання з базою даних
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Обробка POST-запиту для створення нового маршруту
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['create'])) {
        // Отримання даних з форми
        $route_name = $_POST['route_name'];
        $route_description = $_POST['route_description'];

        // Підготовлений запит для створення нового маршруту
        $stmt = $conn->prepare("INSERT INTO Routes (Name, Description) VALUES (?, ?)");
        $stmt->bind_param("ss", $route_name, $route_description);

        // Виконання запиту
        if ($stmt->execute()) {
            echo "Маршрут успішно створено!";
        } else {
            echo "Помилка при створенні маршруту: " . $conn->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Створення маршруту</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="container_update_point.css">
</head>
<body>
    <header>
        <!-- Ваше меню -->
    </header>
    <main class = "container">
        <div calss = "left_container">

        <a href="index.php" class = "back_button">Назад на головну</a>

        <h2>Створення маршруту</h2>
        <form method="post" action="create_route.php" class = "evac_form">
            <label for="route_name">Назва маршруту:</label>
            <input type="text" name="route_name" id="route_name"><br><br>

            <label for="route_description">Опис маршруту:</label>
            <textarea name="route_description" id="route_description" rows="4" cols="50"></textarea><br><br>

            <input type="submit" name="create" value="Створити маршрут" class ="create_button">
        </form>

        <!-- Кнопка для пересилання на сторінку add_point_to_route.php -->
        <div class = "route_buttons">
        <form method="get" action="add_point_to_route.php">
            <input type="submit" value="Додати точку до маршруту">
        </form>
        <form method="get" action="update_points.php">
            <input type="submit" value="Оновити точку">
        </form>
        </div>
        </div>
        <div class = "right_container">
            <ul class = "right_list"><li>Маршрут евакуації - це планований шлях або напрямок, який люди повинні пройти для виходу з небезпечної зони до безпечного місця під час надзвичайної ситуації. Це може бути заздалегідь визначений шлях у будівлі, території або районі, який спеціально відзначений та підготовлений для евакуації у разі пожежі, стихійного лиха, аварії або іншої небезпеки.</li></ul>
            <p class = "right_p">Маршрут має бути</p>
            <ul class = "right_list">
                <li>З простою назвою: назва маршруту має бути проста і зрозуміла, зазвичай використовуються позначення типу "Альфа", "Бетта" і в такому роді з цифровим позначенням для унікальності назви. </li>
                <li>З описом маршруту: опис маршруту має бути чітким і коротким. У ньому має йтися про стан маршруту відповідно до точок, на яких він побудований, а також наскільки хороша проходимість по даному маршруту.</li>
                <li>Безпечність та ефективність: маршрут має бути безпечним для проходження наскільки це можливо, аби зменшити ризик людських втрат. Також маршрут має бути оптимальний і ефективний, щоб по ньому можна було швидко евакуювати людей.</li>
            </ul>
        </div>
    </main>
    <footer>
        <p>KP2023</p>
    </footer>
</body>
</html>


