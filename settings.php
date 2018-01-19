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

defined('MOODLE_INTERNAL') || die;

global $USER, $CFG;

$urlredirect = new moodle_url($CFG->wwwroot . '/mod/iadlearning/keymanager.php');
$message = get_string('iad_get_demo_keys', 'iadlearning');
$template = "<br/> <p style=\"text-align: right\">  <a class=\"btn btn-success\" href=\"{$urlredirect}\">
 {$message} </a> </p> <br/>";


if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading('IADLearning_demo_settings', ' ', $template));


    // Backend URL.
    $name = 'iadlearning/iad_backend';
    $title = get_string('iad_backend', 'iadlearning');
    $description = get_string('iad_backend_help', 'iadlearning');
    $setting = new admin_setting_configtext($name, $title, $description, 'https://apipro.elearningcloud.net');
    $settings->add($setting);

    // Access Key ID.
    $name = 'iadlearning/iad_access_key';
    $title = get_string('iad_access_key_id', 'iadlearning');
    $description = get_string('iad_access_key_id_help', 'iadlearning');
    $setting = new admin_setting_configtext($name, $title, $description, '18be620f2bc00e7f96cae0a9bed77bcd27b53c96');
    $settings->add($setting);

    // Secret Access key.
    $name = 'iadlearning/iad_secret_access_key';
    $title = get_string('iad_secret_access_key', 'iadlearning');
    $description = get_string('iad_secret_access_key_help', 'iadlearning');

    $setting = new admin_setting_configtext($name, $title, $description, 'd20bc3c1649769f52932e50866f5bc67ef7aac6f');
    $settings->add($setting);
}