<?php
  $days = array(
    1 => "Lunes",
    2 => "Martes",
    3 => "Miércoles",
    4 => "Jueves",
    5 => "Viernes",
    6 => "Sábado",
    7 => "Domingo",
  );

  date_default_timezone_set("America/Argentina/Buenos_Aires");
  define("PENDING", 0);
  define("ACCEPTED", 1);
  define("REJECTED", 2);
  define("DONE", 1);
  define("ONE_TIME_TRIP", 0);
  define("WEEKLY_TRIP", 1);
  define("PAID_TRIP", 1);
  define("UNPAID_TRIP", 0);
  define("DRIVER", 0);
  define("PASSENGER", 1);
  define("CALIFICATION_PASSENGER", 3);
  define("CALIFICATION_DRIVER", 4);
?>
