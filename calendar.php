<?php
$now = getdate();
if ($now[mday] > 23) {
//    $rozl = getdate(date("U", strtotime("+10 days")));
    $rozl = $now;
} else {
//    $rozl = $now;
    $rozl = getdate(date("U", strtotime("-25 days")));
}

//$rozl = getdate(date("U", strtotime("01/02/2017")));

// kalendarz
$d = 23;
$m = $rozl[mon];
$y = $rozl[year];
//echo "++>" . $d . "." . $m . "." . $y . "check:" . checkdate($m,$d,$y);
do {
    echo "<br>" . date('l, d-F-Y', strtotime('+1 day', strtotime($d . "-" . $m . "-" . $y))) . "check:" . checkdate($m,$d,$y);
    if (checkdate($m+1, $d, $y)) {
        $d++;        
    } else {
        $d = 1;
        $m++;
    }
} while ($d <> 23);

?>