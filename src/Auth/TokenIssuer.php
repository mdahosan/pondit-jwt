<?php
/**
 * Created by PhpStorm.
 * User: Pondit
 * Date: 1/20/2020
 * Time: 11:07 AM
 */

namespace Pondit\Auth;


use Firebase\JWT\JWT;
use PDO;
use Pondit\Api\TokenValidator;
use Pondit\Database\DB;
use Pondit\Response\Responsable;

class TokenIssuer extends DB
{
    use Responsable, TokenValidator;
   
    public $conn;

    /**
     * TokenIssuer constructor.
     */
    public function __construct()
    {
        $this->conn = parent::__construct();
    }

    /**
     * @param array $data
     */
    public function generateToken(array $data = []) 
    {
        
        try {

            $errors = \Pondit\Validation\Validator::validate([
                [
                    'name' => 'email',
                    'value' => $_POST['email']??'',
                    'rules' => 'required|email',
                ],[
                    'name' => 'password',
                    'value' => $_POST['password']??'',
                    'rules' => 'required',
                ]
            ]);

            if(count($errors)>0){
                $response = new \Pondit\Response\Response();
                $response->throwError(VALIDATION_ERROR, $errors);
            }

            $user = $this->getUserByCredential($data);

            if(!$user){
                $this->returnResponse(INVALID_USER_PASS, "Invalid Credential.");
            }

            if( $user['is_active'] == 0 ) {
                $this->returnResponse(USER_NOT_ACTIVE, "User is not activated. Please contact to admin.");
            }

            $payload = [
                'iat' => time(),
                'iss' => HOST,
                'exp' => time() + (TOKEN_LIFE_TIME),
                'userId' => $user['id']
            ];

            $token = JWT::encode($payload, JWT_SECRETE_KEY);

            $data = [
                'token' => $token,
                'issue_at' => $payload['iat'],
                'expiration_at' =>$payload['exp']
            ];

            $this->returnResponse(SUCCESS_RESPONSE, $data);
        } catch (\Exception $e) {
            $this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
        }
    }

    public function getUserByCredential(array $data = [])
    {

        try{
            $sql= "SELECT * FROM users 
                   where email=:emailInput
                   and  password=:passwordInput";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":emailInput", $data['email']);
            $stmt->bindParam(":passwordInput", $data['password']);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!is_array($user)){
                return false;
            }
            return $user;
        } catch (\PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }

}