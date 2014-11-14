<?php

namespace Stef\GenerateFixturesBundle\BagValidator;

use Symfony\Component\HttpFoundation\ParameterBag;

abstract class BaseBagValidator implements BagValidatorInterface
{
    /**
     * @var array
     */
    protected $fields;

    /**
     * @var array
     */
    protected $missingFields = [];

    function __construct()
    {
        $this->init();
    }

    /**
     * @param ParameterBag $bag
     * @return bool
     */
    public function validate(ParameterBag $bag)
    {
        $result = true;

        foreach ($this->fields as $field) {
            if (!$bag->has($field)) {
                $this->missingFields[] = $field;
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @param array $fields
     */
    public function setRequiredFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return array
     */
    public function getMissingFields()
    {
        return $this->missingFields;
    }
} 