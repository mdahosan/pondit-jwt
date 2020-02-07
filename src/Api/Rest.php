<?php

namespace Pondit\Api;

use Firebase\JWT\JWT;
use Pondit\Database\DB;
use Pondit\Response\Responsable;
use PDO;

class Rest
{
    use TokenValidator, Responsable;

    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO('mysql:host=' .DB_HOST .';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if($_SERVER['REQUEST_METHOD'] !== 'POST') {
                $this->throwError(REQUEST_METHOD_NOT_VALID, 'Request Method is not valid.');
            }

            $handler = fopen('php://input', 'r');
            $this->request = stream_get_contents($handler);
            $this->validateRequest();
            $this->validateToken();

            return $this->conn;
        } catch (\Exception $e) {
            echo "Database Error: " . $e->getMessage();
        }

    }

    /**
     * Request validation
     */
    Public function validateRequest() {
        if($_SERVER['CONTENT_TYPE'] !== 'application/json') {
            $this->throwError(REQUEST_CONTENTTYPE_NOT_VALID, 'Request content type is not valid');
        }
    }

    /**
     * Bearer Token validation
     */
    public function validateToken() {
        try {
            $token = $this->getBearerToken();
            $payload = JWT::decode($token, SECRETE_KEY, ['HS256']);

            $user = $this->findUserById($payload->userId);

            if(!is_array($user)) {
                $this->returnResponse(INVALID_USER_PASS, "This user is not found in our database.");
            }

            if( $user['is_active'] == 0 ) {
                $this->returnResponse(USER_NOT_ACTIVE, "This user may be decactived. Please contact to admin.");
            }
            $this->userId = $payload->userId;
        } catch (\Exception $e) {
            $this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
        }
    }

    /**
     * Get user from Bearer Token
     * @return bool
     */
    public function user()
    {
        try {
            $token = self::getBearerToken();
            $payload = JWT::decode($token, JWT_SECRETE_KEY, ['HS256']);

            $user = $this->findUserById($payload->userId);

            if(!is_array($user)) {
                $this->returnResponse(INVALID_USER_PASS, "This user is not found in our database.");
            }

            if( $user['is_active'] == 0 ) {
                $this->returnResponse(USER_NOT_ACTIVE, "This user may be decactived. Please contact to admin.");
            }
            return $user;
        } catch (\Exception $e) {
            $this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
        }
    }

    /**
     * Find a specific user by id
     * @param $id
     * @return bool
     */
    public function findUserById($id)
    {
        $sql= "SELECT * FROM users where id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return is_array($user) ? $user : false;
    }

}
 ?>