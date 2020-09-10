<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\User_model;

use Firebase\JWT\JWT;
use Config\Services;

class Account extends ResourceController{

    public function __construct()
    {
        $this->user = new User_model();
    }

    public function login()
    {
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

    public function register()
    {

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
                return $this->respond($output,200);
            }else{
                $output = [
                    'status' => 400,
                    'message' => 'Something went wrong'
                ];
                return $this->respond($output,400);
            }
        }catch(\Exception $e){
            $output = [
                'status' => 400,
                'message' => $e->getMessage()
            ];

            return $this->respond($output,400);
        }
    }

    public function change($username)
    {

        $json = $this->request->getJSON();

        if($json){
            $new_username = $json->username;
            $new_password = $json->password;
        }else{
            $new_username = $this->request->getPost('username');
            $new_password = $this->request->getPost('password');
        }

        $account = $this->user->getAccount($username);

        if($account){

            $data = array(
                'username' => $new_username,
                'password' => $new_password
            );
            try {

                $update = $this->user->updateAccount($data,$account['id']);

                if($update){
                    $output = [
                        'status' => 200,
                        'message' => 'Account updated'
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
                'status' => 409,
                'message' => 'Account not found'
            ];
            return $this->respond($output,409);
        }
    }

    public function block($username){
        
        $account = $this->user->getAccount($username);

        if($account){
            try {
                $block = $this->user->blockAccount($account['id']);

                if($block){
                    $output = [
                        'status' => 200,
                        'message' => 'Account blocked'
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

    public function unblock($username){
        
        $account = $this->user->getAccount($username);

        if($account){
            try {
                $unblock = $this->user->unblockAccount($account['id']);

                if($unblock){
                    $output = [
                        'status' => 200,
                        'message' => 'Account unblocked'
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

    public function suggest(){
        $json = $this->request->getJSON();

        if($json){
            $full_name = $json->full_name;
        }else{
            $full_name = $this->request->getPost('full_name');
        }

        $names = explode(" ",strtolower($full_name));

        $suggestion = 5;
        $generated = 0;

        $i = 0;
        $usernames = array();

        try {
            while($generated < $suggestion){
                if($i === 0){
                    $username = $names[0];
                    $account = $this->user->getAccount($username);
    
                    if(!$account && !in_array($username,$usernames)){
                        $usernames[$generated] = $username;
                        $generated++;
                    }
                }elseif($i === 1){
                    $username = $names[0].'.'.end($names);
                    $account = $this->user->getAccount($username);
    
                    if(!$account && !in_array($username,$usernames)){
                        $usernames[$generated] = $username;
                        $generated++;
                    }
                }elseif($i === 2){
                    $username = $names[0].substr(end($names),0,2);
                    $account = $this->user->getAccount($username);
    
                    if(!$account && !in_array($username,$usernames)){
                        $usernames[$generated] = $username;
                        $generated++;
                    }
                }elseif($i === 3){
                    $username = end($names).'_'.substr($names[0],0,2);
                    $account = $this->user->getAccount($username);
    
                    if(!$account && !in_array($username,$usernames)){
                        $usernames[$generated] = $username;
                        $generated++;
                    }
                }else{
                    $available = false;
    
                    while(!$available){
                        $username = $names[0].mt_rand(0,1000);
                        $account = $this->user->getAccount($username);
    
                        if(!$account && !in_array($username,$usernames)){
                            $usernames[$generated] = $username;
                            $generated++;
                            $available = true;
                        }
                    }
                }
                $i++;
            }
        // end loop

            $output = [
                'status' => 200,
                'data' => $usernames
            ];
            return $this->respond($output,200);

        } catch (\Exception $e) {
            $output = [
                'status' => 400,
                'message' => $e->getMessage()
            ];
        }
    }
}