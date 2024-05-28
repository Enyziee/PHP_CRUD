<?php

namespace MVC\Controllers;

use MVC\Models\DaoSingleton;
use MVC\Modules\JWT;
use stdClass;

class CalorieController {
    public function calculateBMR() {

        $values =  json_decode(file_get_contents('php://input'), true);

        $age = $values['age'];
        $gender = $values['gender'];
        $weight = $values['weight'];
        $height = $values['height'];

        if (!$age || !$gender || !$weight || !$height) {
            header('HTTP/1.1 400 Bad Request');
            return;
        }


        $genderValue = 0;

        if ($gender === 'male') {
            $genderValue = 5;
        } else if ($gender === 'female') {
            $genderValue = -161;
        }
        
        $bmr = 10 * $weight + 6.25 * $height - 5 * $age + $genderValue;

        $response = new stdClass();
        $response->bmr = $bmr;
        $response->calories = [
            'little to no exercise' => $bmr * 1.2,
            'light exercise' => $bmr * 1.375,
            'moderate exercise' => $bmr * 1.55,
            'heavy exercise' => $bmr * 1.725,
            'very heavy exercise' => $bmr * 1.9
        ];
        
        $token = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);

        $payload = json_decode(JWT::verifyJWT($token[1]), true);
        $userid = $payload['userid'];

        $dao = DaoSingleton::getInstance();
        $dao->saveRecord($userid, json_encode($response));

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

?>