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
 * Prints a particular instance of iadlearning
 *
 * @package     mod_iadlearning
 * @copyright   www.itoptraining.com 
 * @author      jose.omedes@itoptraining.com
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @date		2017-01-26
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/lib.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once($CFG->libdir . '/pagelib.php');
require(dirname(__FILE__) . '/classes/iad_httprequests.php');

global $CFG, $DB, $OUTPUT, $USER, $PAGE;

$id = optional_param('id', 0, PARAM_INT);

if (!$cm = get_coursemodule_from_id('iadlearning', $id)) {
	print_error('Course Module ID was incorrect');
}

if (!$course = $DB->get_record('course', array('id'=> $cm->course))) {
	print_error('Course is misconfigured');
}

if (!$iad = $DB->get_record('iadlearning', array('id'=> $cm->instance))) {
	print_error('Course module is incorrect');
}

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
$course_context = context_course::instance($course->id);

$PAGE->set_context($context);
$PAGE->set_url('/mod/iadlearning/view.php', array('id' => $cm->id));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/iadlearning/js/functions.js'), true);
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/iadlearning/js/jquery-1.11.2.min.js'), true);
$PAGE->requires->css(new moodle_url('http://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css'), true);
$PAGE->requires->js(new moodle_url ('http://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js'), true);

/* Log View Event */
$event = \mod_iadlearning\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->trigger();

/** Check activity configuration is valid */
if ( null == get_config('mod_iadlearning','iad_frontend') || empty(get_config('mod_iadlearning','iad_frontend_port')) || null == get_config('mod_iadlearning','iad_backend') || empty(get_config('mod_iadlearning','iad_backend_port')) 
	|| null == get_config('mod_iadlearning','iad_access_key') || empty(get_config('mod_iadlearning','iad_secret_access_key'))) {

	$script = "alert(\"" . get_string('settings_error', 'iadlearning') . "\");
			location.href = \"" . $CFG->wwwroot . "/course/view.php?id=" . $course->id . "\";";

	echo html_writer::script($script);
	exit;
}

/** Find out user roles */
$user_roles = get_user_roles($course_context, $USER->id);
$first_role = reset($user_roles);
switch (sizeof($user_roles)) {
	case 0: /* User has reached the element not being enrolled - It is and admin user */
		$rol_name = "admin";
		break;
	default:
		$rol_name =  $first_role->shortname;
		break;
}

// Generate Encoded Signature
$requestparameters["accesskey"] = get_config('mod_iadlearning','iad_access_key');
$requestparameters["course"] = $iad->iad_course;
$requestparameters["email"] = $USER->email;
$requestparameters["enrollmentstart"] = "";
$requestparameters["enrollmentstop"] = "";
$requestparameters['id'] = $USER->id;
$requestparameters['role'] = $rol_name;
$requestparameters["timestamp"] = time();
$requestparameters["name"] = $USER->firstname;
$requestparameters["lastname"] = $USER->lastname;
$requestparameters["type"] = 1;


// Generate URL query string for http requests to iAdLearning
$secretAccessKey = get_config('mod_iadlearning','iad_secret_access_key');
$signature = generate_signature($secretAccessKey, $requestparameters);
$requestparameters["signature"] = $signature;


$querystring = generate_url_query($requestparameters);

// Compute URL to open iAdLearning Activity
$backend_protocol = get_config('mod_iadlearning','iad_backend_nonsecure') ? 'http://': 'https://';
$backend = get_config('mod_iadlearning','iad_backend');
$backend_port = get_config('mod_iadlearning','iad_backend_port');
$frontend_protocol = get_config('mod_iadlearning','iad_frontend_nonsecure') ? 'http://': 'https://';
$frontend = get_config('mod_iadlearning','iad_frontend');
$frontend_port = get_config('mod_iadlearning','iad_frontend_port');


// Script to open the activity in iAdLearning
$finalurl = $frontend_protocol . $frontend . ":" . $frontend_port . "/external/login?" . $querystring;


$script = "window.open('" . $finalurl . "', '_blank', 'location=no,toolbar=no,menubar=no,scrollbars=yes,resizable=yes,width=1500,height=1000');";
//$open_window = "iad_open_course('" . $finalurl . "')";

$platform_url_found = false;
$last_access_found = false;
$test_info_found = false;

$api_controller = new iad_http($backend_protocol, $backend, $backend_port);

/** Gather iAdLearning Platform ID */
$apicall_platform = '/api/v2/platforms/url/' . $frontend;
$result = $api_controller->iad_hhtp_get($apicall_platform);
$json = json_decode($result, true);

if (($result) && ($json["_id"])) {

	$platform_url_found = true;
	
	$apicall_access = '/api/v2/external/' . $json["_id"] . '/access';
	$apicall_tests = '/api/v2/external/' . $json["_id"] . '/tests';
	$apicall_all_tests = '/api/v2/external/' . $json["_id"] . '/all';

	/** Request Last Access Information */
	$api_controller = new iad_http($backend_protocol, $backend, $backend_port);
	$access = $api_controller->iad_hhtp_get($apicall_access, $querystring);

	if ($access) {

		$last_access_found = true;
		$access_json = json_decode($access, true);
		if (!isset($access_json["date"]) || is_null($access_json["date"])) {
			$last_access = get_string('iad_no_last_access', 'iadlearning');
		}
		else {
			$timestamp = strtotime($access_json["date"]);
			$last_access = userdate($timestamp); 
		}
			
		/** Request Tests Information */
		$table = new html_table();
		$table->id = "tests";
		$table->align = array('left', 'left', 'center', 'center');

		if (has_capability('mod/iadlearning:view_tests_report', $context)) {
			$tests = $api_controller->iad_hhtp_get($apicall_all_tests, $querystring);
			$table->size = array('30%', '30%', '20%', '20%');
			$table->head = array(get_string('iad_test_user', 'iadlearning'), get_string('iad_test_title', 'iadlearning'), get_string('iad_test_attempts', 'iadlearning'), get_string('iad_test_score', 'iadlearning'));
		}
		else {
			$tests = $api_controller->iad_hhtp_get($apicall_tests, $querystring);
			$table->size = array('20%', '40%', '20%', '20%');
			$table->head = array(get_string('iad_test_id', 'iadlearning'), get_string('iad_test_title', 'iadlearning'), get_string('iad_test_attempts', 'iadlearning'), get_string('iad_test_score', 'iadlearning'));
		}


		$tests_json = json_decode($tests, true);
		$total = count((array) $tests_json);

		if ($total > 0) {
			$test_info_found = true;
			$tests_array = array();
			foreach ($tests_json as $test_info) {
				$test_info["finalScore"] = number_format($test_info["finalScore"] * 10, 2);
				array_push($tests_array, array_values($test_info));
			}
			$table->data = $tests_array;
		}
	}
}


/*
*   ACTUAL VIEW PAGE
*/

/** Print the page header */
echo $OUTPUT->header();

echo "<br />";
echo "<h2 style=\"text-align: center\">" . $iad->name . " </h2>" ;
echo "<br />";

echo "<p style=\"text-align: center\"> <button class=\"btn btn-success\" type=\"button\" onclick=\"" . $script . "\">". get_string('iad_access_activity', 'iadlearning') ."</button> </p>";
echo "<br />";
echo "<h3 style=\"text-align: center\">". get_string('iad_activity_info', 'iadlearning') . "</h3>" ;
echo "<br />";

if ($last_access_found) {
	echo "<br />";
	echo "<h4 style=\"text-align: left\">" . get_string('iad_last_access', 'iadlearning') . ": " . $last_access . "</h4>";
}
else {
	echo "<br />";
	echo "<h4 style=\"text-align: center\"; color: \"red\" >" . get_string('iad_last_access_unable', 'iadlearning') . "</h4>";
}

if ($test_info_found) {
	echo "<br />";
	echo "<h4 style=\"text-align: left\"; color: \"red\">" . get_string('iad_test_info', 'iadlearning') . ": " . "</h4>";
	echo "<br />";
	echo html_writer::table($table);

	/** Apply datatables */

	/*
	* 	Apply DataTables JS Plugin to format and Paginate the Results Table
	*/

	/** Language Customization */

	$l['search'] = get_string('iad_dt_search', 'iadlearning');
	$l['info'] = get_string('iad_dt_info', 'iadlearning');
	$l['infoEmpty'] = get_string('iad_dt_infoEmpty', 'iadlearning');
	$l['lengthMenu'] = get_string('iad_dt_lengthMenu', 'iadlearning');

	$language_string ="";
	foreach ($l as $key => $value) {
		$language_string = $language_string . $key . ":" . "\"" . $value . "\"," ;
	}

	$p['first'] = get_string('iad_dt_first', 'iadlearning');
	$p['previous'] = get_string('iad_dt_previous', 'iadlearning');
	$p['next'] = get_string('iad_dt_next', 'iadlearning');
	$p['last'] = get_string('iad_dt_last', 'iadlearning');
	$p['info'] = get_string('iad_dt_info', 'iadlearning');

	$paginate_string ="";
	foreach ($p as $key => $value) {
		$paginate_string = $paginate_string . $key . ":" . "\"" . $value . "\"," ;
	}
	$l_string = $language_string . "paginate: {" . $paginate_string . "}";

	/** Plugin Activation */
	$datatables_script = "$(document).ready(function(){ $('#tests').DataTable({ language : {" . $l_string . "} }); });";
	echo html_writer::script($datatables_script);

}

/** Print the page footer */
echo $OUTPUT->footer(); 

?>