<?php

namespace Pondit\Auth;


use Pondit\Database\DB;
use Pondit\Response\Responsable;
use PDO;

class Register extends DB
{
    use Responsable;

    private $conn, $name, $mobileNumber, $email, $password;
    private $isActive = true;
    private $customField = null;

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

        if (array_key_exists('password', $data) && !is_null($data['password'])) {
            $this->password = $data['password'];
        }

        if (array_key_exists('custom_field_1', $data) && !is_null($data['custom_field_1'])) {
            $this->customField = $data['custom_field_1'];
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

            $errors = $this->validateRequest($data);

            if($this->checkUserIsExist($_POST['email'])){
                $errors['email'][] = $_POST['email']. ' has already been taken !';
            }

            if(count($errors)>0){
                $this->throwError(VALIDATION_ERROR, $errors);
            }

            $sql = 'INSERT INTO users (id, name, mobile_number, email, password, is_active, custom_field_1) VALUES(null, :name, :mobile_number, :email, :password, :is_active, :custom_field_1)';

            $hashedPwd = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':mobile_number', $this->mobileNumber);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $hashedPwd);
            $stmt->bindParam(':is_active', $this->isActive);
            $stmt->bindParam(':custom_field_1', $this->customField);

            if($stmt->execute()) {
                $this->returnResponse(SUCCESS_RESPONSE, 'Registration Successful.');
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $this->throwError(PDO_EXCEPTION, $e->getMessage());
        }
    }


    /**
     * Find a specific user by email
     * @param $email
     * @return bool
     */
    public function checkUserIsExist($email)
    {
        $sql= "SELECT * FROM users where email=:email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return is_array($user) ? true : false;
    }


    public function validateRequest(array $data = [])
    {
        return \Pondit\Validation\Validator::validate([
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
    }


}