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
                'type'  => 'Zend\Form\Element\Textarea',
                'class'=>'form-control',
                'required'=>true
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
    
    /*
     * $form   = new My\Form();
$select = $form->get('selectCountries');

$model    = new My\Countries();
$listData = $model->getCountriesAsArray();

$select->setValueOptions($listData);
     * 
     * 
     * 
     */
}
