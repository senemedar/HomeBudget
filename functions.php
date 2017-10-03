<?php
date_default_timezone_set('Europe/London');

    $dni = array(
        'Monday' => 'Poniedziałek',
        'Tuesday' => 'Wtorek',
        'Wednesday' => 'Środa',
        'Thursday' => 'Czwartek',
        'Friday' => 'Piątek',
        'Saturday' => 'Sobota',
        'Sunday' => 'Niedziela'
    );
    $miesiace = array(
        'January' => 'Styczeń',
        'February' => 'Luty',
        'March' => 'Marzec',
        'April' => 'Kwiecień',
        'May' => 'Maj',
        'June' => 'Czerwiec',
        'July' => 'Lipiec',
        'August' => 'Sierpień',
        'September' => 'Wrzesień',
        'October' => 'Październik',
        'November' => 'Listopad',
        'December' => 'Grudzień'
    );
/*
    The function contains the values for the database
    and creates the connections.
    Returns the query result string.
*/
function dbQuery ($database, $query) {
	//	set up the database values
	$conn_string = "host=localhost ";
	$conn_string .= "port=5432 ";
	$conn_string .= "user=postgres ";
	$conn_string .= "password=31222646 ";
	$conn_string .= "dbname=".$database;
	
	//	Create and check the connection
	$conn = pg_connect($conn_string);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	};

	$query_result = pg_query($conn, $query);
	
	return $query_result;
}
/* Function to return the date
 ****
 * Returns:
 * Array(
 * dzien - dzień liczbowo
 * dzienTygodnia - nazwa dnia tygodnia
 * miesiac - nazwa miesiąca
 * rok - rok liczbowo (4 cyfry)
 *      )
 ****/
function data() {
    $now = getdate();
    $dni = array(
        'Monday' => 'Poniedziałek',
        'Tuesday' => 'Wtorek',
        'Wednesday' => 'Środa',
        'Thursday' => 'Czwartek',
        'Friday' => 'Piątek',
        'Saturday' => 'Sobota',
        'Sunday' => 'Niedziela'
    );
    $miesiace = array(
        'January' => 'Styczeń',
        'February' => 'Luty',
        'March' => 'Marzec',
        'April' => 'Kwiecień',
        'May' => 'Maj',
        'June' => 'Czerwiec',
        'July' => 'Lipiec',
        'August' => 'Sierpień',
        'September' => 'Wrzesień',
        'October' => 'Październik',
        'November' => 'Listopad',
        'December' => 'Grudzień'
    );
    $dzien = $dni[$now[weekday]];
    $miesiac = $miesiace[$now[month]];
// get the months for calculations
    if ($now[mday] > 23) {
        $rozl_start = $now;
        $rozl_end = getdate(date("U", strtotime("+10 days")));
    } else {
        $rozl_start = getdate(date("U", strtotime("-25 days")));
        $rozl_end = $now;
    }
    
    $okres = array(
        'od_miesiac' => $miesiace[$rozl_start[month]],
        'od_rok' => $rozl_start[year],
        'from_month' => $rozl_start[month],
        'from_year' => $rozl_start[year],
        'do_miesiac' => $miesiace[$rozl_end[month]],
        'do_rok' => $rozl_end[year],
        'to_month' => $rozl_end[month],
        'to_year' => $rozl_end[year],
    );
//    print_r($okres);
    return array(
        'dzien' => $now[mday],
        'dzienTygodnia' => $dzien,
        'miesiac' => $miesiac,
        'rok' => $now[year],
        'okres' => $okres
    );
}

function get_miesiac($mon) {
    $amon = array(
        'January' => 'Styczeń',
        'February' => 'Luty',
        'March' => 'Marzec',
        'April' => 'Kwiecień',
        'May' => 'Maj',
        'June' => 'Czerwiec',
        'July' => 'Lipiec',
        'August' => 'Sierpień',
        'September' => 'Wrzesień',
        'October' => 'Październik',
        'November' => 'Listopad',
        'December' => 'Grudzień'
    );
    return $amon[$mon];
}

function getPeriod() {
    
}
?>