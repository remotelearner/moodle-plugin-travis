<?php

/*
 * This file is part of the Moodle Plugin CI package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) 2015 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moodlerooms\MoodlePluginCI\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Run Behat tests.
 *
 * @copyright Copyright (c) 2015 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class BehatCommand extends AbstractMoodleCommand
{
    use ExecuteTrait;

    protected function configure()
    {
        parent::configure();

        $this->setName('behat')
            ->setDescription('Run Behat on a plugin');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->initializeExecute($output, $this->getHelper('process'));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->outputHeading($output, 'Behat features for %s');

        if (!$this->plugin->hasBehatFeatures()) {
            return $this->outputSkip($output, 'No Behat features to run, free pass!');
        }

        $colors = $this->moodle->getBranch() >= 31 ? '--colors' : '--ansi';
        $config = $this->moodle->getBehatDataDirectory().'/behat/behat.yml';
        if (!file_exists($config)) {
            throw new \RuntimeException('Behat config file not found.  Behat must not have been installed.');
        }

        $process = $this->execute->passThrough(
            sprintf('%s/vendor/bin/behat %s --config %s --tags @%s', $this->moodle->directory, $colors, $config, $this->plugin->getComponent()),
            $this->moodle->directory
        );

        return $process->isSuccessful() ? 0 : 1;
    }
}
