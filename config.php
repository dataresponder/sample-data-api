<?php
function noauth(){
    $result = ['status' => 'no_authority'];
    echo json_encode($result);
}

header('Content-type: application/json');
$data = json_decode(trim(file_get_contents("php://input")));

if (isset($data)) {
    if ($data->pass == '1234') {
        if ($_GET['a'] == 'read') {
            $json = file_get_contents('config.json');
            echo $json;
        } elseif ($_GET['a'] == 'write') {
            $text = $data->conf;
            //echo $data;
            $check = json_decode($text);
            if (json_last_error() === JSON_ERROR_NONE) {
                $jsonData = json_encode($check, JSON_PRETTY_PRINT);
                $file = 'config.json';
                file_put_contents($file, $jsonData);
                echo json_encode(['status' => 'ok']);
            } else {
                echo "ERROR - invalid JSON";
            }
        } elseif ($_GET['a'] == 'make') {
            require 'generator.php';
            echo json_encode(['status' => 'ok']);
        } else {
            $result = ['status' => 'no_parameter'];
            echo json_encode($result);
        }
    } else {
        noauth();
    }
} else {
    $result = ['status' => 'no_response'];
    echo json_encode($result);
}