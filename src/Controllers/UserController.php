<?php

namespace MVC\Controllers;

use MVC\Models\DaoSingleton;
use MVC\Modules\JWT;
use stdClass;

class UserController {
    public function getHistory() {
        $token = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);

        if (!$token[1]) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }

        $payload = null;

        try {
            $payload = JWT::verifyJWT($token[1]);
        } catch (\Throwable $th) {
            header('HTTP/1.1 401 Unauthorized');
            return;
        }


        $dao = DaoSingleton::getInstance();

        $userid = json_decode($payload, true)['userid'];

        $result = $dao->getAllRecords($userid);
        
        $response = new stdClass();
        $response->data = [];


        foreach ($result as $key => $value) {
            array_push($response->data, json_decode($value));
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}