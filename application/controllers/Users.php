<?php

/**
 * Created by PhpStorm.
 * User: adanjz
 * Date: 2/27/20
 * Time: 5:25 PM
 */
use \Firebase\JWT\JWT;

class Users extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->loader->model('usersModel');
    }

    public function register()
    {
        $user = new usersModel();

        $data = $this->request;
        if(empty($data) || empty($data['email']) || empty($data['password'])){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid data"
            ));
        }
        $user->object->first_name = $data['first_name']??'';
        $user->object->last_name = $data['last_name']??'';
        $user->object->email = $data['email']??'';
        $user->object->password = hash('sha256',md5($data['password']))??'';
        $user->save();
        echo json_encode(['success'=>true,'message'=>'User has been created']);
    }
    public function login()
    {
        $data = $this->request;
        if(empty($data) || empty($data['email']) || empty($data['password'])){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid data"
            ));
        }
        $user = usersModel::findOne('email = ? and password = ?',[$data['email'],hash('sha256',md5($data['password']))]);
        if(!empty($user)){
            $secret_key = "adanzweig";
            $issuer_claim = "localhost"; // this can be the servername
            $audience_claim = "zipdev";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 10; //not before in seconds
            $expire_claim = $issuedat_claim + 600; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $user->id,
                    "firstname" => $user->firstname,
                    "lastname" => $user->lastname,
                    "email" => $user->email
                ));

            http_response_code(200);

            $jwt = JWT::encode($token, $secret_key);
            echo json_encode(
                array(
                    "message" => "Successful login.",
                    "jwt" => $jwt,
                    "email" => $user->email,
                    "expireAt" => $expire_claim
                ));
        }
        else{
            http_response_code(401);
            echo json_encode(array("message" => "Login failed.", "password" => 'Password incorrect'));
        }
    }

}