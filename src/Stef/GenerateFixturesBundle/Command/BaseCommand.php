<?php

namespace Stef\GenerateFixturesBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Registry;
use JMS\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Filesystem\Filesystem;

abstract class BaseCommand extends ContainerAwareCommand
{
    /**
     * @return Serializer
     */
    protected function getJmsSerializer()
    {
        return $this->getContainer()->get('jms_serializer');
    }

    /**
     * @return Registry
     */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        $fs = new Filesystem();

        return $fs;
    }
}