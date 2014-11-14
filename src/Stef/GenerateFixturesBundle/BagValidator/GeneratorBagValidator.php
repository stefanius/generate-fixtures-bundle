<?php
/**
 * Created by PhpStorm.
 * User: stefanius
 * Date: 8/15/14
 * Time: 4:07 PM
 */

namespace Stef\GenerateFixturesBundle\BagValidator;


class GeneratorBagValidator extends BaseBagValidator
{
    /**
     * Function which initiate the
     */
    public function init()
    {
        $fields = [
            'entity_namespace',
            'entity_classname',
            'entity_bundle',
            'output_filename'
        ];

        $this->setRequiredFields($fields);
    }
} 