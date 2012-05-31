<?php
/**
 * FABIO CICERCHIA - WEBSITE
 *
 * PHP Version 5.4

 * @category   API
 * @package    FabioCicerchia\Api\Service
 * @subpackage Language
 * @author     Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright  2012 Fabio Cicerchia. All Rights reserved.
 * @license    TBD <http://www.fabiocicerchia.it>
 * @link       http://www.fabiocicerchia.it
 * @version    XXX
 */

namespace FabioCicerchia\Api\Service;

use FabioCicerchia\Api;

/**
 * TODO: Message
 *
 * @category   API
 * @package    FabioCicerchia\Api\Service
 * @subpackage Language
 * @author     Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright  2012 Fabio Cicerchia. All Rights reserved.
 * @license    TBD <http://www.fabiocicerchia.it>
 * @link       http://www.fabiocicerchia.it
 * @version    XXX
 */
class Language extends \FabioCicerchia\Api\ServiceAbstract
{
    // {{{ PROPERTIES
    /**
     * @var string $collection_name TODO: Message
     */
    protected $collection_name = 'language';
    // }}}

    // {{{ execDataQuery
    /**
     * TODO: Message
     *
     * @internal
     * @return <Type> TODO: Message
     * @see    http://example.com/my/bar Documentation of Foo.
     * @see    FabioCicerchia\Api\ServiceAbstract::getCollection() TODO: Message
     */
    protected function execDataQuery()
    {
        return $this->getCollection()->find()->sort(array('date.end' => 'desc'));
    }
    // }}}

    // {{{ postElaborateData
    /**
     * TODO: Message
     *
     * @internal
     * @return void
     */
    protected function postElaborateData()
    {
        $this->data = ['entities' => $this->data];
    }
    // }}}
}