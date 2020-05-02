<?php

/*
Jeff Olson

php file that parses sql statement, queries database, and outputs data accordingly
Includes SQL parser that breaks up sql query and stores columns queried


*/

//puts POST request into variable query to be passed to mysqli
$query=$_POST["Query"];

//GLB arrays to store values throughout parsing
$GLB_tripsarray = ['bikeid', 'starttime', 'stoptime', 'tripduration', 'startstationid', 'endstationid', 'usertype', 'gender', 'birthyear'];
$GLB_stationsarray = ['stationid', 'stationname', 'stationlatitude', 'stationlongitude'];
$GLB_totalarray = ['bikeid', 'starttime', 'stoptime', 'tripduration', 'startstationid', 'endstationid', 'usertype', 'gender', 'birthyear', 'station_id', 'stationname', 'stationlatitude', 'stationlongitude'];
$GLB_paramarr = [];
$GLB_displayarr = [];
$GLB_temparr = [];
$GLB_queryarray2 = [];

//GLB_bool values for Row(s) created/delete/update/insert
$_bool_insert = False;
$_bool_create = False;
$_bool_delete = False;
$_bool_update = False;
$_bool_count = False;
$_bool_trips = False;
$_bool_stations = False;
$_bool_both = False;
$_in_parans = [];

//begin parsing sql string using preg in queryarray
$GLB_queryarray = preg_split('/[\s,]+/', $query);

//print_r($GLB_queryarray);

foreach($GLB_queryarray as &$value)
{
	if ($value === 'DROP') {
		echo "DROP QUERIES NOT ALLOWED";
		exit();
	}
}

$t = 0;
$t2 = 0;

foreach($GLB_queryarray as &$value) {
	switch($value) {
		case 'INSERT':
			$_bool_insert = True;
			break;
		case 'DELETE':
			$_bool_delete = True;
			break;
		case 'UPDATE':
			$_bool_update = True;
			break;
		case 'CREATE':
			$_bool_create = True;
			break;
		case 'COUNT(':
			$_bool_count = True;
			$t2 = $t;
			$_in_parans[$t2] = $GLB_queryarray[$t2+1];
			break;
		case 'trips,':
			//echo "trips";
			$_bool_trips = True;
			break;
		case "stations;":
			//echo "stations";
			$_bool_stations = True;
			break;
		case 'trips':
			//echo "trips";
			$_bool_trips = True;
			break;
		case "stations":
			//echo "stations";
			$_bool_stations = True;
			break;
	}
	$t++;
}



//iterate through and drop everything past FROM because doesnt effect data output
foreach($GLB_queryarray as &$value) {
	if ($value == 'FROM') {
		break;
	}
	else {
		$tempvar2 = trim($value, '(');
		$GLB_queryarray2[] = $tempvar2;
	}
}


//print_r($GLB_queryarray2);
//$GLB_temparr = explode(".", $GLB_queryarray2);
//print_r($GLB_temparr);
/*
foreach ($GLB_temparr as &$value) {
	print($value);
}
*/
//parse out ctype_UPPER values, which are normally sql statements, sql 
//statement must be written with UPPERCASE values or else it fails.
foreach($GLB_queryarray2 as &$value)
{
	if (!ctype_upper($value) and !ctype_punct($value)) {
		$tempvar = trim($value, ',');
		//print($tempvar);
		//echo "<br></br>";
		$GLB_displayarr[] = $tempvar;		
	}
}

//print_r($GLB_displayarr);

//print_r($GLB_temparr);

/*
THIS CAN BE USED IF DATABASE HAS SPACES IN COLUMN NAMES

//second round of parsing, using implode on SPACE (' ') to make it a string
//again and then another explode on '`' to get string values into GLB_temparr

//$temp = implode(" ", $GLB_displayarr);

//$GLB_temparr = explode('.', $GLB_displayarr);

//print_r($GLB_temparr);



//When * value is used, GLB_paramarr is empty but doesnt matter because mysqli will reject the syntax if it is something other than *



//iterate through temparr to get rid of database name and extraneous 
//information

foreach($GLB_temparr as &$value) {
	if (ctype_alpha(str_replace(' ', '', $value))) {
		$GLB_paramarr[] = $value;
		//echo "$value";	
	}
}
*/

$GLB_temparr = array_unique($GLB_displayarr);
//print_r($GLB_temparr);

//print_r($GLB_paramarrtrim);
//print_r($GLB_paramarrtrim);

foreach ($GLB_temparr as &$value) {
	if ($value !== 'stations' and $value !== 'trips' and $value !== 'count' and $value !== 'COUNT(') {
		$GLB_paramarrtrim2[] = $value;
	}		
}
//print_r($_in_parans);


$GLB_paramarrtrim = array_diff($GLB_paramarrtrim2, $_in_parans);

//print_r($GLB_paramarrtrim);
/*
//unset if empty
foreach ($GLB_paramarrtrim as &$value) {
	if ($value !== 'stations' and $value !== 'trips') {

	}
}
*/
//print_r($GLB_paramarrtrim);


//MySQLCredentials
$dbhost = "localhost";
$dbpass = "ol1401";
$dbuser = "jolson";
$dbname = "jolson";

//Create Database Connection
//
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
echo "\n";

if (mysqli_connect_errno()) {
	printf("connection failed: %s\n", mysqli_connect_error());
	exit();
}

$c = 0;
if (!$connection) {
	die ('couldnt connect');
}

echo "<style> table, th, td {
	border: 1px solid black;
	border-collapse: collapse;} </style>";
//Perform Query if theres values in
$result_set = mysqli_query($connection, $query);
$numResults = mysqli_num_rows($result_set);
//print(count($numResults));

//first version, where GLB_paramtrim is not empty but count has not been used in the query
//echos subject of column name queried.
if ($numResults > 0 and count($GLB_paramarrtrim) > 0) {
	//echo "AHHH";
	echo "<table>";
	echo "<tr>";
	foreach($GLB_paramarrtrim as &$value) 
	{
		echo "<th>$value</th>";
	}
	if ($_bool_count === True) 
	{
		echo "<th> Count </th>";
	}
	echo "</tr>";
	echo "<tr>";
	
	if ($_bool_count === True) 
	{
		//echo "count was here\n";
		while ($subject = mysqli_fetch_array($result_set)) {
			foreach($GLB_paramarrtrim as &$value) {
				echo "<td>" . $subject["$value"] . "</td>";
				$c++;
			}
			echo "<td>" . $subject['count'] . "</td>";
			echo "</tr>";
		}
	}
	else 
	{
		while ($subject = mysqli_fetch_array($result_set)) 
		{
			foreach($GLB_paramarrtrim as &$value) 
			{
				echo "<td>" . $subject["$value"] . "</td>";
				$c++;
			}
			echo "</tr>";
		}
	}

	echo "</table>";
	mysqli_free_result($result_set);
}

// for if * is used, used GLB_totalarray to print value;
else if ($numResults > 0 and count($GLB_paramarrtrim) === 0) {
	//echo "OOOO";

	if ($_bool_trips === True) 
	{//different display for trips
		if ($_bool_count === True) {
			//echo "1a";
			echo "<table style='width:50%'>";
			echo "<tr>";
			echo "<th> Count </th>";
			echo "</tr>";
			echo "<tr>";
			while ($subject = mysqli_fetch_array($result_set)) {
				foreach($GLB_tripsarray as &$value) {
					//echo "<td>" . $subject['value'] . "</td>";
					$c++;
				}
				echo "<td>" . $subject['count'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
			mysqli_free_result($result_set);
		}
		else {
			//echo "1b";
			echo "<table style='width:100%'>";
			echo "<tr>";
			foreach($GLB_tripsarray as &$value) {
				echo "<th>$value</th>";
			}
			echo "</tr>";
			while ($subject = mysqli_fetch_array($result_set)) {
				echo "<tr>";
				foreach($GLB_tripsarray as &$value) {
					echo "<td>" . $subject["$value"] . "</td>";
					$c++;
				}
				echo "</tr>";
			}
			echo "</table>";
			mysqli_free_result($result_set);
		}
	}
	else if ($_bool_stations === True) 
	{//different display for stations
		if ($_bool_count === True)
		{
			//echo "2a";
			echo "<table style='width:100%'>";
			echo "<tr>";
				echo "<th> Count </th>";
			echo "</tr>";
			echo "<tr>";
			while ($subject = mysqli_fetch_array($result_set)) {
				foreach($GLB_stationsarray as &$value) {
					//echo "<td>" . $subject["$value"] . "</td>";
					$c++;
				}
				echo "<td>" . $subject['count'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
			mysqli_free_result($result_set);
		}
		else 
		{
			//echo "2b";
			echo "<table style='width:100%'>";
			echo "<tr>";
			foreach($GLB_stationsarray as &$value) {
				echo "<th>$value</th>";
			}
			echo "</tr>";
			while ($subject = mysqli_fetch_array($result_set)) {
				echo "<tr>";
				foreach($GLB_stationsarray as &$value) {
					echo "<td>" . $subject["$value"] . "</td>";
					$c++;
				}
				echo "</tr>";
			}
			echo "</table>";
			mysqli_free_result($result_set);
		}
	}
	else if ($_bool_stations === True and $_bool_trips === True)
	{//default display
		if ($_bool_count === True) 
		{
			//echo "3a";
			echo "<table style='width:100%'>";
			echo "<tr>";
			echo "<th> Count </th>";
			echo "</tr>";
			while ($subject = mysqli_fetch_array($result_set)) {
				echo "<tr>";
				foreach($GLB_totalarray as &$value) {
					//echo "<td>" . $subject["$value"] . "</td>";
					$c++;
				}
				echo "<td>" . $subject['count'] . "</td>";
				echo "</tr>";
			}
			echo "</table>";
			mysqli_free_result($result_set);
		}
		else 
		{
			//echo "3b";
			echo "<table style='width:100%'>";
			echo "<tr>";
			foreach($GLB_totalarray as &$value) {
				echo "<th>$value</th>";
			}
			echo "</tr>";
			while ($subject = mysqli_fetch_array($result_set)) {
				echo "<tr>";
				foreach($GLB_totalarray as &$value) {
					echo "<td>" . $subject["$value"] . "</td>";
					$c++;
				}
				echo "</tr>";
			}
			echo "</table>";
			mysqli_free_result($result_set);
		}
	}
	else {
		echo "Invalid SQL Syntax";
	}

}
else if (mysqli_affected_rows($connection) > 0) {
	echo "Affected Rows: " . mysqli_affected_rows($connection);
	
}
else {
	mysqli_free_result($result_set);
	echo "Invalid SQL syntax, check that you spelled everything correctly\n";
}

echo "<br></br>";

if ($c !== 0) {
	if ($_bool_insert === True) {
		echo "Row Inserted";
	}
	if ($_bool_update === True) {
		echo "Table Updated";
	}
	if ($_bool_delete === True) {
		echo "Row(s) Deleted";
	}
	if ($_bool_create === True) {
		echo "Table Created";
	}
}


echo "Number of Cells Retrieved = " . $c . "<br></br>";
//close conn
mysqli_close($connection);
echo "<button onclick='history.go(-1);'>Back </button>";

?>
