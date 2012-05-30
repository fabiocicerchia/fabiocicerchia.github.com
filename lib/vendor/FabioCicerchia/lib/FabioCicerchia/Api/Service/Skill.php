<?php
/**
 * FABIO CICERCHIA - WEBSITE
 *
 * PHP Version 5.4

 * @category   API
 * @package    FabioCicerchia\Api\Service
 * @subpackage Skill
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
 * @subpackage Skill
 * @author     Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright  2012 Fabio Cicerchia. All Rights reserved.
 * @license    TBD <http://www.fabiocicerchia.it>
 * @link       http://www.fabiocicerchia.it
 * @version    XXX
 */
class Skill extends \FabioCicerchia\Api\ServiceAbstract
{
    // {{{ PROPERTIES
    /**
     * @var string $collection_name TODO: Message
     */
    protected $collection_name = 'skill';
    // }}}

    // {{{ elaborateData
    /**
     * TODO: Message
     *
     * @internal
     * @return array TODO: Message
     * @see    FabioCicerchia\Api\Service\Skill::elaborateSkillEntities() TODO: Message
     */
    protected function elaborateData($data)
    {
        $data = $this->elaborateSkillEntities($data);

        return $data;
    }
    // }}}

    // {{{ elaborateSkillEntities
    /**
     * TODO: Message
     *
     * @param array $entities The list of the records retrieved.
     *
     * @internal
     * @return array TODO: Message
     */
    protected function elaborateSkillEntities($entities)
    {
        $new_entities = array();

        foreach ($entities as $entry) {
            // TODO: set a key like "type" => "methodologies|techniques"
            $keys = array_slice(array_keys($entry), 1, 1);
            $main_key = array_shift($keys);
            $new_entities[$main_key] = ['_id' => strval($entry['_id'])];

            foreach ($entry[$main_key] as $name => $item) {
                $new_entities[$main_key][$item['proficiency']][] = $name;
            }
        }

        return $new_entities;
    }
    // }}}

    // {{{ postElaborateData
    /**
     * TODO: Message
     *
     * @param  array $data TODO: Message
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
