<?php namespace App\Models;
  
use CodeIgniter\Model;

class TagsModel extends Model
{
    protected $table = 'Tags';
    protected $primaryKey = 'id_tag';
    protected $allowedFields = ['tag','id_ferra'];
    
}


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

