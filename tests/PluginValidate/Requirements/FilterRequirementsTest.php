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

namespace Moodlerooms\MoodlePluginCI\Tests\PluginValidate;

use Moodlerooms\MoodlePluginCI\PluginValidate\Plugin;
use Moodlerooms\MoodlePluginCI\PluginValidate\Requirements\FilterRequirements;
use Moodlerooms\MoodlePluginCI\PluginValidate\Requirements\RequirementsResolver;

/**
 * @copyright Copyright (c) 2015 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class FilterRequirementsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FilterRequirements
     */
    private $requirements;

    protected function setUp()
    {
        $this->requirements = new FilterRequirements(new Plugin('filter_activitynames', 'filter', 'activitynames', ''), 29);
    }

    protected function tearDown()
    {
        $this->requirements = null;
    }

    public function testResolveRequirements()
    {
        $resolver = new RequirementsResolver();

        $this->assertInstanceOf(
            'Moodlerooms\MoodlePluginCI\PluginValidate\Requirements\FilterRequirements',
            $resolver->resolveRequirements(new Plugin('', 'filter', '', ''), 29)
        );
    }

    public function testGetRequiredFiles()
    {
        $files = $this->requirements->getRequiredFiles();

        $this->assertNotEmpty($files);
        $this->assertTrue(in_array('filter.php', $files));
        foreach ($files as $file) {
            $this->assertInternalType('string', $file);
        }
    }

    public function testGetRequiredClasses()
    {
        $classes = $this->requirements->getRequiredClasses();

        $this->assertNotEmpty($classes);
        foreach ($classes as $class) {
            $this->assertInstanceOf('Moodlerooms\MoodlePluginCI\PluginValidate\Finder\FileTokens', $class);
        }
    }

    public function testGetRequiredStrings()
    {
        $fileToken = $this->requirements->getRequiredStrings();
        $this->assertInstanceOf('Moodlerooms\MoodlePluginCI\PluginValidate\Finder\FileTokens', $fileToken);
        $this->assertEquals('lang/en/filter_activitynames.php', $fileToken->file);
    }
}
