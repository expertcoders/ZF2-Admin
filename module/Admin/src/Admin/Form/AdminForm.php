<?php
namespace Admin\Form;

use Zend\Form\Form;

class AdminForm extends Form
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
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'form-control',
                'placeholder'=>'Username'

            ),
        ));
        
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
                'class'=>'form-control',
                'placeholder'=>'Password'

            ),
        ));


		$this->add(array(
			'type'  => 'Zend\Form\Element\Checkbox',
            'name' => 'remember_me',
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login',
                'id' => 'submitbutton',
                'class'=>'btn bg-olive btn-block'
            ),
        ));
    }
}
