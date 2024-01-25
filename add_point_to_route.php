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

// Отримання списку маршрутів
$route_query = "SELECT ID, Name FROM Routes";
$route_result = $conn->query($route_query);

// Отримання списку вулиць
$street_query = "SELECT ID, Name FROM Streets";
$street_result = $conn->query($street_query);

// Отримання списку умов
$condition_query = "SELECT ID, Name FROM Conditions";
$condition_result = $conn->query($condition_query);

// Обробка POST-запиту для додавання точки до маршруту
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['add_point'])) {
        // Отримання даних з форми
        $route_id = $_POST['route_id'];
        $street_id = $_POST['street_id'];
        $condition_id = $_POST['condition_id'];

        // Підготовлений запит для додавання точки до маршруту
        $stmt = $conn->prepare("INSERT INTO Route_Point (FK_Route, FK_Street, FK_Condition) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $route_id, $street_id, $condition_id);

        // Виконання запиту
        if ($stmt->execute()) {
            echo "Точку успішно додано до маршруту!";
        } else {
            echo "Помилка при додаванні точки до маршруту: " . $conn->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Додавання точки до маршруту</title>
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
        <a href="create_route.php" class = "back_button">Назад до створення маршруту</a>
        <h2>Додавання точки до маршруту</h2>
        <form method="post" action="add_point_to_route.php" class = "evac_form">
            <!-- Випадаючі списки для вибору ID -->
            <label for="route_id">Маршрут:</label>
            <select name="route_id" id="route_id" class ="create_button">
                <?php
                while($row = $route_result->fetch_assoc()) {
                    echo "<option value='" . $row['ID'] . "'>" . $row['Name'] . "</option>";
                }
                ?>
            </select><br><br>

            <label for="street_id">Вулиця:</label>
            <select name="street_id" id="street_id" class ="create_button">
                <?php
                while($row = $street_result->fetch_assoc()) {
                    echo "<option value='" . $row['ID'] . "'>" . $row['Name'] . "</option>";
                }
                ?>
            </select><br><br>

            <label for="condition_id">Стан:</label>
            <select name="condition_id" id="condition_id" class ="create_button">
                <?php
                while($row = $condition_result->fetch_assoc()) {
                    echo "<option value='" . $row['ID'] . "'>" . $row['Name'] . "</option>";
                }
                ?>
            </select><br><br>

            <input type="submit" name="add_point" value="Додати точку до маршруту" class = "create_button">
        </form>
            </div>
            <div class = "right_container">
            <p class = "right_p">  Деякі рекомендації щодо вибору точок на маршруті:</p>    
                 <ul class = "right_list">
                <li>Доступність: Обирайте маршрути евакуації, які легко доступні для всіх працівників або мешканців будівлі. Вони повинні бути зручними для швидкого доступу в разі надзвичайної ситуації.</li>
                <li>Безпека маршрутів: Переконайтеся, що маршрути не блокуються перешкодами або завалами, і їхній стан перевіряється регулярно. Забезпечення чистоти маршрутів відповідно до всіх вимог безпеки є ключовим.</li>
                <li>Особливі потреби: Враховуйте особливі потреби людей з обмеженими можливостями або з іншими специфічними потребами під час планування маршрутів евакуації.</li>
                <li>Актуальність: перевіряйте актуальність стану точки, щоб точно вказати статус її небезпечності</li>
                </ul>

                <img src = "evac.jpg" width ="700" height = "350"> 
                </div>
    </main>
    <footer>
        <p>KP2023</p>
    </footer>
</body>
</html>
