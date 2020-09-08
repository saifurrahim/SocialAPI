<?php namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
 
class Home extends ResourceController
{
 
    public function __construct()
    {
        // 
    }
 
    public function index()
    {

		return $this->respond(['Hello','World'],200);
    }

    public function testPost(){

      $post = $this->request->getPost();

      $data = array(
        'status' => 200,
        'message' => $post
      );
      
      return $this->respond($data,200);
    }
 
}