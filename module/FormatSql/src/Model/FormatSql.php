<?php

namespace FormatSql\Model;

use Laminas\Filter\Exception\DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

/**
 * Class FormatSql
 * @package FormatSql\Model
 */
class FormatSql implements InputFilterAwareInterface
{
    public $sql;

    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->sql = !empty($data['sql']) ? $data['sql'] : null;
    }

    /**
     * @param InputFilterInterface $inputFilter
     * @return InputFilterAwareInterface|void
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'sql',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 4,
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}
