<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

use App\Models\Module_model;
use App\Models\User_model;
use App\Models\Media_model;

class Media extends ResourceController{
    
    public function __construct(){
        $this->module = new Module_model();
        $this->user = new User_model();
        $this->media = new Media_model();
    }

    public function profilePicture($username){
        $account = $this->user->getAccount($username);

        if(!$account){
            $output = [
                'status' => 409,
                'message' => 'Account not found'
            ];
            return $this->respond($output,409);
        }

        $profile = $this->user->getProfile($account['id']);

        $file = $this->request->getFile('profile_picture');

        if(!$file->isValid()){
            $output = [
                'status' => 400,
                'message' => 'File not valid'
            ];
            return $this->respond($output,400);
        }

        if(substr($file->getMimeType,0,5) != 'image'){
            $output = [
                'status' => 400,
                'message' => 'File not an image'
            ];
            return $this->respond($output,400);
        }

        $folder = './assets/uploads/'.$profile['media_folder'].'/'.$file->getMimeType();

        if (!is_dir($folder)){
            mkdir($folder,0777,TRUE);
        }

        try {
            
            $file_name = $file->getRandomName();
            $file->move($folder,$file_name);

            $full_path = $folder.'/'.$file_name;

            $spec = array(
                'context' => 'USER',
                'routine' => 'PROFILES',
                'field' => 'media_picture'
            );

            $module = $this->module->getCode($spec);

            $data = array(
                'name'      => $file->getClientName(),
                'module_code' => $module['code'],
                'extension' => $file->getExtension(),
                'location'  => $full_path,
                'size'      => $file->getSize('mb')
            );

            $referrer = array(
                'account_id' => $account['id']
            ); 

            if($this->media->addReference($data,$module,$referrer)){
                $output = [
                    'status' => 200,
                    'message' => 'Reference added'
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
    }
}