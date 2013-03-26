<?php
/**
 * Form for editing moodlefbcomments block instances.
 *
 * @package   block_moodlefbcomments
 * @copyright 2013 Ankit Agarwal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Form for editing Moodle-Fb comments block instances.
 *
 * @copyright 2013 Ankit Agarwal
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_moodlefbcomments_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;

        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitle', 'block_moodlefbcomments'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', get_string('newfbblock', 'block_moodlefbcomments'));

        if (is_siteadmin()) {
            $options = array(1 => get_string('thispage', 'block_moodlefbcomments'),
                    2 => get_string('siteroot', 'block_moodlefbcomments'));
            $mform->addElement('select', 'config_urltype', get_string('urltype', 'block_moodlefbcomments'), $options);
        } else {
            $mform->addElement('hidden', 'config_urltype', 1);
        }

        $mform->addElement('advcheckbox', 'config_enablelike', get_string('enablelike', 'block_moodlefbcomments'));
        $mform->addElement('advcheckbox', 'config_enablecomment', get_string('enablecomment', 'block_moodlefbcomments'));
        $mform->setType('config_enablelike', PARAM_BOOL);
        $mform->setType('config_enablecomment', PARAM_BOOL);
        $mform->setDefault('config_enablelike', 1);
        $mform->setDefault('config_enablecomment', 0);

    }
    function validation($data, $files) {
        // Security checks.
        $error = parent::validation($data, $files);
        if ($data['config_urltype']  != 1) {
            if (!(is_siteadmin() && $data['config_urltype'] == 2)) {
                $error['urltype'] = get_string('invalidvalue', 'block_moodlefbcomments');
            }
        }
        return $error;
    }
}
