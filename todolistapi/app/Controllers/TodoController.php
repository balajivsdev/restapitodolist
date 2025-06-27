<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Todo;

class TodoController extends BaseController
{
    public function index()
    {
        $todomodel = new Todo();
        $token = $this->getAuthuser();

        if(!$token)
        {
            return $this->response->setJson(['error'=>'Unauthorized'])->setStatusCode(401);
        }else{
            return $this->response->setJson($todomodel->findAll())->setStatusCode(200);
        }
    }

    public function create(){

        $todomodel = new Todo();
        $token = $this->getAuthuser();

        if(!$token)
        {
            return $this->response->setJson(['error'=>'Unauthorized'])->setStatusCode(401);
        }

        $data = $this->request->getPost();

        if(!$data['title'] || !$data['description'])
        {
            return $this->response->setJson(['error'=>'invalid field values'])->setStatusCode(401);
        }
        $inserted_data = $todomodel->insert($data);

        if($inserted_data){
            return $this->response->setJson(['success'=>'Todo created successfully'])->setStatusCode(200);
        }else{
            return $this->response->setJson(['error'=>'Something went wrong!'])->setStatusCode(500);
        }
    }

    public function update($id){

         $todomodel = new Todo();
        $token = $this->getAuthuser();

        if(!$token)
        {
            return $this->response->setJson(['error'=>'Unauthorized'])->setStatusCode(401);
        }

        $dataupdate= array(
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description')
        );

        $check_data =  $todomodel->where('id',$id)->first();

        if(empty($check_data))
        {
                return $this->response->setJson(['error'=>'Id not found!'])->setStatusCode(404);
        }
        if($todomodel->update($id,$dataupdate)){
             return $this->response->setJson(['success'=>'Todo updated successfully'])->setStatusCode(200);
        }else{
            return $this->response->setJson(['error'=>'Something went wrong!'])->setStatusCode(500);
        }


    }

    public function delete($id){
          $todomodel = new Todo();
        $token = $this->getAuthuser();

        if(!$token)
        {
            return $this->response->setJson(['error'=>'Unauthorized'])->setStatusCode(401);
        }

       $check_data =  $todomodel->where('id',$id)->first();

       if(empty($check_data))
       {
            return $this->response->setJson(['error'=>'Id not found!'])->setStatusCode(404);
       }

        if($todomodel->delete($id)){
             return $this->response->setJson(['success'=>'Todo deleted successfully'])->setStatusCode(200);
        }else{
            return $this->response->setJson(['error'=>'Something went wrong!'])->setStatusCode(500);
        }
    }

    public function show($id){
         $todomodel = new Todo();
        $token = $this->getAuthuser();

        if(!$token)
        {
            return $this->response->setJson(['error'=>'Unauthorized'])->setStatusCode(401);
        }

       $check_data =  $todomodel->where('id',$id)->first();

       if(empty($check_data))
       {
            return $this->response->setJson(['error'=>'Id not found!'])->setStatusCode(404);
       }

    return $this->response->setJson(['data'=>$check_data])->setStatusCode(200);

    }
}
