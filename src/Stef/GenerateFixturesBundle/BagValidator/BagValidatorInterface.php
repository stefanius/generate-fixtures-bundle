<?php
/**
 * Created by PhpStorm.
 * User: stefanius
 * Date: 8/15/14
 * Time: 10:39 AM
 */

namespace Stef\GenerateFixturesBundle\BagValidator;


use Symfony\Component\HttpFoundation\ParameterBag;

interface BagValidatorInterface
{
    /**
     * @param ParameterBag $bag
     * @return bool
     */
    public function validate(ParameterBag $bag);

    /**
     * @param array $fields
     */
    public function setRequiredFields(array $fields);

    /**
     * @return array $fields
     */
    public function getMissingFields();

    /**
     * Function which initiate the
     */
    public function init();
} 