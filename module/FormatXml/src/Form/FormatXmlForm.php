<?php

namespace FormatXml\Form;

use Laminas\Form\Form;

/**
 * Class FormatXmlForm
 * @package FormatXml\Form
 */
class FormatXmlForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('format-xml');

        $this->add([
            'name' => 'xml',
            'type' => 'text',
            'options' => [
                'label' => 'Array',
            ],
            'filters'    => [
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
