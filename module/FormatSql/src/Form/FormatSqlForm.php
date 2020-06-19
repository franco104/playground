<?php


namespace FormatSql\Form;

use Laminas\Form\Form;

/**
 * Class FormatSqlForm
 * @package FormatSql\Form
 */
class FormatSqlForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('format-json');

        $this->add([
            'name' => 'sql',
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
