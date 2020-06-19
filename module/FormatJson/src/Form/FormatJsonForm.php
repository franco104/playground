<?php


namespace FormatJson\Form;

use Laminas\Form\Form;

/**
 * Class FormatJsonForm
 * @package FormatJson\Form
 */
class FormatJsonForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('format-json');

        $this->add([
            'name' => 'json',
            'type' => 'text',
            'options' => [
                'label' => 'Array',
            ],
            'filters'    => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}
