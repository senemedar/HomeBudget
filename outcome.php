<?php
echo "<tr id='header'>
    <th>Lp.</th>
    <th>Odbiorca</th>
    <th>Kwota</th>
    <th>Opis</th>
    <th>Data płatności</th>
    <th>Okres rozliczenia</th>
    </tr>";

$sql = "SELECT * FROM funds WHERE direction='outcome' ORDER BY amount DESC";

// ###### connecting to database
$result = dbQuery("budgetRodzinny", $sql);

// ####### fetching and displaying the results
$resultTable = pg_fetch_all($result);
// ####### setting the paid/unpaid date
if ($data['dzien'] > 23 && $data['dzien'] < 32) {
    $begin_paid1 = 24;
    $end_paid1 = $data['dzien'];
    $begin_unpaid1 = ($data['dzien'] + 1);
    $end_unpaid1 = 31;
    $begin_unpaid2 = 1;
    $end_unpaid2 = 23;
} elseif ($data['dzien'] > 0 && $data['dzien'] < 23) {
    $begin_paid1 = 24;
    $end_paid1 = 31;
    $begin_paid2 = 1;
    $end_paid2 = $data['dzien'];
    $begin_unpaid1 = ($data['dzien'] + 1);
    $end_unpaid1 = 23;
}

//echo "paid1:" . $begin_paid1 . " do " . $end_paid1 . "\n";
//echo "paid2:" . $begin_paid2 . " do " . $end_paid2 . "\n";
//echo "unpaid1:" . $begin_unpaid1 . " do " . $end_unpaid1 . "\n";
//echo "unpaid2:" . $begin_unpaid2 . " do " . $end_unpaid2 . "\n";

$lp = 1; // ordering number
foreach($resultTable as $key => $value) {
    // check the date
    if ($resultTable[$key]['payment_day'] >= $begin_paid1 && $resultTable[$key]['payment_day'] <= $end_paid1 ||
        $resultTable[$key]['payment_day'] >= $begin_paid2 && $resultTable[$key]['payment_day'] <= $end_paid2)
        {
        echo "<tr id='body' class='paid'>
            <td>" . $lp ."</td>
            <td>" . $resultTable[$key]['source'] . "</td>
            <td class='text-right'>£" . $resultTable[$key]['amount'] . "</td>
            <td>" . $resultTable[$key]['description'] . "</td>
            <td>";

        // display the payment date
        $d = $resultTable[$key]['payment_day'];
        if ($d > 23) {
            echo $d . " " . $data['okres']['od_miesiac'] . "</td>";
        } else {
            echo $d . " " . $data['okres']['do_miesiac'] . "</td>";
        }
        // display the period
        switch ($resultTable[$key]['period']) {
            case ("one-off"):
                echo "<td>jednorazowo</td>";
                break;
            case ("weekly"):
                echo "<td>co tydzień</td>";
                break;
            case ("4-weekly"):
                echo "<td>co cztery tygodnie</td>";
                break;
            case ("monthly"):
                echo "<td>co miesiąc</td>";
                break;
        }
    //    echo "<td>" . $resultTable[$key]['last_payment'] . "</td></tr>";

        $total_outcome += $resultTable[$key]['amount'];
        $lp++;
    }
}

// displaying the unpaid results
    foreach($resultTable as $key => $value) {
    // check the date
    if ($resultTable[$key]['payment_day'] >= $begin_unpaid1 && $resultTable[$key]['payment_day'] <= $end_unpaid1 ||
        $resultTable[$key]['payment_day'] >= $begin_unpaid2 && $resultTable[$key]['payment_day'] <= $end_unpaid2)
        {
        echo "<tr id='body'>
            <td>" . $lp ."</td>
            <td>" . $resultTable[$key]['source'] . "</td>
            <td class='text-right'>£" . $resultTable[$key]['amount'] . "</td>
            <td>" . $resultTable[$key]['description'] . "</td>
            <td>";

        // display the payment date
        echo $resultTable[$key]['payment_day'] . " " . $data['okres']['do_miesiac'] . "</td>";

        // display the period
        switch ($resultTable[$key]['period']) {
            case ("one-off"):
                echo "<td>jednorazowo</td>";
                break;
            case ("weekly"):
                echo "<td>co tydzień</td>";
                break;
            case ("4-weekly"):
                echo "<td>co cztery tygodnie</td>";
                break;
            case ("monthly"):
                echo "<td>co miesiąc</td>";
                break;
        }
    //    echo "<td>" . $resultTable[$key]['last_payment'] . "</td></tr>";

        $total_outcome += $resultTable[$key]['amount'];
        $total_unpaid += $resultTable[$key]['amount'];
        $lp++;
    }
}

echo "<tr id='outcome_footer' class='text-right'><td></td><td>Razem:</td><td>£" . $total_outcome . "</td></tr>";
echo "<tr id='outcome_footer' class='text-right'><td></td><td>Zostało do zapłaty:</td><td>£" . $total_unpaid . "</td></tr>";
        
//        echo $resultTable[$key]['source'] . "<br>";
//        echo sizeof($resultTable); // liczy same rzędy
//        echo sizeof($resultTable,1) // liczy wszystkie elementy
?>