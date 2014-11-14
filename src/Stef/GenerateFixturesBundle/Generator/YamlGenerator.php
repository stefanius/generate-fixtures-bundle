<?php

namespace Stef\GenerateFixturesBundle\Generator;

use Symfony\Component\Yaml\Yaml;

class YamlGenerator extends BaseGenerator
{
    protected function writeFixtureData()
    {
        $classname = sprintf('%s\\%s',
            $this->options->get('entity_namespace'),
            $this->options->get('entity_classname')
        );

        $yamlData = Yaml::dump([$classname => $this->correctDateTimestamps($this->fixtureData)], 3, 2);

        $yamlData = str_replace("updated: '<dateTimeBetween(''", "updated: <dateTimeBetween('", $yamlData);
        $yamlData = str_replace("created: '<dateTimeBetween(''", "created: <dateTimeBetween('", $yamlData);
        $yamlData = str_replace("modified: '<dateTimeBetween(''", "modified: <dateTimeBetween('", $yamlData);
        $yamlData = str_replace("'', ''", "', '", $yamlData);
        $yamlData = str_replace("'')>'", "')>", $yamlData);

        $this->fs->dumpFile($this->options->get('output_filename'),
            $yamlData
        );
    }

    /**
     * Quick and Dirty fix for timestammed 'created' and 'update' fields. Needs more investigation for a more suiteble solution.
     */
    private function correctDateTimestamps($fixtures) {
        $manipulated = [];

        foreach ($fixtures as $key => $fixture) {
            if (array_key_exists('created', $fixture)) {
                $fixture['created'] = $this->manipulate($fixture['created']);
            }

            if (array_key_exists('updated', $fixture)) {
                $fixture['updated'] = $this->manipulate($fixture['updated']);
            }

            if (array_key_exists('modified', $fixture)) {
                $fixture['modified'] = $this->manipulate($fixture['modified']);
            }

            $manipulated[$key] = $fixture;
        }

        return $manipulated;
    }

    private function manipulate($string) {
        return "<dateTimeBetween('" . $string . "', '" . $string . "')>";
    }
}
