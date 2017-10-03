<?php
    echo "<tr id='header'>
                    <th>Źródło przychodu</th>
                    <th>Kwota</th>
                    <th>Opis</th>
                    <th>Data ostatniej wpłaty</th>
                    <th>Okres rozliczenia</th>
                    <th>Data następnej<br>wpłaty</th>
            </tr>";

    $sql = "SELECT * FROM funds WHERE direction='income'";

// ###### connecting to database
    $result = dbQuery("budgetRodzinny", $sql);

// ####### displaying the results
$now = getdate();

$resultTable = pg_fetch_all($result);
foreach($resultTable as $key => $value) {
    echo "<tr id='body'>
        <td>" . $resultTable[$key]['source'] . "</td>
        <td class='text-right'>£" . $resultTable[$key]['amount'] . "</td>";
    echo "
        <td>" . $resultTable[$key]['description'] . "</td>
        <td>" . $resultTable[$key]['payment_day'] . " " . $data['okres']['od_miesiac'] . "</td>";

// payment period and next payday
    if ($now[day] > 23) {
        $the_month = $now[m];
    } else {
        $the_month = date('m', strtotime('-25 days'));
    }

    switch ($resultTable[$key]['period']) {
        case ("one-off"):
            echo "<td>jednorazowo</td>";
            break;
        case ("weekly"):
            echo "<td>co tydzień</td>";
            break;
        case ("4-weekly"):
            echo "<td>co cztery tygodnie</td>";
            $next_income = date('d-F-Y', strtotime('+4 weeks', strtotime($now[year] . "-" . $the_month . "-" . $resultTable[$key]['payment_day'])));
            break;
        case ("monthly"):
            echo "<td>co miesiąc</td>";
            $next_income = date('d-F-Y', strtotime('+1 month', strtotime($now[year] . "-" . $the_month . "-" . $resultTable[$key]['payment_day'])));
            break;
    }

    $next_income_array = explode("-", $next_income);
    echo "<td>" . $next_income_array[0] . " " . get_miesiac($next_income_array[1]) . "</td>";
    
// sum up the income
    $total_income += $resultTable[$key]['amount'];
}
echo "<tr id='income_footer' class='text-right'><td>Razem:</td><td>" . $total_income . "</td></tr>";


//for ($i = 1; $i < 40; $i++) {
//
//echo "<br>" . date('l, d-F-Y', strtotime('+1 day', strtotime($now[year] . "-02-" . $i)));
//
//}

//        echo $resultTable[$key]['source'] . "<br>";
//        echo sizeof($resultTable); // liczy same rzędy
//        echo sizeof($resultTable,1) // liczy wszystkie elementy
?>