<?php
namespace Changepassword\Form;

use Zend\Form\Form;

class ChangepasswordForm extends Form
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
            'name' => 'old_password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Old Password',
            ),
        ));
        $this->add(array(
            'name' => 'new_passowrd',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'New Password',
            ),
        ));
        $this->add(array(
            'name' => 'confirm_new_password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Re New Passowrd',
            ),
        ));
    }
}
