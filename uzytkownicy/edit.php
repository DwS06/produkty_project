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
            $itemid = $_POST['selected_items'];
            if(sizeof($itemid)==1)
            {
                $placeholder = implode(', ', array_map('intval', $itemid));
                $sql = "select description, sell_price, cost_price FROM item WHERE item_id IN ($placeholder)";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                echo "<form method='POST' action=''>";
                echo "<input type='text' class='form_edit' name='description' value='$row[description]'></input>";
                echo "<input type='number' class='form_edit' name='sell_price' value='$row[sell_price]'></input>";
                echo "<input type='number' class='form_edit' name='cost_price' value='$row[cost_price]'></input>";
                echo "<button type='submit' class='form_edit' >Edytuj</button>";
                echo "</form>";
                if (isset($_POST['description'], $_POST['sell_price'], $_POST['cost_price'])) {
                    $desc = $_POST['description'];
                    $sell = $_POST['sell_price'];
                    $cost = $_POST['cost_price'];
                    $sql = "UPDATE item SET description = '$desc', sell_price = $sell, cost_price = $cost WHERE item_id = $placeholder";
                    mysqli_query($conn, $sql);
                }
                header("Location: ".$_SERVER['PHP_SELF']);
                exit;
            }else{
                echo '<form method="post" action="user2.php">';
                echo '<p>Zaznacz tylko jeden rekord do edycji</p>';
                echo '<button type="submit">Okej</button>';
                echo '</form>';
            exit;
            }
            
        ?>

    </main>
</body>
</html>