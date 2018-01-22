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
 * The main iad configuration form
 *
 *
 * @package    mod_iadlearning
 * @copyright  www.itoptraining.com
 * @author     jose.omedes@itoptraining.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


global $CFG;

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_login();
require_once(dirname(__FILE__).'/lib.php');
require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once('locallib.php');
require(dirname(__FILE__) . '/classes/iadlearning_httprequests.php');


class mod_iadlearning_mod_form extends moodleform_mod {
    /**
     * Defines the structure for iad mod_form.
     */
    public function definition() {
        global $CFG, $COURSE, $USER, $DB, $PAGE;

        $update = optional_param('update', 0, PARAM_INT);
        $mform = $this->_form;

        $mform->addElement('header', 'general', get_string('general', 'form'));
        // Activity name.
        $mform->addElement('text', 'name', get_string('name'), array(
                'style' => 'width: 40%'
        ));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', get_string('required'), 'required', null, 'client', true);
        // Activity description.
        $this->standard_intro_elements(false, get_string('description'));
        $mform->addElement('header', 'iadconnectsettings', get_string('iadconnectsettings', 'iadlearning'));
        // Email.
        $mform->addElement('text', 'email', get_string('email'), array(
                'style' => 'width: 40%'
        ));
        $mform->setType('email', PARAM_EMAIL);
        $mform->addRule('email', get_string('format_error', 'iadlearning'), 'email', null, 'client', true);
        // Password.
        $mform->addElement('passwordunmask', 'password', get_string('password'), array(
                'style' => 'width: 40%'
        ));
        $mform->setType('password', PARAM_TEXT);
        // Check activity configuration is valid.
        if ( null == get_config('iadlearning', 'iad_backend') ||
            null == get_config('iadlearning', 'iad_access_key') ||
            null == get_config('iadlearning', 'iad_secret_access_key')) {
            $script = "alert(\"" . get_string('settings_error', 'iadlearning') . "\");
                location.href = \"" . $CFG->wwwroot . "/course/view.php?id=" . $COURSE->id . "\";";
            echo html_writer::script($script);
            exit;
        }
        $fullurl = get_config('iadlearning', 'iad_backend');
        $apicontroller = new iadlearning_http(parse_url($fullurl, PHP_URL_SCHEME) . '://',
            parse_url($fullurl, PHP_URL_HOST), parse_url($fullurl, PHP_URL_PORT));
        $apiinfocall = '/api/v2/external/partner-info';
        $requestparameters["timestamp"] = time();
        $requestparameters["accesskey"] = get_config('iadlearning', 'iad_access_key');
        $secretaccesskey = get_config('iadlearning', 'iad_secret_access_key');
        $signature = iadlearning_generate_signature($secretaccesskey, $requestparameters);
        $requestparameters["signature"] = $signature;

        list($responsecode, $instanceinfo) = $apicontroller->iadlearning_http_get($apiinfocall, $requestparameters);

        if ($responsecode != 200) {
            $script = "alert(\"" . get_string('iad_servercontact_error', 'iadlearning') . "\\n" .
                $fullurl . $apiinfocall . "\");
                location.href = \"" . $CFG->wwwroot . "/course/view.php?id=" . $COURSE->id . "\";";

            echo html_writer::script($script);
        }
        $instanceinfojson = json_decode($instanceinfo);

        try {
            $platformid = $instanceinfojson->platformId;
        } catch (Exception $e) {
            $script = "alert(\"" . get_string('iad_servercontact_error', 'iadlearning') . "\")";
            echo html_writer::script($script);
        }

        $mform->addElement('button', 'check_auth', get_string('load_courses', 'iadlearning'), array(
            'style' => 'width: 25%; line-height: 20px; cursor: pointer; float: left; margin-left: 7%'
        ));
        $PAGE->requires->js_call_amd('mod_iadlearning/iadlearning', 'init', array($fullurl, $platformid));
        // Course selected previously.
        if ($update != 0) {
            $mform->addElement('static', 'selected_course', get_string('selected_course',
                'iadlearning'), '');
            $mform->setType('selected_course', PARAM_TEXT);

            $instance = $DB->get_field('course_modules', 'instance', array('id' => $update));
            $selectedcourse = $DB->get_field('iadlearning', 'iad_course_name', array('id' => $instance));

            if (empty($selectedcourse)) {
                $selectedcourse = get_string('none');
            }
            $mform->setDefault('selected_course', "($selectedcourse)");
        }
        // Courses.
        $mform->addElement('select', 'select_course', get_string('select_course',
            'iadlearning'), array('-1' => get_string('choose')), array(
                'style' => 'width: 40%',
                'disabled'
        ));

        $mform->addElement('hidden', 'creator_id', $USER->id);
        $mform->setType('creator_id', PARAM_INT);
        $mform->addElement('hidden', 'iad_course', '', array('id' => 'id_iad_course'));
        $mform->setType('iad_course', PARAM_TEXT);
        $mform->addElement('hidden', 'iad_course_name', '', array('id' => 'id_iad_course_name'));
        $mform->setType('iad_course_name', PARAM_TEXT);

        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
    }


    /**
     * Validates the data input from various input elements.
     *
     * @param string $data
     * @param string $files
     *
     * @return string $errors
     */
    public function validation($data) {
        global $USER;

        $errors = array();
        if ($data['creator_id'] != $USER->id) {
            $errors['creator_id'] = get_string('creator_id_error', 'iadlearning');
        };
        $regex = '/^[0-9a-z]{24}$/';
        if (!preg_match($regex, $data['iad_course'])) {
            $errors['iad_course'] = get_string('iad_course_error', 'iadlearning');
        }
        if (strlen($data['iad_course_name']) > 256) {
            $errors['iad_course'] = get_string('iad_course_name_error', 'iadlearning');
        }

        return $errors;

    }
}