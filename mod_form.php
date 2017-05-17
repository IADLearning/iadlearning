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
require_once(dirname(__FILE__).'/lib.php');
require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once('locallib.php');
require(dirname(__FILE__) . '/classes/iad_httprequests.php');

/**
 * The main iad configuration class.
 * 
 * Module instance settings form. This class inherits the moodleform_mod class to 
 * create the moodle form for iad
 * @copyright  www.itoptraining.com 
 * @author     antonio.sanchez@itoptraining.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_iadlearning_mod_form extends moodleform_mod {
    /**
     * Defines the structure for iad mod_form.
     */
    public function definition() {
        global $CFG, $OUTPUT, $COURSE, $USER, $DB, $PAGE;

		$platform = null;
        $url = null;
		$update = optional_param('update', 0, PARAM_INT);

        $mform = $this->_form;

        $PAGE->requires->js('/mod/iadlearning/js/functions.js', true);
        $PAGE->requires->js('/mod/iadlearning/js/jquery-1.11.2.min.js', true);

        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Activity name
        $mform->addElement('text', 'name', get_string('name'), array(
        		'style' => 'width: 40%'
        ));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', get_string('required'), 'required', null, 'client', true);
        
        // Activity description
        $this->add_intro_editor(false, get_string('description'));

        $mform->addElement('header', 'iadconnectsettings', get_string('iadconnectsettings', 'iadlearning'));

        // Email
        $mform->addElement('text', 'email', get_string('email'), array(
        		'style' => 'width: 40%'
        ));
        $mform->setType('email', PARAM_EMAIL);

        // Password
        $mform->addElement('passwordunmask', 'password', get_string('password'), array(
        		'style' => 'width: 40%'
        ));
        $mform->setType('password', PARAM_TEXT);

        // Check activity configuration is valid
        if ( null == get_config('iadlearning', 'iad_backend') || null == get_config('iadlearning', 'iad_access_key') || null == get_config('iadlearning','iad_secret_access_key')) {

            $script = "alert(\"" . get_string('settings_error', 'iadlearning') . "\");
                location.href = \"" . $CFG->wwwroot . "/course/view.php?id=" . $course->id . "\";";

            echo html_writer::script($script);
            exit;
        }


        //** Gather IADLearning instance information */
        // Instance to use for the configured keys
        $full_url = get_config('iadlearning', 'iad_backend');

        $api_controller = new iad_http(parse_url($full_url, PHP_URL_SCHEME) . '://', parse_url($full_url, PHP_URL_HOST), parse_url($full_url, PHP_URL_PORT));

        $api_info_call = '/api/v2/external/partner-info';
        $requestparameters["timestamp"] = time();
        $requestparameters["accesskey"] = get_config('iadlearning', 'iad_access_key');
        $access_key = get_config('iadlearning', 'iad_access_key');
        $secret_access_key = get_config('iadlearning', 'iad_secret_access_key');

        $signature = generate_signature($secret_access_key, $requestparameters);
        $requestparameters["signature"] = $signature;

        $querystring = generate_url_query($requestparameters);

        list($response_code, $instance_info) = $api_controller->iad_http_get($api_info_call, $querystring);

        if ($response_code != 200) {

            $script = "alert(\"" . get_string('iad_servercontact_error', 'iadlearning') . parse_url($full_url, PHP_URL_HOST) . $full_url . $api_info_call . "\");
                location.href = \"" . $CFG->wwwroot . "/course/view.php?id=" . $course->id . "\";";

            echo html_writer::script($script);

        }
        $instance_info_json = json_decode($instance_info);

        try {
            
            $frontend = $instance_info_json->url;
            $platform_id = $instance_info_json->platformId;

        }
        catch (Exception $e) {

            $script = "alert(\"" . get_string('iad_servercontact_error', 'iadlearning') . "\")";
            echo html_writer::script($script);

        }


        $mform->addElement('button', 'check_auth', get_string('load_courses', 'iadlearning'), array(
        		'onclick'	=>	"iad_get_course_list('{$full_url}', '{$platform_id}', document.getElementById('id_email').value, document.getElementById('id_password').value, '" . get_string('login_failed', 'iadlearning') . "')",	// , '', '', 0, '', '', '', '', '', '', '', '')",
        		'style'		=>	'width: 25%; line-height: 20px; cursor: pointer; float: left; margin-left: 7%'
		));


        // Course selected previously
        if($update != 0) {
        	$mform->addElement('static', 'selected_course', get_string('selected_course', 'iadlearning'), '');
        	$mform->setType('selected_course', PARAM_TEXT);

        	$instance = $DB->get_field('course_modules', 'instance', array('id' => $update));
        	$selectedCourse = $DB->get_field('iad', 'iad_course_name', array('id' => $instance));

        	if(empty($selectedCourse)) {
        		$selectedCourse = get_string('none');
        	}

        	$mform->setDefault('selected_course', "($selectedCourse)");
        }

        // Courses
        $mform->addElement('select', 'select_course', get_string('select_course', 'iadlearning'), array('-1' => get_string('choose')), array(
        		'onchange'	=> "setIadFields()",
        		'style'		=> 'width: 40%',
        		'disabled'
        ));

        // Hidden fields
        $mform->addElement('hidden', 'creator_id', $USER->id);
        $mform->addElement('hidden', 'iad_course', '', array('id' => 'id_iad_course'));
        $mform->addElement('hidden', 'iad_course_name', '', array('id' => 'id_iad_course_name'));

        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();
        
        // add standard buttons, common to all modules
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
    public function validation($data, $files) {
    	

    }
}
?>