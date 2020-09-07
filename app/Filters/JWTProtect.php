<?php namespace App\Filters;

use Firebase\JWT\JWT;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use Config\Services;

class JWTProtect implements FilterInterface{

    public function before(RequestInterface $request){

        $key = Services::privateKey();

        $header = $request->getServer('HTTP_AUTHORIZATION');

        if(!$header){

            $output = [
                'status' => 401,
                'message' => 'Unauthorized'
            ];

            return Services::response()
                ->setStatusCode(401)
                ->setJSON($output);

        }

        $headers = explode(' ',$header);

        $token = $headers[1];

        if($token){
            
            try{

                $decoded = JWT::decode($token,$key,array('HS256'));

                if($decoded){
                    return;
                }

            }catch(\Exception $e){
                
                $output = [
                    'status' => 401,
                    'message' => $e->getMessage()
                ];
    
                return Services::response()
                    ->setStatusCode(401)
                    ->setJSON($output);
                    }

        }

    }

    public function after(RequestInterface $request, ResponseInterface $response){
        // 
    }
}