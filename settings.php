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

defined('MOODLE_INTERNAL') || die;

global $USER, $CFG;

$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/iadlearning/js/functions.js'), true);
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/iadlearning/js/jquery-1.11.2.min.js'), true);


$url_redirect = new moodle_url($CFG->wwwroot . '/mod/iadlearning/keymanager.php');
$template = "<br/> <p style=\"text-align: right\">  <a class=\"btn btn-success\" href=\"{$url_redirect}\"> Obtener claves demo </a> </p> <br/>";


if($ADMIN->fulltree) {


	$settings->add(new admin_setting_heading('IADLearning_demo_settings', ' ', $template));


	// Backend URL
	$name = 'iadlearning/iad_backend';
	$title = get_string('iad_backend', 'iadlearning');
	$description = get_string('iad_backend_help', 'iadlearning');
	//$value = get_config('mod_iadlearning/iad_backend');
	$setting = new admin_setting_configtext($name, $title, $description, ' ');
	$settings->add($setting);

	// Access Key ID
	$name = 'iadlearning/iad_access_key';
	$title = get_string('iad_access_key_id', 'iadlearning');
	$description = get_string('iad_access_key_id_help', 'iadlearning');
	//$value = get_config('mod_iadlearning/iad_access_key');
	$setting = new admin_setting_configtext($name, $title, $description, ' ');
	$settings->add($setting);

	// Secret Access key
	$name = 'iadlearning/iad_secret_access_key';
	$title = get_string('iad_secret_access_key', 'iadlearning');
	$description = get_string('iad_secret_access_key_help', 'iadlearning');
	//$value = get_config('mod_iadlearning/iad_secret_access_key');
	$setting = new admin_setting_configtext($name, $title, $description, ' ');
	$settings->add($setting);


}

?>
