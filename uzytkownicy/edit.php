<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit.css">
    <title>Edytowanie rekordów</title>
</head>
<body>
    <main>
        <?php
            $conn = mysqli_connect('localhost', 'user2', 'user2', 'produkty');
            if (!$conn) {
                die("Błąd połączenia: " . mysqli_connect_error());
            }

          
            if (isset($_POST['description'], $_POST['sell_price'], $_POST['cost_price'], $_POST['item_id'])) {

                $id = intval($_POST['item_id']);
                $desc = mysqli_real_escape_string($conn, $_POST['description']);
                $sell = floatval($_POST['sell_price']);
                $cost = floatval($_POST['cost_price']);

                $sql = "UPDATE item SET description = '$desc', sell_price = $sell, cost_price = $cost WHERE item_id = $id";
                mysqli_query($conn, $sql);

                header("Location: user2.php");
                exit;
            }

            if (isset($_POST['selected_items'])) {
                if(sizeof($_POST['selected_items']) == 1)
                {
                    $id = intval($_POST['selected_items'][0]);
                    $result = mysqli_query($conn, "SELECT * FROM item WHERE item_id = $id");
                    $row = mysqli_fetch_assoc($result);

                    echo "<form method='POST' action=''>";
                    echo "<input type='hidden' name='item_id' value='$id'>";
                    echo "<input type='text' name='description' min='0' step='0.01' class='form_edit' value='" . htmlspecialchars($row['description']) . "'>";
                    echo "<input type='number' name='sell_price' min='0' step='0.01' class='form_edit' value='" . htmlspecialchars($row['sell_price']) . "'>";
                    echo "<input type='number' name='cost_price' min='0' step='0.01' class='form_edit' value='" . htmlspecialchars($row['cost_price']) . "'>";
                    echo "<button type='submit' class='form_edit'>Zapisz</button>";
                    echo "</form>";
                }else{
                    echo "Zaznacz tylko jeden produkt.";
                    echo '<a href="user2.php"><button>Okej</button></a>';
                    exit;

                }
            }else{
                echo "Nie zaznaczono produktu.";
                echo '<a href="user2.php"><button>Okej</button></a>';
                exit;
            }
        
                echo '<a href="user2.php"><button>Anuluj</button></a>';
                    
        ?>

    </main>
</body>
</html>
