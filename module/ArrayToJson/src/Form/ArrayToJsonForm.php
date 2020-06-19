<?php


namespace ArrayToJson\Form;

use Laminas\Form\Form;

/**
 * Class ArrayToJsonForm
 * @package ArrayToJson\Form
 */
class ArrayToJsonForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('array-to-json');

        $this->add([
            'name' => 'array',
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
