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
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/forms.php');
require_once(dirname(__FILE__) . '/lib.php');
require_once(dirname(__FILE__) . '/locallib.php');
require_once($CFG->libdir . '/pagelib.php');
require_once(dirname(__FILE__) . '/classes/iadlearning_httprequests.php');

global $CFG, $DB, $OUTPUT, $USER, $PAGE;


require_login();

$context = context_user::instance($USER->id);
$PAGE->set_context($context);
$PAGE->set_pagelayout('incourse');
$PAGE->set_url('/mod/iadlearning/keymanager.php');

$settingsurl = new moodle_url($CFG->wwwroot . '/admin/settings.php?section=modsettingiadlearning');

$userdata = false;
$mform = new iadlearning_get_keys_form();

if ($mform->is_cancelled()) {

    redirect($settingsurl);

} else if ($fromform = $mform->get_data()) {

    $protocol = 'https://';
    $keymanager = 'keymanager.elearningcloud.net';
    $port = 443;
    $apicontroller = new iadlearning_http($protocol, $keymanager, $port);
    $apicall = '/api/v2/external/key-provisioning';

    // Populate remainding fields required to get the key.
    $formdata = new stdClass();
    $formdata = $mform->get_data();

    unset($formdata->id);
    $formdata->role = "Demo-Admin";
    $formdata->url = $_SERVER['HTTP_HOST'];

    unset($formdata->submitbutton);

    list($returncode, $keyinfo) = $apicontroller->iadlearning_http_post($apicall, $formdata);

    if ($returncode == 200) {
        $keyinfojson = json_decode($keyinfo, true);
        try {
            set_config('iad_backend', $keyinfojson["api"], 'iadlearning');
            set_config('iad_access_key', $keyinfojson["keys"]["accessKey"], 'iadlearning');
            set_config('iad_secret_access_key', $keyinfojson["keys"]["secretAccessKey"], 'iadlearning');
            set_config('iad_access_siteid', $keyinfojson["keys"]["siteId"], 'iadlearning');
            set_config('iad_access_role', $keyinfojson["keys"]["role"], 'iadlearning');
            set_config('iad_access_method', 'autoprovisioning', 'iadlearning');
        } catch (Exception $e) {
            $script = "alert(\"" . get_string('iad_provisioning_error', 'iadlearning') . "\")";
            echo html_writer::script($script);
        }
        redirect($settingsurl);
    } else {
        $script = "alert(\"" . get_string('iad_provisioning_error', 'iadlearning') . "\")";
        echo html_writer::script($script);
        redirect($settingsurl);
    }
} else {
    echo $OUTPUT->header();

    $mform->display();

    echo $OUTPUT->footer();
}
