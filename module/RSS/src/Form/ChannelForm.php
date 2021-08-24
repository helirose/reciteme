<?php

namespace RSS\Form;

use Laminas\Form\Form;

class ChannelForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('rss');

        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Feed name: ',
            ],
        ]);

        $this->add([
            'name' => 'link',
            'type' => 'text',
            'options' => [
                'label' => 'Link',
            ],
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Add',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}