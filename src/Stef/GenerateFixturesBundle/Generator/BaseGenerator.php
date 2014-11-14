<?php

namespace Stef\GenerateFixturesBundle\Generator;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Inflector\Inflector;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Stef\GenerateFixturesBundle\BagValidator\BagValidatorInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\ParameterBag;

abstract class BaseGenerator implements TypeGeneratorInterface
{
    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var ParameterBag
     */
    protected $options;

    /**
     * @var BagValidatorInterface
     */
    protected $optionsBagValidator;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $fixtureData;

    /**
     * @var Filesystem
     */
    protected $fs;

    /**
     * @param Registry $doctrine
     * @param Serializer $serializer
     * @param Filesystem $fs
     * @param ParameterBag $options
     * @param BagValidatorInterface $optionsBagValidator
     *
     * @throws \Exception
     */
    function __construct(Registry $doctrine,
                         Serializer $serializer,
                         Filesystem $fs,
                         ParameterBag $options,
                         BagValidatorInterface $optionsBagValidator
    )
    {
        $this->doctrine = $doctrine;
        $this->options = $options;
        $this->serializer = $serializer;
        $this->optionsBagValidator = $optionsBagValidator;
        $this->fs = $fs;

        if (!$this->optionsBagValidator->validate($this->options)) {
            throw new \Exception('Error! Missing fields: ' . implode(',', $this->optionsBagValidator->getMissingFields()));
        }
    }

    public function execute()
    {
        $this->loadData();
        $this->prepareFixtureData();
        $this->writeFixtureData();
    }

    protected function loadData()
    {
        $em = $this->doctrine->getManager()->getRepository($this->options->get('entity_bundle') . ':' . $this->options->get('entity_classname'));
        $this->data = $em->findAll();
    }

    protected function prepareFixtureData()
    {
        $fixtures = [];

        foreach ($this->data as $entity) {
            $context = new SerializationContext();
            $context->enableMaxDepthChecks();

            $json  = $this->serializer->serialize($entity, 'json', $context);
            $serializedData = json_decode($json, true);

            $camelized = [];

            foreach ($serializedData as $key => $value) {
                $camelized[Inflector::camelize($key)] = $value;
            }

            $fixture = array_filter($camelized);

            $fixtures[sprintf('%s-%s-%d',
                $this->options->get('entity_bundle'),
                $this->options->get('entity_classname'),
                $entity->getId())
            ] = $fixture;
        }

        $this->fixtureData = $fixtures;
    }

    abstract protected function writeFixtureData();
}