<?php

namespace MVC\Controllers;

use MVC\Models\DaoSingleton;
use MVC\Modules\Authorization;
use stdClass;

class HealthController {
    public function getHealthInfo() {
        $payload = Authorization::decodeJWT();

        if (!$payload) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        $userid = $payload['userid'];

        $dao = DaoSingleton::getInstance();
        $result = $dao->getHealthInfo($userid);

        if (!$result) {
            header('HTTP/1.1 404 Not Found');
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($result);

    }
    public function saveHealthInfo() {
        $payload = Authorization::decodeJWT();
        
        if (!$payload) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        $userid = $payload['userid'];

        $values =  json_decode(file_get_contents('php://input'), true);

        if (!$values['userid'] || !$values['idade'] || !$values['sexo'] || !$values['peso'] || !$values['altura']) {
            header('HTTP/1.1 400 Bad Request');
            return;
        }

        $dao = DaoSingleton::getInstance();

        $err = $dao->getHealthInfo($userid);

        if ($err) {
            header('HTTP/1.1 409 Conflict');
            return;
        }

        $dao->saveHealthInfo($userid, $values['sexo'], $values['peso'], $values['altura'], $values['idade']);

        header('HTTP/1.1 201 Created');
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Health info saved']);

    }
    public function updateHealthInfo() {
        $payload = Authorization::decodeJWT();
        
        if (!$payload) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }
        
        $userid = $payload['userid'];

        $values =  json_decode(file_get_contents('php://input'), true);

        $dao = DaoSingleton::getInstance();
        $result = $dao->getHealthInfo($userid);

        if (!$result) {
            header('HTTP/1.1 404 Not Found');
            return;
        }

        if (isset($values['sexo'])) {
            $result['sexo'] = $values['sexo'];
        }

        if (isset($values['peso'])) {
            $result['peso'] = $values['peso'];
        }

        if (isset($values['altura'])) {
            $result['altura'] = $values['altura'];
        }

        if (isset($values['idade'])) {
            $result['idade'] = $values['idade'];
        }

        $dao->updateHealthInfo($userid, $result['sexo'], $result['peso'], $result['altura'], $result['idade']);

        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Health info updated']);
    }

    public function addDaySteps() {
        $payload = Authorization::decodeJWT();
        
        if (!$payload) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        $userid = $payload['userid'];

        $values =  json_decode(file_get_contents('php://input'), true);

        if (!$values['passos'] || !$values['userid']) {
            header('HTTP/1.1 400 Bad Request');
            return;
        }

        $dao = DaoSingleton::getInstance();

        $dao->addDaySteps($userid, $values['passos']);

        header('HTTP/1.1 201 Created');
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Steps saved']);

    }
    public function getLastSteps() {
        $payload = Authorization::decodeJWT();
        
        if (!$payload) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        $userid = $payload['userid'];

        $dao = DaoSingleton::getInstance();
        $result = $dao->getLastSteps($userid);

        if (!$result) {
            header('HTTP/1.1 404 Not Found');
            return;
        }

        header('Content-Type: application/json');
        echo json_encode($result);

    }
    public function addDayMeals() {}
    public function getLastMeals() {}
    public function getBMR() {
        $payload = Authorization::decodeJWT();
        
        if (!$payload) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        $userid = $payload['userid'];

        $dao = DaoSingleton::getInstance();
        $result = $dao->getHealthInfo($userid);

        if (!$result) {
            header('HTTP/1.1 404 Not Found');
            return;
        }

        $weight = $result['peso'];
        $height = $result['altura'];
        $age = $result['idade'];
        $gender = $result['sexo'];

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

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
