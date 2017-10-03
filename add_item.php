<?php
    session_start();    // start the session
    require '../engine/functions.php';
    $data = data();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Budżet Rodzinny</title>
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower|Lato&amp;subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script|Josefin+Sans:400,400i|Princess+Sofia" rel="stylesheet">
    <link type="text/css" href="/style/main_style.css" rel="stylesheet" />
    <link type="text/css" href="/style/add_item.css" rel="stylesheet" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
</head>

<body>
<div id="container">
   <h2>Dodaj pozycję do budżetu:</h2>
    
    <?php
        function changeDateFormat($old_date) {
            if ($old_date) {
                list($yyyy, $mm, $dd) = explode('-', $old_date);
                return $mm . "/" . $dd . "/" . $yyyy;
            } else {
                return "09/05/1978";
            }
        }
    
        if ($_POST[direction] != '') { // may be redirected from other page or accidentally reloaded, so it will be empty.
            $sql = "INSERT INTO funds VALUES (
            '$_POST[source]',
            '$_POST[amount]',
            '$_POST[direction]',
            '$_POST[period]',
            '$_POST[description]',
            '$_POST[paymentDay]',
            '$_POST[category]',
            'true'
            )";
    
        if (dbQuery("budgetRodzinny", $sql)) {
            echo "<h3>Dodano następującą płatność:</h3>";
            echo "Nazwa płatności: ". $_POST[source] . "<br>";
            echo "Kwota: ". $_POST[amount] . "<br>";
            echo "Rodzaj: ". $_POST[direction] . "<br>";
            echo "Okres rozliczenia: ". $_POST[period] . "<br>";
            echo "Opis płatności: ". $_POST[description] . "<br>";
            echo "Data płatności: ". $_POST[paymentDay] . "<br>";
            echo "Kategorie: ". $_POST[category] . "<br>";
            echo "<br>";
        } else {
            echo "<h3>Błąd!</h3>" . $sql . "<br>" . pq_last_error($conn);
        }
    } else {
        echo "<h3>Błąd!</h3> Nie dodano pozycji.";
    }
    
    ?>
        <div>
            <br><br>
            <button id="nextItem" onclick="window.location.href='/html/add_item.html'">Dodaj następną pozycję</button>
            <button id="back" onclick="window.location.href='/index.html'">Wróć na stronę główną</button>
        </div>
    </div>

</body> 
</html>