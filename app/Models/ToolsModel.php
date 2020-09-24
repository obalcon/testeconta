<?php namespace App\Models;

use CodeIgniter\Model;

class ToolsModel extends Model
{
    protected $table = 'Ferramenta';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title','link','description'];
    protected $with = 'tags';



}
