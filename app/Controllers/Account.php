<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\User_model;

use Firebase\JWT\JWT;
use Config\Services;

class Account extends ResourceController{

    public function __construct(){
        $this->user = new User_model();
    }

    public function login(){

        $json = $this->request->getJSON();

        if($json){
            $username = $json->username;
            $password = $json->password;
        }else{    
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
        }
 
        $account = $this->user->getAccount($username);

        if($account){
            if(password_verify($password, $account['password']))
            {
                $secret_key = Services::privateKey();
                $issuer_claim = "THE_CLAIM"; // this can be the servername. Example: https://domain.com
                $audience_claim = "THE_AUDIENCE";
                $issuedat_claim = time(); // issued at
                $notbefore_claim = $issuedat_claim + 10; //not before in seconds
                $expire_claim = $issuedat_claim + 3600; // expire time in seconds
                $token = array(
                    "iss" => $issuer_claim,
                    "aud" => $audience_claim,
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $account['id'],
                        "username" => $account['username']
                    )
                );
     
                $token = JWT::encode($token, $secret_key);
     
                $output = [
                    'status' => 200,
                    'message' => 'Access Granted',
                    "token" => $token,
                    "username" => $username,
                    "expireAt" => $expire_claim
                ];
                return $this->respond($output, 200);
            } 
        }else {
            $output = [
                'status' => 401,
                'message' => 'Login failed'
            ];
            return $this->respond($output, 401);
        }
    }

    public function register(){

        $json = $this->request->getJSON();

        if($json){
            $username = $json->username;
            $password = $json->password;

        }else{
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

        }

        $account = $this->user->getAccount($username);

        if($account){
            $output = [
                'status' => 409,
                'message' => 'Username already exists'
            ];
            return $this->respond($output, 409);
        }

        $data_account = array(
            'username' => $username,
            'password' => password_hash($password,PASSWORD_BCRYPT)
        );

        try {
            
            $insert = $this->user->addAccount($data_account);

            if($insert){
                $output = [
                    'status' => 200,
                    'message' => 'Account created'
                ];
                $this->respond($output,200);
            }else{
                $output = [
                    'status' => 400,
                    'message' => 'Something went wrong'
                ];
                $this->respond($output,400);
            }
        }catch(\Exception $e){
            $output = [
                'status' => 400,
                'message' => $e->getMessage()
            ];

            $this->fail($output,400);
        }
    }

    public function put($username = NULL){

        $json = $this->request->getJSON();

        if($json){
            
        }else{

        }

        $account = $this->user->getAccount($username);
    }

    public function delete($username = NULL){
        $account = $this->user->getAccount($username);

        if($account){
            try {
                $delete = $this->user->deleteAccount($account['id']);

                if($delete){
                    $output = [
                        'status' => 200,
                        'message' => 'Account deleted'
                    ];
                    return $this->respond($output,200);
                }else{
                    $output = [
                        'status' => 400,
                        'message' => 'Something went wrong'
                    ];
                    return $this->respond($output,400);
                }
            } catch (\Exception $e) {
                $output = [
                    'status' => 400,
                    'message' => $e->getMessage()
                ];
                return $this->respond($output,400);
            }
        }else{
            $output = [
                'status' => 401,
                'message' => 'Account not found'
            ];

            return $this->respond($output,401);
        }
    }
}