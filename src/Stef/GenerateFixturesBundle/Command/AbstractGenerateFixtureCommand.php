<?php

namespace Stef\GenerateFixturesBundle\Command;

use Doctrine\ORM\Query;
use Stef\GenerateFixturesBundle\BagValidator\GeneratorBagValidator;
use Stef\GenerateFixturesBundle\Generator\YamlGenerator;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class AbstractGenerateFixtureCommand extends BaseCommand
{
    /**
     * @var ParameterBag
     */
    protected $generatorSettings;

    protected function generate()
    {
        $today = new \DateTime('now');

        $doctrine = $this->getDoctrine();
        $serializer = $this->getJmsSerializer();
        $fs = $this->getFilesystem();

        if (!$this->generatorSettings->has('output_filename')) {
            $this->generatorSettings->set('output_filename', sprintf('yaml-fixture-%s-%s.yml',
                $today->format('Y-m-d'),
                $this->generatorSettings->get('entity_classname')
            ));
        }

        $generator = new YamlGenerator($doctrine, $serializer, $fs, $this->generatorSettings, new GeneratorBagValidator());

        $generator->execute();
    }
}