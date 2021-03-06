<?php
/**
 * FABIO CICERCHIA - WEBSITE
 *
 * Copyright 2012 - 2013 Fabio Cicerchia.
 *
 * Permission is hereby granted, free of  charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction,  including without limitation the rights
 * to use,  copy, modify,  merge, publish,  distribute, sublicense,  and/or sell
 * copies  of the  Software,  and to  permit  persons to  whom  the Software  is
 * furnished to do so, subject to the following conditions:
 *
 * The above  copyright notice and this  permission notice shall be  included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE  IS PROVIDED "AS IS",  WITHOUT WARRANTY OF ANY  KIND, EXPRESS OR
 * IMPLIED,  INCLUDING BUT  NOT LIMITED  TO THE  WARRANTIES OF  MERCHANTABILITY,
 * FITNESS FOR A  PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO  EVENT SHALL THE
 * AUTHORS  OR COPYRIGHT  HOLDERS  BE LIABLE  FOR ANY  CLAIM,  DAMAGES OR  OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * PHP Version 5.4
 *
 * @category   Test
 * @package    FabioCicerchia\Api
 * @subpackage ServiceAbstractTest
 * @author     Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright  2012 - 2013 Fabio Cicerchia.
 * @license    MIT <http://www.opensource.org/licenses/MIT>
 * @link       http://www.fabiocicerchia.it
 * @since      File available since Release 0.1
 */

require_once TEST_LIB_PATH . 'Api/ServiceAbstract.php';
require_once TEST_LIB_PATH . 'TestCase.php';

/**
 * The Abstract class for every Service.
 *
 * @category   Test
 * @package    FabioCicerchia\Api
 * @subpackage ServiceAbstractTest
 * @author     Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright  2012 - 2013 Fabio Cicerchia. All Rights reserved.
 * @license    TBD <http://www.fabiocicerchia.it>
 * @link       http://www.fabiocicerchia.it
 * @since      File available since Release 0.1
 */
class ServiceAbstractTest extends FabioCicerchia\TestCase
{
    // {{{ Methods - Public ====================================================
    // {{{ Method: testRunWithEmptyData ----------------------------------------
    /**
     * Test method "run" with empty data.
     *
     * ### General Information #################################################
     *
     * @since Version 0.1
     *
     * @return void
     */
    public function testRunWithEmptyData()
    {
        $stub = $this->getMockBuilder('FabioCicerchia\Api\ServiceAbstract')
                     ->setMethods(['getRawData', 'elaborateData'])
                     ->disableOriginalConstructor()
                     ->getMock();

        $stub->expects($this->any())
             ->method('getRawData')
             ->will($this->returnValue([]));

        $stub->expects($this->any())
             ->method('elaborateData')
             ->will($this->returnArgument(0));

        $stub->run();

        $this->assertEquals([], $stub->getData());
    }
    // }}} ---------------------------------------------------------------------

    // {{{ Method: testGetDataReturnCorrectValue -------------------------------
    /**
     * Test method "getData" and check if return the correct value.
     *
     * ### General Information #################################################
     *
     * @since Version 0.1
     *
     * @return void
     */
    public function testGetDataReturnCorrectValue()
    {
        $stub = $this->getMockForAbstractClass(
            'FabioCicerchia\Api\ServiceAbstract',
            [],
            '',
            false
        );

        $this->assertEquals([], $stub->getData());
        $this->assertInternalType('array', $stub->getData());
    }
    // }}} ---------------------------------------------------------------------

    // {{{ Method: testGetCollectionReturnCorrectValue -------------------------
    /**
     * Test method "getCollection" and check if return the correct value.
     *
     * ### General Information #################################################
     *
     * @since Version 0.1
     *
     * @return void
     */
    public function testGetCollectionReturnCorrectValue()
    {
        $stub = $this->getMockForAbstractClass(
            'FabioCicerchia\Api\ServiceAbstract',
            [],
            '',
            false
        );

        $this->assertEquals(null, $stub->getCollection());
    }
    // }}} ---------------------------------------------------------------------

    // {{{ Method: testGetCollectionNameReturnCorrectValue ---------------------
    /**
     * Test method "getCollectionName" and check if return the correct value.
     *
     * ### General Information #################################################
     *
     * @since Version 0.1
     *
     * @return void
     */
    public function testGetCollectionNameReturnCorrectValue()
    {
        $stub = $this->getMockForAbstractClass(
            'FabioCicerchia\Api\ServiceAbstract',
            [],
            '',
            false
        );

        $this->assertEquals(null, $stub->getCollectionName());
    }
    // }}} ---------------------------------------------------------------------
    // }}} =====================================================================
}
