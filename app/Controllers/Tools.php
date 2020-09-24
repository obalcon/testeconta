<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ToolsModel;
use App\Models\TagsModel;





class Tools extends ResourceController
{
    use ResponseTrait;


    // listar todas as ferrametasa
    public function index()
    {  $request = service('request');

        $tag = $request->getGet('tag');


        if(!isset($tag)){
            $data = $this->getTodos();
        }else{
             $data = $this->getByTag($tag);
        }

        return  $this->respond($data);

    }
    private function getTodos()
    {
         $model = new ToolsModel();
         $data = $model->findAll();
         $todos = array();

         foreach ($data as $row){
            $ttags = array();
            $model = new TagsModel();
            $tags = $model->getWhere(['id_ferra' => $row['id']])->getResult();
             foreach($tags as $t){
                $unotags = $t->tag;
                array_push($ttags,$unotags);
                $unotags =null;
             }
             $uno = array();
             $uno = array('id'=>$row['id'],
                          'title'=>$row['title'],
                          'link'=>$row['link'],
                          'description' => $row['description'],
                          'tags'=>$ttags);
            array_push($todos,$uno);
         }
        return  $todos;
    }
    private function getByTag($tag){

         $model = new TagsModel();
         $ids = $model->getWhere(['tag' => $tag ])->getResult();

         $todos = array();

         foreach ($ids as $row){
            $ttags = array();
            $model = new TagsModel();
            $tags = $model->getWhere(['id_ferra' => $row->id_ferra])->getResult();
             foreach($tags as $t){
                $unotags = $t->tag;
                array_push($ttags,$unotags);
                $unotags =null;
             }

             $model = new ToolsModel();
             $ferra = $model->getWhere(['id' => $row->id_ferra])->getRow();
             $uno = array();

             $uno = array('id'=>$ferra->id,
                          'title'=>$ferra->title,
                          'link'=>$ferra->link,
                          'description' => $ferra->description,
                          'tags'=>$ttags);
            array_push($todos,$uno);
         }
        return  $todos;
    }

    // listar somente uma ferramenta
    public function show($id = null)
    {
        $model = new ToolsModel();
        $data = $model->getWhere(['id' => $id])->getRow();
        $ttags = array();
        if($data){
           $modelt = new TagsModel();
           $tags = $modelt->getWhere(['id_ferra' => $data->id])->getResult();
          // var_dump($tags);
           foreach($tags as $t){
             $unotags = $t->tag;
              array_push($ttags,$unotags);
              $unotags =null;
           }
        //   var_dump($ttags);
           $resultado = array('id'=>$data->id,
                        'title'=>$data->title,
                        'link'=>$data->link,
                        'description' => $data->description,
                        'tags'=>$ttags);

            return $this->respond($resultado);
        }else{
            return $this->failNotFound('Ferramenta não encontrada'.$id);
        }
    }

    // criar uma Ferramenta
    public function create()
    {
        $modelt = new TagsModel();
        $model = new ToolsModel();
        $data = [
            'title' => $this->request->getVar('title'),
            'link' => $this->request->getVar('link'),
            'description' => $this->request->getVar('description')
        ];

        $idinsert = $model->insert($data,true);
        $tags = $this->request->getVar('tags');

        if(isset($tags)){
             $datat = explode(',', $this->request->getVar('tags'));

             foreach($datat as $t){

                 $datatag = [ 'tag'=> $t,
                              'id_ferra'=> $idinsert];
                 $modelt->insert($datatag, false);
             }
        }
        if(isset($idinsert)){

        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];
        }else{
         $response = [
            'status'   => 400,
            'error'    => 'Bad Request',
            'messages' => [
                'error' => 'Não foi salvo'
            ]
        ];
        }
        return $this->respondCreated($response);
    }

    // Alterar uma ferramenta
    public function update($id = null)
    {
        $model = new ToolsModel();
        $input = $this->request->getRawInput();
        $tool = $model->find($id);

        if(!$tool){
            $response = [
                'status'   => 400,
                'error'    => 'Bad Request',
                'messages' => [
                              'success' => 'Dados não atualizados'
                ]
            ];
            return $this->respond($response);
        }
        $data = [
            'title' => $input['title'],
            'link' => $input['link'],
            'description' => $input['description']
        ];
        $model->update($id, $data);

        if((isset($input['tags'])) && ($input['tags'] != '')){

          $tags = explode(',', $input['tags']);

          $modelt = new TagsModel();
          $modelt->where('id_ferra', $id)->delete();
          foreach ($tags as $t ) {
            $datatag = [ 'tag'=> $t,
                         'id_ferra'=> $id];
            $modelt->insert($datatag, false);
          }
        }

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
            'success' => 'Dados atualizados'
            ]
        ];
        return $this->respond($response);


    }

    // Deletar uma ferramenta
    public function delete($id = null)
    {
        $modelt = new TagsModel();
        $model = new ToolsModel();
        $data = $model->find($id);
        if($data){

            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Ferramenta Delatada'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('Ferramenta não encontrada '.$id);
        }

    }

}
