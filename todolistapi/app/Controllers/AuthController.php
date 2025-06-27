<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User;
use \Firebase\JWT\JWT;

class AuthController extends BaseController
{
    public function register()
    {
        $usermodel = new User();
        $data = $this->request->getPost();

        // print_r($data);
        // print_r($data['email']);
        // print_r($this->request->getMethod());
        if(!$data['email'] || !$data['password'])
        {
            // return json_encode(array('status'=>'error','data'=>'something went wrong!'));
            return $this->response->setJson(['error'=>'invalid field values'])->setStatusCode(401);
        }
    

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $check_email = $usermodel->where('email',$data['email']);
        if(!empty($check_email))
        {
            return $this->response->setJson(['error'=>'Email alredy exists!'])->setStatusCode(200);
        }
        $insert_data = $usermodel->insert($data);
        if($insert_data)
        {
            return $this->response->setJson(['success'=>'Data registerd successfully'])->setStatusCode(200);
        }
        else{
            return $this->response->setJson(['error'=>'Something went wrong!'])->setStatusCode(500);
        }

        
    }

    public function login()
    {
        $data = $this->request->getPost();

        // print_r($data);

        if(!$data['email'] || !$data['password'])
        {
            return $this->response->setJson(['error'=>'invalid field values'])->setStatusCode(401);
        }

        $usermodel = new User();

        $check_user = $usermodel->where('email',$data['email'])->first();

        if(empty($check_user))
        {
            return $this->response->setJson(['error'=>"user doesn't exists"])->setStatusCode(200);
        }

        if($check_user && !password_verify($data['password'],$check_user['password']))
        {
            return $this->response->setJson(['error'=>'invalid Credentials'])->setStatusCode(200);
        }


        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 36000;
  
        $payload = array(
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "email" => $check_user['email'],
        );
          
        $token = JWT::encode($payload, $key, 'HS256');
  
        $response = [
            'message' => 'Login Succesful',
            'token' => $token
        ];
          
        // return $this->respond($response, 200);

        return $this->response->setJson($response)->setStatusCode(200);


    }
}
