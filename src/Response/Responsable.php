<?php
/**
 * Created by PhpStorm.
 * User: Pondit
 * Date: 1/20/2020
 * Time: 4:03 PM
 */

namespace Pondit\Response;


trait Responsable
{

    public function returnResponse($code, $data) {
        header("content-type: application/json");
        $response = json_encode(['response' => ['status' => $code, "result" => $data]]);
        echo $response; exit;
    }

    public function throwError($code, $message) {
        header("content-type: application/json");
        $errorMsg = json_encode(['error' => ['status'=>$code, 'message'=>$message]]);
        echo $errorMsg; exit;
    }

}