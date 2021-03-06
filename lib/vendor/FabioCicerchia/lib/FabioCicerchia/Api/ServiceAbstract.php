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
 * @category   Code
 * @package    FabioCicerchia\Api
 * @subpackage ServiceAbstract
 * @author     Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright  2012 - 2013 Fabio Cicerchia.
 * @license    MIT <http://www.opensource.org/licenses/MIT>
 * @link       http://www.fabiocicerchia.it
 * @since      File available since Release 0.1
 */

namespace FabioCicerchia\Api;

/**
 * The Abstract class for every Service.
 *
 * @category   Code
 * @package    FabioCicerchia\Api
 * @subpackage ServiceAbstract
 * @author     Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright  2012 - 2013 Fabio Cicerchia. All Rights reserved.
 * @license    MIT <http://www.opensource.org/licenses/MIT>
 * @link       http://www.fabiocicerchia.it
 * @since      File available since Release 0.1
 */
abstract class ServiceAbstract
{
    // {{{ Properties - Private ================================================
    /**
     * The Collection Handle.
     *
     * @var Doctrine\MongoDB\Collection
     */
    private $collection = null;
    // }}} =====================================================================

    // {{{ Properties - Protected ==============================================
    /**
     * The name of the collection.
     *
     * @var string
     */
    protected $collectionName = null;

    /**
     * The data.
     *
     * @var array
     */
    protected $data = [];
    // }}} =====================================================================

    // {{{ Methods - Public ====================================================
    // {{{ Method: getCollection -----------------------------------------------
    /**
     * Getter for $collection.
     *
     * ### General Information #################################################
     *
     * @see   FabioCicerchia\Api\ServiceAbstract::$collection The Collection Handle.
     * @since Version 0.1
     *
     * @return Doctrine\MongoDB\Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }
    // }}} ---------------------------------------------------------------------

    // {{{ Method: getCollectionName -------------------------------------------
    /**
     * Getter for $collectionName.
     *
     * ### General Information #################################################
     *
     * @see   FabioCicerchia\Api\ServiceAbstract::$collectionName The name of the collection.
     * @since Version 0.1
     *
     * @return string
     */
    public function getCollectionName()
    {
        return $this->collectionName;
    }
    // }}} ---------------------------------------------------------------------

    // {{{ Methods: getData ----------------------------------------------------
    /**
     * Getter for $data.
     *
     * ### General Information #################################################
     *
     * @see   FabioCicerchia\Api\ServiceAbstract::$data The data.
     * @since Version 0.1
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
    // }}} ---------------------------------------------------------------------

    // {{{ Method: run ---------------------------------------------------------
    /**
     * Launch the main task.
     *
     * ### General Information #################################################
     *
     * @see   FabioCicerchia\Api\ServiceAbstract::getRawData()    Retrieve data from the collection and manipulate it.
     * @see   FabioCicerchia\Api\ServiceAbstract::elaborateData() Modify if needed the data.
     * @see   FabioCicerchia\Api\ServiceAbstract::$data           The data.
     * @since Version 0.1
     *
     * @return void
     */
    public function run()
    {
        $data = $this->getRawData();

        $this->data = $this->elaborateData($data);
    }
    // }}} ---------------------------------------------------------------------
    // }}} =====================================================================

    // {{{ Method: elaborateData -----------------------------------------------
    /**
     * Modify if needed the data.
     *
     * ### General Information #################################################
     *
     * @param array $data The data.
     *
     * @since Version 0.1
     *
     * @return array
     */
    protected function elaborateData(array $data)
    {
        return $data;
    }
    // }}} ---------------------------------------------------------------------

    // {{{ Method: getRawData --------------------------------------------------
    /**
     * Retrieve the data from the collection and manipulate it.
     *
     * ### General Information #################################################
     *
     * @see   FabioCicerchia\Api\ServiceAbstract::execDataQuery() Retrieve all the documents from a collection.
     * @since Version 0.1
     *
     * @return array
     */
    protected function getRawData()
    {
        $data = $this->execDataQuery();

        return $data;
    }
    // }}} ---------------------------------------------------------------------

    // {{{ Method: execDataQuery -----------------------------------------------
    /**
     * Retrieve all the documents from a collection.
     *
     * ### General Information #################################################
     *
     * @link  https://github.com/doctrine/mongodb/blob/master/lib/Doctrine/MongoDB/Cursor.php
     * @see   FabioCicerchia\Api\ServiceAbstract::$collection The Collection Handle.
     * @since Version 0.1
     *
     * @return array
     */
    protected function execDataQuery()
    {
        return $this->collection->find()->toArray();
    }
    // }}} ---------------------------------------------------------------------

    // {{{ Method: setDatabase -------------------------------------------------
    /**
     * Executed to set up the database handle.
     *
     * ### General Information #################################################
     *
     * @param \Doctrine\MongoDB\Database $db_handle The Database Handle.
     *
     * @link  https://github.com/doctrine/mongodb/blob/master/lib/Doctrine/MongoDB/Database.php
     * @see   Doctrine\MongoDB\Database::selectCollection()
     * @see   FabioCicerchia\Api\ServiceAbstract::getCollectionName() Getter for $collectionName.
     * @since Version 0.1
     *
     * @return void
     */
    protected function setDatabase(\Doctrine\MongoDB\Database $db_handle)
    {
        $this->collection = $db_handle->selectCollection($this->getCollectionName());
    }
    // }}} ---------------------------------------------------------------------
    // }}} =====================================================================

    // {{{ Methods - Special ===================================================
    // {{{ Method: __construct -------------------------------------------------
    /**
     * The constructor.
     *
     * ### General Information #################################################
     *
     * @param \Doctrine\MongoDB\Database $db_handle The Database Handle.
     *
     * @see   FabioCicerchia\Api\ServiceAbstract::setDatabase() Executed to set up the database handle.
     * @see   FabioCicerchia\Api\ServiceAbstract::run()         Launch the main task.
     * @since Version 0.1
     *
     * @return void
     */
    public function __construct(\Doctrine\MongoDB\Database $db_handle)
    {
        $this->setDatabase($db_handle);
        $this->run();
    }
    // }}} ---------------------------------------------------------------------
    // }}} =====================================================================
}
