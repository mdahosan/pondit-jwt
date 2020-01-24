<?php
/**
 * Created by PhpStorm.
 * User: Pondit
 * Date: 1/20/2020
 * Time: 7:27 PM
 */

namespace Pondit\Auth;


use Pondit\Database\DB;
use Pondit\Response\Responsable;

class Register extends DB
{
    use Responsable;

    private $name;
    private $mobileNumber;
    private $email;
    private $password;
    private $isActive = true;
    public $conn;

    /**
     * Register constructor.
     */
    public function __construct()
    {
        $this->conn = parent::__construct();
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data = [])
    {

        if (array_key_exists('name', $data) && !is_null($data['name'])) {
            $this->name = $data['name'];
        }

        if (array_key_exists('mobile_number', $data) && !is_null($data['mobile_number'])) {
            $this->mobileNumber = $data['mobile_number'];
        }

        if (array_key_exists('email', $data) && !is_null($data['email'])) {
            $this->email = $data['email'];
        }

        if (array_key_exists('password', $data) && !is_null($data['password'])) {
            $this->password = $data['password'];
        }

        return $this;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function register(array $data = [])
    {
        try{

            $errors = \Pondit\Validation\Validator::validate([
                [
                    'name' => 'name',
                    'value' => $_POST['name']??'',
                    'rules' => 'required',
                ],[
                    'name' => 'email',
                    'value' => $_POST['email']??'',
                    'rules' => 'required|email',
                ],[
                    'name' => 'mobile_number',
                    'value' => $_POST['mobile_number']??'',
                    'rules' => 'required|numeric',
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

            $sql = 'INSERT INTO users (id, name, mobile_number, email, password, is_active) VALUES(null, :name, :mobile_number, :email, :password, :is_active)';

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':mobile_number', $this->mobile_number);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':is_active', $this->isActive);

            if($stmt->execute()) {
                $this->returnResponse(SUCCESS_RESPONSE, 'Registration Successful.');
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
        }
    }

}