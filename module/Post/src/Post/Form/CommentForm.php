<?php
namespace Post\Form;

use Zend\Form\Form;

class CommentForm extends Form
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
            'name' => 'postcomment',
            'attributes' => array(
                //'type'  => 'Zend\Form\Element\Textarea',
                'type'  => 'text',
                'class'=>'form-control',
                'id'=>'postcomment',
                'required'=>true,
                'onKeyPress'=>"return checkSubmit(event)",
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
