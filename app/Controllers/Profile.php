<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\User_model;

class Profile extends ResourceController{
    
    public function __construct(){
        $this->user = new User_model();
    }

    public function create(){
        $json = $this->request->getJSON();

        if($json){
            $username = $json->username;

            $full_name = (empty($json->full_name)) ? NULL : $json->full_name;
            $birth_date = (empty($json->birth_date)) ? NULL : $json->birth_date;
            $gender = (empty($json->gender)) ? NULL : $json->gender;
            $religion = (empty($json->religion)) ? NULL : $json->religion;
            $job = (empty($json->job)) ? NULL : $json->job;
            $address = (empty($json->address)) ? NULL : $json->address;
            $province = (empty($json->province)) ? NULL : $json->province;
            $district = (empty($json->district)) ? NULL : $json->district;
            $sub_district = (empty($json->sub_district)) ? NULL : $json->sub_district;
            $village = (empty($json->village)) ? NULL : $json->village;
        }else{
            $username = $this->request->getPost('username');
            
            $full_name = (empty($this->request->getPost('full_name'))) ? NULL : $this->request->getPost('full_name');
            $birth_date = (empty($this->request->getPost('birth_date'))) ? NULL : $this->request->getPost('birth_date');
            $gender = (empty($this->request->getPost('gender'))) ? NULL : $this->request->getPost('gender');
            $religion = (empty($this->request->getPost('religion'))) ? NULL : $this->request->getPost('religion');
            $job = (empty($this->request->getPost('job'))) ? NULL : $this->request->getPost('job');
            $address = (empty($this->request->getPost('address'))) ? NULL : $this->request->getPost('address');
            $province = (empty($this->request->getPost('province'))) ? NULL : $this->request->getPost('province');
            $district = (empty($this->request->getPost('district'))) ? NULL : $this->request->getPost('district');
            $sub_district = (empty($this->request->getPost('sub_district'))) ? NULL : $this->request->getPost('sub_district');
            $village = (empty($this->request->getPost('village'))) ? NULL : $this->request->getPost('village');
        }

        if(empty($username)){
            $output = [
                'status' => 400,
                'message' => 'Username not supplied'
            ];

            return $this->respond($output,400);
        }

        $account = $this->user->getAccount($username);

        if($account){
            $data_profile = array(
                'account_id' => $account['id'],
                'full_name' => $full_name,
                'birth_date' => $birth_date,
                'gender' => $gender,
                'religion' => $religion,
                'job' => $job,
                'address' => $address,
                'province' => $province,
                'district' => $district,
                'sub_district' => $sub_district,
                'village' => $village,
                'media_folder' => $username
            );


            $profile = $this->user->getProfile($account['id']);

            if($profile){
                $output = [
                    'status' => 409,
                    'message' => 'User profile already exists'
                ];
                $this->respond($output,409);
            }
            
            try {
                $insert = $this->user->addProfile($data_profile);

                if($insert){
                    $output = [
                        'status' => 200,
                        'message' => 'Profile created'
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
                'status' => 400,
                'message' => 'Account not found'
            ];

            return $this->respond($output,400);
        }


    }
}