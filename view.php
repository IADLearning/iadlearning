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
 * @date        2017-02-10
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

if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
    print_error('Course is misconfigured');
}

if (!$iad = $DB->get_record('iadlearning', array('id' => $cm->instance))) {
    print_error('Course module is incorrect');
}

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
$coursecontext = context_course::instance($course->id);

$PAGE->set_context($context);
$PAGE->set_url('/mod/iadlearning/view.php', array('id' => $cm->id));
$PAGE->requires->jquery();
$PAGE->requires->jquery_plugin('ui');
$PAGE->requires->jquery_plugin('ui-css');
$PAGE->requires->css(new moodle_url('https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css'));

// Log View Event.
$event = \mod_iadlearning\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->trigger();

// Check activity configuration is valid.
if (null == get_config('iadlearning', 'iad_backend') || null == get_config('iadlearning', 'iad_access_key') ||
    empty(get_config('iadlearning', 'iad_secret_access_key'))) {
    $script = "alert(\"" . get_string('settings_error', 'iadlearning') . "\");
            location.href = \"" . $CFG->wwwroot . "/course/view.php?id=" . $course->id . "\";";
    echo html_writer::script($script);
    exit;
}


// Gather IADLearning instance information.
$fullurl = get_config('iadlearning', 'iad_backend');

$apicontroller = new iad_http(parse_url($fullurl, PHP_URL_SCHEME) . '://',
    parse_url($fullurl, PHP_URL_HOST), parse_url($fullurl, PHP_URL_PORT));

$apiinfocall = '/api/v2/external/partner-info';
$requestparameters["timestamp"] = time();
$requestparameters["accesskey"] = get_config('iadlearning', 'iad_access_key');
$accesskey = get_config('iadlearning', 'iad_access_key');
$secretaccesskey = get_config('iadlearning', 'iad_secret_access_key');

$signature = iadlearning_generate_signature($secretaccesskey, $requestparameters);
$requestparameters["signature"] = $signature;

$querystring = iadlearning_generate_url_query($requestparameters);

list($responsecode, $instanceinfo) = $apicontroller->iad_http_get($apiinfocall, $querystring);

if ($responsecode != 200) {
    $script = "alert(\"" . get_string('iad_servercontact_error', 'iadlearning') . "\");
        location.href = \"" . $CFG->wwwroot . "/course/view.php?id=" . $course->id . "\";";
    echo html_writer::script($script);
}
$instanceinfojson = json_decode($instanceinfo);

try {
    $frontend = $instanceinfojson->url;
    $platformid = $instanceinfojson->platformId;
} catch (Exception $e) {
    $script = "alert(\"" . get_string('iad_servercontact_error', 'iadlearning') . "\")";
    echo html_writer::script($script);
}


// Find out user roles.
$userroles = get_user_roles($coursecontext, $USER->id);
$firstrole = reset($userroles);
switch (count($userroles)) {
    case 0: /* User has reached the element not being enrolled - It is and admin user */
        $rolname = "admin";
        break;
    default:
        $rolname = $firstrole->shortname;
        break;
}

unset($requestparameters);

// Generate Encoded Signature.
$requestparameters["accesskey"] = $accesskey;
$requestparameters["callbackURL"] = $CFG->wwwroot . "/course/view.php?id=" . $course->id;
$requestparameters["course"] = $iad->iad_course;
$requestparameters["email"] = $USER->email;
$requestparameters["enrollmentstart"] = "";
$requestparameters["enrollmentstop"] = "";
$requestparameters['id'] = $USER->id;
$requestparameters['role'] = $rolname;
$requestparameters["timestamp"] = time();
$requestparameters["name"] = $USER->firstname;
$requestparameters["lastname"] = $USER->lastname;
$requestparameters["type"] = 1;


// Generate URL query string for http requests to iAdLearning.
$signature = iadlearning_generate_signature($secretaccesskey, $requestparameters);
$requestparameters["signature"] = $signature;
$querystring = iadlearning_generate_url_query($requestparameters);


// Script to open the activity in iAdLearning.
$fronturl = $frontend . "/external/login?" . $querystring;

$platformurlfound = false;
$lastaccessfound = false;
$testinfofound = false;
$renderdata = new stdClass();

if ($platformid) {
    $platformurlfound = true;
    $renderdata->platformurlfound = true;

    $apicallaccess = '/api/v2/external/' . $platformid . '/access';
    $apicalltests = '/api/v2/external/' . $platformid . '/tests';
    $apicallalltests = '/api/v2/external/' . $platformid . '/all';

    // Request Last Access Information.
    list($responsecode, $access) = $apicontroller->iad_http_get($apicallaccess, $querystring);

    if (($access) && ($responsecode == 200)) {
        $lastaccessfound = true;
        $renderdata->lastaccessfound = true;
        $accessjson = json_decode($access, true);
        if (!isset($accessjson["date"]) || is_null($accessjson["date"])) {
            $lastaccess = get_string('iad_no_last_access', 'iadlearning');
        } else {
            $timestamp = strtotime($accessjson["date"]);
            $lastaccess = userdate($timestamp);
        }
        $renderdata->lastaccess = $lastaccess;

        // Request Tests Information.
        if (has_capability('mod/iadlearning:view_tests_report', $context)) {
            list($responsecode, $tests) = $apicontroller->iad_http_get($apicallalltests, $querystring);
        } else {
            list($responsecode, $tests) = $apicontroller->iad_http_get($apicalltests, $querystring);
        }

        $testsdata = json_decode($tests, true);
        $total = count($testsdata);
        if ($total > 0) {
            $renderdata->testinfofound = true;
            $renderdata->data = $testsdata;
        }
    }
}

// UI Messages.
$renderdata->coursename = $iad->name;
$renderdata->accessurl = $fronturl;
$renderdata->iad_access_activity = get_string('iad_access_activity', 'iadlearning');
$renderdata->iad_activity_info = get_string('iad_activity_info', 'iadlearning');
$renderdata->iad_last_access = get_string('iad_last_access', 'iadlearning');
$renderdata->iad_test_info = get_string('iad_test_info', 'iadlearning');
$renderdata->iad_test_user = get_string('iad_test_user', 'iadlearning');
$renderdata->iad_test_id = get_string('iad_test_id', 'iadlearning');
$renderdata->iad_test_title = get_string('iad_test_title', 'iadlearning');
$renderdata->iad_test_attempts = get_string('iad_test_attempts', 'iadlearning');
$renderdata->iad_test_score = get_string('iad_test_score', 'iadlearning');


// Actual view page.

echo $OUTPUT->header();

echo $OUTPUT->render_from_template('mod_iadlearning/view', $renderdata);

// Set up DataTable with passed options.
$params = array("select" => true, "paginate" => true);
$params['buttons'] = array("selectAll", "selectNone");
$params['dom'] = 'Bfrtip';      // Needed to position buttons; else won't display.
$l['search'] = get_string('iad_dt_search', 'iadlearning');
$l['info'] = get_string('iad_dt_info', 'iadlearning');
$l['infoEmpty'] = get_string('iad_dt_infoEmpty', 'iadlearning');
$l['lengthMenu'] = get_string('iad_dt_lengthMenu', 'iadlearning');
$l['first'] = get_string('iad_dt_first', 'iadlearning');
$l['previous'] = get_string('iad_dt_previous', 'iadlearning');
$l['next'] = get_string('iad_dt_next', 'iadlearning');
$l['last'] = get_string('iad_dt_last', 'iadlearning');
$l['info'] = get_string('iad_dt_info', 'iadlearning');
$params['language'] = $l;
$selector = '.datatable';

// Re-render table using Data Tables.
$PAGE->requires->js_call_amd('mod_iadlearning/init-datatables', 'init', array($selector, $params));

echo $OUTPUT->footer();