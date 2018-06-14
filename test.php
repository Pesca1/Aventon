<?php

include("php/utils.php");

$start1 = DateTime::createFromFormat( "Y-m-d H:i:s", "2018-06-13 18:30:00");
$start2 = DateTime::createFromFormat("Y-m-d H:i:s", "2018-06-13 18:35:00");
$interval1 = new DateInterval("PT2H35M");
$interval2 = new DateInterval("PT4H15M");
$end1 = addDate($start1, $interval1);
$end2 = addDate($start2, $interval2);

checkTripDates("2018-06-13 18:30:00", "2", "2018-06-12 18:00:00", "25");


/*(strtotime("2018-06-12 19:30:00") > strtotime("2018-06-13 18:35:00")){
  echo "la puta que te pario";
}*/

?>
