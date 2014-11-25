<?php namespace Post\Model;


 class Post
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
         $this->post = (!empty($data['post'])) ? $data['post'] : null;
         $this->title  = (!empty($data['title'])) ? $data['title'] : null;
         $this->status  = (!empty($data['status'])) ? $data['status'] : 0;
         $this->user_id  = (!empty($data['user_id'])) ? $data['user_id'] : null;
         $this->first_name  = (!empty($data['first_name'])) ? $data['first_name'] : null;
         $this->last_name  = (!empty($data['last_name'])) ? $data['last_name'] : null;
         $this->created  = (!empty($data['created'])) ? $data['created'] : null;
         
     }
     
     
   // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
 }
 
 ?>
