<?php
namespace Post\Form;

use Zend\Form\Form;

class PostForm extends Form
{
    public function __construct($title = null)
    {
        // we want to ignore the name passed
        parent::__construct('post');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'form-control',
                'required'=>true
            ),
        ));
        $this->add(array(
            'name' => 'post',
            'attributes' => array(
                //'type'  => 'Zend\Form\Element\Textarea',
                'type'  => 'textarea',
                'rows'=>'15',
                'class'=>'form-control',
                'required'=>true
            ),
        ));
        
         $this->add(array(
            'name' => 'images',
            'attributes' => array(
                //'type'  => 'Zend\Form\Element\Textarea',
                'type'  => 'file',
                'required'=>false
            ),
        ));
        
         $this->add(array(     
        'type' => 'Zend\Form\Element\Select',       
        'name' => 'status',
        'attributes' =>  array(
            'id' => 'status',  
            'multiple' => false,               
            'class'=>'form-control',
            'options' => array('0'=>'Published','1'=>'Un Published'),
        ),
        ));  

        $this->add(array(
            'name' => 'Cancel',
            'attributes' => array(
                'type'  => 'button',
                'value' => 'Cancel',
                'onclick'=>'javascript:window.history.back()'
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
 
}
