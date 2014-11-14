<?php

namespace Stef\GenerateFixturesBundle\Command;

use Doctrine\ORM\Query;
use Symfony\Component\Console\Input\InputOption;

class GenerateFixtureCommand extends AbstractGenerateFixtureCommand
{
    protected function configure()
    {
        $this->setName('stef:fixture:generate');

        $this->addOption(
            'es',
            null,
            InputOption::VALUE_REQUIRED,
            'The entity namespace (without the classname!) i.e. Stef\BVBundle\Entity'
        );

        $this->addOption(
            'es',
            null,
            InputOption::VALUE_REQUIRED,
            'The entity classname i.e. Blog'
        );

        $this->addOption(
            'eb',
            null,
            InputOption::VALUE_REQUIRED,
            'The entity bundle (shortcut) i.e. StefBVBundle'
        );
    }
}