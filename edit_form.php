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
 * Form for editing fbcomments block instances.
 *
 * @package   block_fbcomments
 * @copyright 2013 Ankit Agarwal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Form for editing fbcomments block instances.
 *
 * @copyright 2013 Ankit Agarwal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_fbcomments_edit_form extends block_edit_form {
    protected function specific_definition($mform) {

        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_fbcomments'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', get_string('newfbblock', 'block_fbcomments'));

        $options = $this->get_page_options();
        $mform->addElement('select', 'config_urltype', get_string('urltype', 'block_fbcomments'), $options);
        $options = array('light' => get_string('lightcolor', 'block_fbcomments'), 'dark' => get_string('darkcolor', 'block_fbcomments'));
        $mform->addElement('select', 'config_colorscheme', get_string('colorscheme', 'block_fbcomments'), $options);
        $mform->setDefault('config_colorscheme', 'light');


        $mform->addElement('advcheckbox', 'config_enablelike', get_string('enablelike', 'block_fbcomments'));
        $mform->addElement('advcheckbox', 'config_enableshare', get_string('enableshare', 'block_fbcomments'));
        $mform->addElement('advcheckbox', 'config_enablecomment', get_string('enablecomment', 'block_fbcomments'));
        $mform->setType('config_enablelike', PARAM_BOOL);
        $mform->setType('config_enablecomment', PARAM_BOOL);
        $mform->setType('config_enableshare', PARAM_BOOL);
        $mform->setDefault('config_enablelike', 1);
        $mform->setDefault('config_enablecomment', 0);
        $mform->setDefault('config_enableshare', 0);
        $mform->disabledIf('config_enableshare', 'config_enablelike', 'notchecked');

        $mform->addElement('text', 'config_numposts', get_string('numposts', 'block_fbcomments'));
        $mform->setType('config_numposts', PARAM_INT);
        $mform->addRule('config_numposts', get_string("notnumeric", "block_fbcomments"), "numeric", null, "client");
        $mform->setDefault('config_numposts', 10);
        $mform->disabledIf('config_numposts', 'config_enablecomment', 'notchecked');

        $options = block_fbcomments::get_order_by_options();
        $mform->addElement('select', 'config_commentorder', get_string('commentorder', 'block_fbcomments'), $options);
        $mform->setType('config_commentorder', PARAM_ALPHA);
        $mform->addHelpButton('config_commentorder', 'commentorder', 'block_fbcomments');
        $mform->disabledIf('config_commentorder', 'config_enablecomment', 'notchecked');

        $mform->addElement('text', 'config_appid', get_string('appid', 'block_fbcomments'));
        $mform->addHelpButton('config_appid', 'appid', 'block_fbcomments');
        $mform->addRule('config_appid', get_string("notnumeric", "block_fbcomments"), "numeric", null, "client");
        $mform->setType('config_appid', PARAM_INT);
        $mform->disabledIf('config_appid', 'config_enablecomment', 'notchecked');

    }
    // No security checks needed as moodle automatically checks if submitted value for a select is in $options.

    private function get_page_options() {
        $options = array(1 => get_string('thispage', 'block_fbcomments'));
        $pagecontext = $this->page->context;
        $coursecontext = $pagecontext->get_course_context(IGNORE_MISSING);
        if (has_capability('block/fbcomments:manageurl', context_system::instance())) {
            // Most probabily an admin.
            $options[2] = get_string('siteroot', 'block_fbcomments');
        }
        if ($coursecontext && has_capability('block/fbcomments:manageurl', $coursecontext)) {
            $options[3] = get_string('coursepage', 'block_fbcomments');
        }
        if ($pagecontext->contextlevel == CONTEXT_MODULE && has_capability('block/fbcomments:manageurl', $pagecontext)) {
            $options[4] = get_string('modpage', 'block_fbcomments', $pagecontext->get_context_name(false));
        }
        return $options;
    }
}
