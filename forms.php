<?php
// This file is part of iadlearning Moodle Plugin - http://www.iadlearning.com/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Forms used in iadlearning application
 *
 * @package     mod_iadlearning
 * @copyright   www.itoptraining.com
 * @author      jose.omedes@itoptraining.com
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class iadlearning_get_keys_form extends moodleform {


    /**
     * Defines elements included in the form used to gather new demo
     * keys from the server
     *
     */
    public function definition() {

        $mform =& $this->_form;

        $mform->addElement('header', 'license', get_string('iad_license_info', 'iadlearning'));

        $mform->addElement ( 'text', 'name', get_string ( 'iad_name', 'iadlearning' ),
            'maxlength=255, style="width: 40%"' );
        $mform->addRule ( 'name', get_string('required'), 'required', null, 'license' );
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement ( 'text', 'lastname', get_string ( 'iad_lastname', 'iadlearning' ),
            'maxlength=255, style="width: 40%"' );
        $mform->addRule ( 'lastname', get_string('required'), 'required', null, 'license' );
        $mform->setType('lastname', PARAM_TEXT);

        $mform->addElement ( 'text', 'email', get_string ( 'iad_email', 'iadlearning' ),
            'maxlength=255, style="width: 40%"' );
        $mform->addRule ( 'email', get_string('required'), 'required', null, 'license' );
        $mform->addRule ( 'email', get_string('format_error', 'iadlearning'), 'email', null, 'license' );
        $mform->setType('email', PARAM_TEXT);

        $mform->addElement ( 'text', 'institution', get_string ( 'iad_institution', 'iadlearning' ),
            'maxlength=255, style="width: 40%"' );
        $mform->addRule ( 'institution', get_string('required'), 'required', null, 'license' );
        $mform->setType('institution', PARAM_TEXT);

        $mform->addElement ( 'text', 'phone', get_string ( 'iad_phone', 'iadlearning' ),
            'maxlength=255, style="width: 40%"' );
        $mform->addRule ( 'phone', get_string('required'), 'required', null, 'license' );
        $mform->setType('phone', PARAM_TEXT);

        $mform->addElement ( 'hidden', 'id' );
        $mform->setType('id', PARAM_INT);

        $this->add_action_buttons();

    }

    /**
     * Validates data upon form submission
     * Uses parent validation
     *
     * @param stdClass $data Data coming from the form
     * @param array $files Files uploaded to the form
     *
     * @return string $errors Errors found on validation
     */

    public function validation($data, $files) {

        $errors = parent::validation($data, $files);
        return $errors;
    }
}