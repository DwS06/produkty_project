<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user2.css">
    <title>User 2</title>
</head>
<body>
    <header>
        zalogowano: <?php echo date('d.m.Y H:i:s', (int)time()); ?>
        <a href="user1.php" id="polacz_button"><button>Rozłącz</button></a>
        <?php
         $conn = mysqli_connect('localhost', 'user2', 'user2', 'produkty');
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
                        if (isset($_POST['description'], $_POST['sell_price'], $_POST['cost_price'])) {
                            $description = mysqli_real_escape_string($conn, $_POST['description']);
                            $sell_price = floatval($_POST['sell_price']);
                            $cost_price = floatval($_POST['cost_price']);

                            if (empty($description) || $sell_price < 0 || $cost_price < 0) {
                                echo "<p style='color: red;'>Nieprawidłowe dane. Sprawdź pola.</p>";
                            } else {
                                $sql = "INSERT INTO item (description, sell_price, cost_price) VALUES ('$description', $sell_price, $cost_price)";
                                if (mysqli_query($conn, $sql)) {
                                    header("Location: user2.php");
                                    exit;
                                } else {
                                    echo "<p style='color: red;'>Błąd podczas dodawania: " . mysqli_error($conn) . "</p>";
                                }
                            }
                        }
                        
        ?>
        <?php
                if (isset($_POST['selected_items'])) {
                    $selected = $_POST['selected_items'];
                    $placeholder = implode(', ', array_map('intval', $selected));
                    $sql = "DELETE FROM item WHERE item_id IN ($placeholder)";
                    mysqli_query($conn, $sql);
                    header("Location: user2.php");
                    exit;

                }

                ?>
    </header>

    <main>
        <div id="left">
            <form action="" method="post">
                <label for="cena">Cena:</label>
                <input type="number" name="cenamin" min="0" step="1">
                -
                <input type="number" name="cenamax" min="0" step="1">
                <button type="submit">Szukaj</button>
            </form>
        </div>

        <div id="right">
            <?php
            
           

            if (isset($_POST['cenamin'], $_POST['cenamax']) && $_POST['cenamin'] !== '' && $_POST['cenamax'] !== '') {
                $cenamin = $_POST['cenamin'];
                $cenamax = $_POST['cenamax'];

                if (!is_numeric($cenamin) || !is_numeric($cenamax)) {
                    echo "Nieprawidłowe dane wejściowe.";
                    exit;
                } else {
                    $sql = "SELECT item_id, description, ROUND(sell_price, 0) as sell_price, ROUND(cost_price, 0) as cost_price FROM item WHERE sell_price BETWEEN $cenamin AND $cenamax ORDER BY sell_price";
                    $sql2 = "SELECT count(*) as liczba FROM item WHERE sell_price BETWEEN $cenamin AND $cenamax ORDER BY sell_price";
                    $result = mysqli_query($conn, $sql);
                }
            } else {
                
                $sql = "SELECT item_id, description, ROUND(sell_price, 0) as sell_price, ROUND(cost_price, 0) as cost_price FROM item ORDER BY sell_price";
                $sql2 = "SELECT count(*) as liczba FROM item ORDER BY sell_price";
                $result = mysqli_query($conn, $sql);
            }
            ?>
            
            
                <form action="" method="post">
                <table>
                <tr>
                        <th>Item ID</th>
                        <th>Description</th>
                        <th>Sell Price</th>
                        <th>Cost Price</th>
                        <th>Zaznacz</th>
                      </tr>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['item_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['sell_price']) . " PLN</td>";
                        echo "<td>" . htmlspecialchars($row['cost_price']) . " PLN</td>";
                        echo '<td><input type="checkbox" name="selected_items[]" value="' . htmlspecialchars($row['item_id']) . '"></td>';
                        echo "</tr>";
                    }
                } else {
                echo "Brak produktów do wyświetlenia.";
                }
                
                
                ?>
                </table>
                <?php
                // $sql = "select count(*) as liczba from item"; 
                $result = mysqli_query($conn, $sql2);
                $row = mysqli_fetch_array($result);
                echo "<p>Liczba produktów: $row[liczba]</p>";
                $sql = "select description from item order by item_id desc limit 1"; 
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                echo "<p>Ostatni dodany produkt: $row[description]</p>";
                ?>
                
                <button type="submit" formaction="edit.php">Edytuj</button>
                <button type="submit" onclick="return confirm('Na pewno chcesz usunąć zaznaczone rekordy?');">Usuń</button>
                </form>
                
            
                <div id="add_block">
                    <form action="" method="post" id="add_form">
                        <div class="add_element">
                            <input type="text" name="description" placeholder="Description" class="add_item" required>
                        </div>
                        <div class="add_element">
                            <input type="number" name="sell_price" step="0.01" min="0" placeholder="Sell Price" class="add_item" required>
                        </div>
                        <div class="add_element">
                            <input type="number" name="cost_price" step="0.01" min="0" placeholder="Cost Price" class="add_item" required>
                        </div>
                        <div class="add_element"></div>
                        <button type="submit" class="add_item">Dodaj</button>
                    </form>
                    
                </div>
            
      
        </div>
    </main>
    
</body>
</html>
<?mysqli_close($conn);?>