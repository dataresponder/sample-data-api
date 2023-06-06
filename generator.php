<?php
$json = file_get_contents('config.json');
$data = json_decode($json, true);

foreach ($data as $key => $value) {
  $total = $data[$key]['total'];
  $Weeks = array();
  for ($x = 0; $x <= 52; $x++) {
    $weekParameter = $data[$key]['weeks'][$x];
    $each_week = $weekParameter * $total;
    array_push($Weeks, $each_week);
  }

  $daysParameters = array();
  for ($x = 0; $x <= 6; $x++) {
    $gathering = $data[$key]['days'][$x];
    array_push($daysParameters, $gathering);
  }


  foreach ($Weeks as $value1) {
    foreach ($daysParameters as $value2) {
      $days[] = $value1 * $value2;
    }
  }

  $days = array_map(function ($value) {
    return ceil($value * 10) / 10;
  }, $days);


  $file = 'data_output_' . $key . '.json';

  $generator = '{"year":' . json_encode($days, JSON_PRETTY_PRINT) . '}';

  file_put_contents($file, $generator);


  unset($Weeks);
  unset($daysParameters);
  unset($days);
}