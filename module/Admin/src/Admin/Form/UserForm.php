<?php
namespace Admin\Form;

use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('user');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'first_name',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'last_name',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'form-control',
            ),
        ));
        $this->add(array(
            'name' => 'email_address',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'form-control',
            ),
        ));
        
         $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'form-control',
            ),
            'options' => array(
                'label' => ' Username ',
            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => ' Password ',
            ),
        ));
        
        
          $this->add(array(
            'name' => 'old_password',
            'attributes' => array(
                'type'  => 'password',
                'class'=>'form-control',
       

            ),
        ));
        $this->add(array(
            'name' => 'new_passowrd',
            'attributes' => array(
                'type'  => 'password',
                'class'=>'form-control',
       
            ),
        ));
        $this->add(array(
            'name' => 'confirm_new_password',
            'attributes' => array(
                'type'  => 'password',
                'class'=>'form-control',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class'=>'btn btn-primary'
            ),
        ));
        
         $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type'  => 'button',
                'value' => 'Cancel',
                'id' => 'submitbutton',
                'class'=>'btn btn-danger'
            ),
        ));
         
        $this->add(array(     
        'type' => 'Zend\Form\Element\Select',       
        'name' => 'status',
        'attributes' =>  array(
            'id' => 'status',  
            'multiple' => false,               
            'class'=>'form-control',
            'options' => array('0'=>'Active','1'=>'InActive'),
        ),
        ));  
    }
}
