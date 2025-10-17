<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user1.css">
    <title>User 1</title>
</head>
<body>
    <header>
        <a href="user2.php" id="polacz_button"><button>Połącz</button></a>
    </header>

    <main>
        <div id="left">
            <form action="" method="post">
                <label for="cena">Cena:</label>
                <input type="number" name="cenamin">
                -
                <input type="number" name="cenamax">
                <button type="submit">Szukaj</button>
            </form>
        </div>

        <div id="right">
            <?php
            $conn = mysqli_connect('localhost', 'user1', 'user1', 'produkty');
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            if (isset($_POST['cenamin'], $_POST['cenamax']) && $_POST['cenamin'] !== '' && $_POST['cenamax'] !== '') {
                $cenamin = $_POST['cenamin'];
                $cenamax = $_POST['cenamax'];

                if (!is_numeric($cenamin) || !is_numeric($cenamax)) {
                    echo "Nieprawidłowe dane wejściowe.";
                    exit;
                } else {
                    $cenamin = (float)$cenamin;
                    $cenamax = (float)$cenamax;
                    $sql = "SELECT item_id, description, ROUND(sell_price, 0) as sell_price FROM item WHERE sell_price BETWEEN ? AND ? ORDER BY sell_price";
                    $stmt = mysqli_prepare($conn, $sql);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "dd", $cenamin, $cenamax);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        mysqli_stmt_close($stmt);
                    } else {
                        echo "Błąd przygotowania zapytania.";
                        exit;
                    }
                }
            } else {
                $sql = "SELECT item_id, description, ROUND(sell_price, 0) as sell_price FROM item ORDER BY sell_price";
                $result = mysqli_query($conn, $sql);
            }

            if ($result && mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Item ID</th><th>Description</th><th>Sell Price</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['item_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['sell_price']) . " PLN</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Brak produktów do wyświetlenia.";
            }

            mysqli_close($conn);
            ?>
        </div>
    </main>
    
</body>
</html>