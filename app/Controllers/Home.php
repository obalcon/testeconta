<?php namespace App\Controllers;
use App\Models\FerramentaModel;

class Home extends BaseController
{
	public function index()
	{
		return view('index');
	}
        
        public function teste(){
         $model = new FerramentaModel();
         $data = $model->findAll();
         var_dump($data);
         exit;
         $data ='to no ferramenta';
        }
	//--------------------------------------------------------------------

}
