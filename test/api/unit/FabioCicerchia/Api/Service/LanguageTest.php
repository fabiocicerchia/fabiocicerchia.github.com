<?php
/**
 * FABIO CICERCHIA - WEBSITE
 *
 * PHP Version 5.4
 *
 * @category   Test
 * @package    FabioCicerchia\Api\Service
 * @subpackage LanguageTest
 * @author     Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright  2012 Fabio Cicerchia. All Rights reserved.
 * @license    TBD <http://www.fabiocicerchia.it>
 * @link       http://www.fabiocicerchia.it
 */

require_once __DIR__ . '/../../../../../../lib/vendor/FabioCicerchia/lib/FabioCicerchia/Api/ServiceAbstract.php';
require_once __DIR__ . '/../../../../../../lib/vendor/FabioCicerchia/lib/FabioCicerchia/Api/Service/Language.php';

/**
 * The Language Test Class.
 *
 * @category   Test
 * @package    FabioCicerchia\Api\Service
 * @subpackage LanguageTest
 * @author     Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright  2012 Fabio Cicerchia. All Rights reserved.
 * @license    TBD <http://www.fabiocicerchia.it>
 * @link       http://www.fabiocicerchia.it
 */
class LanguageTest extends PHPUnit_Framework_TestCase
{
    // {{{ testRunEmptyData
    /**
     * Test method "run" with empty data.
     *
     * @return void
     */
    public function testRunEmptyData()
    {
        $stub = $this->getMockBuilder('FabioCicerchia\Api\Service\Language')
                     ->setMethods(['execDataQuery'])
                     ->disableOriginalConstructor()
                     ->getMock();

        $stub->expects($this->any())
             ->method('execDataQuery')
             ->will($this->returnValue([]));

        $stub->run();

        $this->assertArrayHasKey('entities', $stub->getData());
    }
    // }}}
}
