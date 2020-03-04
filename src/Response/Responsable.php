<?php

namespace Pondit\Response;


trait Responsable
{

    public function returnResponse($code, $data) {
        header("content-type: application/json");
        $response = json_encode(['status' => $code, "result" => $data]);
        echo $response; exit;
    }

    public function throwError($code, $message) {
        header("content-type: application/json");
        $errorMsg = json_encode(['status'=>$code, 'message'=>$message]);
        echo $errorMsg; exit;
    }

}