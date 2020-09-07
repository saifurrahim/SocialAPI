<?php namespace App\Controllers;
 
use \Firebase\JWT\JWT;
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
 
}