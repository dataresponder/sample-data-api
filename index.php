<?php
     function error(){
      $result = [ 'status' =>'error']; 
      header('Content-type: application/json');
      echo json_encode( $result );
      track(json_encode( $result ));
      die();
     }
     
     function cal_days_in_year($year){
      $days=0; 
      for($month=1;$month<=12;$month++){ 
          $days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
      }
         return $days;
      }

      function ip(){ 
         if ($_SERVER['HTTP_X_FORWARDED_FOR']) { 
             $ip_prawdziwe = $_SERVER['HTTP_X_FORWARDED_FOR']; 
         } 
         else { 
             $ip_prawdziwe = $_SERVER['REMOTE_ADDR']; 
         } 
         return $ip_prawdziwe; 
     }    

     function path(){
         $ref = $_SERVER['REQUEST_URI'];
         return $ref;
     }
     
     function track($mess){ 
             $dane = "";
             $dane = date("Y-m-d H:i:s").",";
             $dane .= ip().",";;
             $dane .= path().",";           
             $dane .= $mess;            
             $dane .= "\n";
             $file = "log.txt"; 
             $fp = fopen($file, "a"); 
             flock($fp, 2); 
             fwrite($fp, $dane); 
             flock($fp, 3); 
             fclose($fp);
     }

      $current_day_of_year = date('z');

      $firstday = date('N', strtotime(date('Y').'-01-01')) - 1;

      $maxdays = cal_days_in_year(date('Y'));

     if(isset($_GET['id'])){
        $filename = 'data_output_'.$_GET['id'].'.json';
        if(file_exists($filename)){
         $contents = file_get_contents('config.json');
         $config = json_decode($contents, true);
         $factor = $config[$_GET['id']]['factor'];
         $json = file_get_contents($filename);
         $data = json_decode($json, true);
         $elements = array_slice($data['year'], 0, $firstday); 
         $remainingElements = array_slice($data['year'], $firstday);
         $modifiedData = array_merge($remainingElements, $elements);
         if(date('L')){
            $modifiedData = array_slice($modifiedData, 0, $maxdays);
         }
         else{
            $modifiedData = array_slice($modifiedData, 0 , $maxdays);
         }
        }
        else{
         error();
        }
     }
     else{
      error();
     }

     $condition = 0;

     if (isset($_GET['y'])) {
         $condition++;
     }
     
     if (isset($_GET['m'])) {
         $condition++;
     }
     
     if (isset($_GET['w'])) {
         $condition++;
     }
     
     if (isset($_GET['d'])) {
         $condition++;
     }
     
   if($condition == 1){
      if(isset($_GET['y'])){
         if(is_numeric($_GET['y']) && $_GET['y'] == 1){
            $value = ceil(array_sum($modifiedData));
         }
         else{
            error();
         }
      }
      if(isset($_GET['m'])){
         if(is_numeric($_GET['m']) && $_GET['m'] >= 1 && $_GET['m'] <= 12){
            $originalArray = $modifiedData;

            for($x = 1; $x <= 12; $x++){
               $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $x, date('Y'));
               ${"month".$x} = array_slice($originalArray, 0, $daysInMonth);
               $originalArray = array_slice($originalArray, $daysInMonth);;
            }
            $m = $_GET['m'];
            $value = round(array_sum(${"month". $m}), 1);
         }
         else{
            error();
         }
      }
      if(isset($_GET['w'])){
         if(is_numeric($_GET['w']) && $_GET['w'] >= 1 && $_GET['w'] <= 52){
            $Array = $modifiedData;
            for($x = 1; $x <= 52; $x++){
               ${"week".$x} = array_slice($Array, 0, 7);
               $Array = array_slice($Array, 7);
            }
         }
         $w = $_GET['w'];
         $value = ceil(array_sum(${"week". $w}));
      }
      if(isset($_GET['d'])){
         if(is_numeric($_GET['d']) && $_GET['d'] >= 1 && $_GET['d'] <= $maxdays){
            $d = $_GET['d'];
            $value = $modifiedData[$d-1];
         }
         else{
            error();
         }
      }
   }
   elseif($condition == 0){
      $value = $modifiedData[$current_day_of_year - 1];
   }
   else{
      error();
   }
    $result = [ 'value' => $value, 'factor' => $factor,'status' => 'ok']; 
    header('Content-type: application/json');
    echo json_encode( $result );
    track(json_encode( $result ));