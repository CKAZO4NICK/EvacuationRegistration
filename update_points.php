<?php
// З'єднання з базою даних залишається незмінним
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "KP2023";

// Перевірка з'єднання з базою даних
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Отримання списку FK_Route і FK_Street з їх назвами
$route_street_query = "SELECT CONCAT(Routes.Name, ' ', Streets.Name) AS RouteStreet, Route_Point.FK_Route, Route_Point.FK_Street 
                        FROM Route_Point 
                        JOIN Routes ON Route_Point.FK_Route = Routes.ID 
                        JOIN Streets ON Route_Point.FK_Street = Streets.ID";
$route_street_result = $conn->query($route_street_query);

// Отримання списку FK_Condition
$condition_query = "SELECT ID, Name FROM Conditions";
$condition_result = $conn->query($condition_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['update'])) {
        $route_street = explode('_', $_POST['route_street']);
        $route = $route_street[0];
        $street = $route_street[1];
        $condition = $_POST['condition'];

        $stmt = $conn->prepare("UPDATE Route_Point SET FK_Condition = ? WHERE FK_Route = ? AND FK_Street = ?");
        $stmt->bind_param("iss", $condition, $route, $street);

        if ($stmt->execute()) {
            echo "Значення FK_Condition успішно оновлено";
        } else {
            echo "Помилка при оновленні значення: " . $conn->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Оновлення статусу точок</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="container_update_point.css">

</head>
<body>
    <header>
        <!-- Ваше меню -->
    </header>
    <main class = "container">
        <div class = "left_container">
        <div class = "header_buttons">
    <a href="index.php" class = "back_button">Назад на головну</a>
        <a href="create_route.php" class = "back_button">Назад до створення маршруту</a>
</div>
        <form method="post" action="update_points.php" class = "evac_form">
            <label for="route_street">Точка маршруту:</label>
            <select name="route_street" id="route_street" class ="create_button">
            <?php
            while($row = $route_street_result->fetch_assoc()) {
                echo "<option value='" . $row['FK_Route'] . "_" . $row['FK_Street'] . "'>" . $row['RouteStreet'] . "</option>";
            }
            ?>
        </select><br><br>

<label for="condition">Статус:</label>
<select name="condition" id="condition" class ="create_button">
            <?php
            while($row = $condition_result->fetch_assoc()) {
                echo "<option value='" . $row['ID'] . "'>" . $row['Name'] . "</option>";
            }
            ?>
        </select><br><br>

<input type="submit" name="update" value="Оновити" class = "create_button">
</form>
        </div>
        <div class = "right_container">
       <p class = "right_p"> Оновлення статусу точки евакуації або будь-якої іншої зони від безпечної (зеленої) до небезпечної (червоної) чи частково небезпечної (жовтої) може відбуватися з різних причин, і це зазвичай пов'язано з зміною умов чи потенційних загроз у цій області.</p>
           <p class = "right_p"> Причини зміни статусу точки </p> 
           <ul class = right_list>
            <li>Зміна характеристик навколишнього середовища: Якщо сталася природна катастрофа (наприклад, землетрус, повінь, пожежа тощо) або техногенна аварія, це може змінити стан безпеки окремих зон. Наприклад, підвищений ризик обвалу будівлі після землетрусу може зробити точку евакуації небезпечною.</li>
            <li>Загроза терористичних дій: Інформація про можливий терористичний акт або загрозу безпеці може призвести до перекласифікації точок евакуації як небезпечних.</li>
            <li>Технічні або структурні проблеми: Наприклад, проблеми з безпекою будівельної конструкції, електропостачання, систем вентиляції, водопостачання чи інших систем можуть змінити статус безпеки точки.</li>
            <li>Оновлення інформації: Після оцінки ситуації або нової інформації владні структури можуть оновити свої рекомендації стосовно статусу точки евакуації.</li>
        </ul>
    </div>
</main>
<footer>
<p>KP2023</p>
</footer>
</body>
</html>