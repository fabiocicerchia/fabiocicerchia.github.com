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
 * @package    FabioCicerchia\Api\Service
 * @subpackage EntryPoint
 * @author     Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright  2012 - 2013 Fabio Cicerchia.
 * @license    MIT <http://www.opensource.org/licenses/MIT>
 * @link       http://www.fabiocicerchia.it
 * @since      File available since Release 0.1
 */

namespace FabioCicerchia\Api\Service;

/**
 * The EntryPoint.
 *
 * @category   Code
 * @package    FabioCicerchia\Api\Service
 * @subpackage EntryPoint
 * @author     Fabio Cicerchia <info@fabiocicerchia.it>
 * @copyright  2012 - 2013 Fabio Cicerchia. All Rights reserved.
 * @license    MIT <http://www.opensource.org/licenses/MIT>
 * @link       http://www.fabiocicerchia.it
 * @since      File available since Release 0.1
 */
class EntryPoint
{
    // {{{ Methods - Getter ====================================================
    // {{{ Method: getServices -------------------------------------------------
    /**
     * Get the list of implemented services.
     *
     * ### General Information #################################################
     *
     * @since Version 0.1
     *
     * @return array
     */
    public function getServices()
    {
        $files = scandir(__DIR__);
        $files = preg_grep('/^.+\.php$/', $files);
        $files = array_map('strtolower', $files);
        $files = array_map(function($value) {
            return preg_replace('/.php$/', '', $value);
        }, $files);

        unset($files[array_search('entrypoint', $files)]);

        return $files;
    }
    // }}} ---------------------------------------------------------------------
    // }}} =====================================================================
}
