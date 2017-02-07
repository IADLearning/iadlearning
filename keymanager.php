<?php
// This file is part of iAdLearning Moodle Plugin - http://www.iadlearning.com/
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
 * Requests Access Keys for IADLearning
 *
 * @package     mod_iadlearning
 * @copyright   www.itoptraining.com 
 * @author      jose.omedes@itoptraining.com
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @date		2017-01-26
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/forms.php');
require_once(dirname(__FILE__) . '/lib.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once($CFG->libdir . '/pagelib.php');
require_once(dirname(__FILE__) . '/classes/iad_httprequests.php');

global $CFG, $DB, $OUTPUT, $USER, $PAGE;


require_login();

$context = context_user::instance($USER->id);
$PAGE->set_context($context);
$PAGE->set_pagelayout('incourse');
$PAGE->set_url('/mod/iadlearning/view.php');
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/iadlearning/js/functions.js'), true);
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/iadlearning/js/jquery-1.11.2.min.js'), true);
$PAGE->requires->css(new moodle_url('http://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css'), true);
$PAGE->requires->js(new moodle_url ('http://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js'), true);

$settings_url = new moodle_url($CFG->wwwroot . '/admin/settings.php?section=modsettingiadlearning');


// /* Log View Event */
// $event = \mod_iadlearning\event\course_module_viewed::create(array(
//     'objectid' => $PAGE->cm->instance,
//     'context' => $PAGE->context,
// ));
// $event->add_record_snapshot('course', $PAGE->course);
// $event->trigger();

$user_data = false;
$mform = new iad_get_keys_form();

if ($mform->is_cancelled()) {

	redirect($settings_url);

} else if ($fromform = $mform->get_data()) {

	$protocol = 'https://';
	$key_manager = 'keymanager.elearningcloud.net';
	$port = 443;
  	$api_controller = new iad_http($protocol, $key_manager, $port);
  	$api_call = '/api/v2/external/key-provisioning';

  	//** Popolate remainding fields required to get the key */
  	$form_data = new stdClass();
  	$form_data = $mform->get_data();
  	
  	$form_data->id = $USER->id;
	
	$user_roles = get_user_roles($context, $USER->id);
	$first_role = reset($user_roles);
	switch (sizeof($user_roles)) {
		case 0: /* User has reached the element not being enrolled - It is and admin user */
			$rol_name = "admin";
			break;
		default:
			$rol_name =  $first_role->shortname;
			break;
	}

	$form_data->role = $rol_name;
	$form_data->url =  $_SERVER['HTTP_HOST'];

	unset($form_data->submitbutton);

  	list($return_code, $key_info) = $api_controller->iad_http_post($api_call, $form_data);

  	if ($return_code == 200) {

  		$key_info_json = json_decode($key_info, true);

  		try {

	  		set_config('iad_backend', $key_info_json["api"], 'iadlearning');
	  		set_config('iad_access_key', $key_info_json["keys"]["accessKey"], 'iadlearning');
	  		set_config('iad_secret_access_key', $key_info_json["keys"]["secretAccessKey"], 'iadlearning');
	  		set_config('iad_access_siteid', $key_info_json["keys"]["siteId"], 'iadlearning');
	  		set_config('iad_access_role', $key_info_json["keys"]["role"], 'iadlearning');
	  		set_config('iad_access_method', 'autoprovisioning', 'iadlearning');
	  
	  	}

  		catch (Exception $e) {

  			$script = "alert(\"" . get_string('iad_provisioning_error', 'iadlearning') . "\")";
  			echo html_writer::script($script);

  		}

  		redirect($settings_url);

  	}

  	else {

  		$script = "alert(\"" . get_string('iad_provisioning_error', 'iadlearning') . "\")";
  		echo html_writer::script($script);
  		redirect($settings_url);

  	}

	

} else {


  echo $OUTPUT->header();

  $mform->display();

  echo $OUTPUT->footer();

}



?>