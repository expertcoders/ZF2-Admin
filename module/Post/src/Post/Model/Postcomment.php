<?php namespace Post\Model;


 class Postcomment
 {
     /*public $id;
     public $title;
     public $post;
     public $status;
     public $user_id;
     public $first_name;
     public $last_name;*/

     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->post_id = (!empty($data['post_id'])) ? $data['post_id'] : null;
         $this->user_id  = (!empty($data['user_id'])) ? $data['user_id'] : null;
         $this->comment  = (!empty($data['comment'])) ? $data['comment'] : null;
         $this->created  = (!empty($data['created'])) ? $data['created'] : null;
         
     }
     
     
   // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
 }
 
 ?>
