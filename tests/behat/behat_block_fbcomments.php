<?php
// This file is part of Fbcomments - https://github.com/ankitagarwal/moodle-block_fbcomments
//
// Fbcomments is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Fbcomments is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// For GNU General Public License, see <http://www.gnu.org/licenses/>.

/**
 * Fbcomments behat custom steps.
 *
 * @package   block_fbcomments
 * @copyright 2015 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../lib/behat/behat_base.php');

use Behat\Behat\Context\Step\Given as Given,
    Behat\Mink\Exception\ElementNotFoundException as ElementNotFoundException;

/**
 * Fbcomments behat custom steps.
 *
 * @package   block_fbcomments
 * @copyright 2015 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_block_fbcomments extends behat_base {

    /**
     * Helper used to find and switch to behat frame. This is currently not used as facebook doesn't like opening and parsing
     * this iframe.
     *
     * @Given /^I switch to fbcomments iframe$/
     * @throws ElementNotFoundException
     * @return Given[] the steps.
     */
    public function switch_to_fbcomments_iframe() {
        $iframe = $this->find('css' ,'iframe[title~="Facebook"]');
        if (empty($iframe)) {
            // Iframe not found.
            throw new ElementNotFoundException($this->getSession(), 'Facebook iframe ');
        }
        $name = $iframe->getAttribute('name');
        return new Given('I switch to "' . $name . '" iframe');
    }
}
