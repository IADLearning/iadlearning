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

if($ADMIN->fulltree) {

	// Frontend URL
	$name = 'mod_iadlearning/iad_frontend';
	$title = get_string('iad_frontend', 'iadlearning');
	$description = get_string('iad_frontend_help', 'iadlearning');
	$setting = new admin_setting_configtext($name, $title, $description, '');
	$settings->add($setting);

	// Frontend port
	$name = 'mod_iadlearning/iad_frontend_port';
	$title = get_string('iad_frontend_port', 'iadlearning');
	$description = get_string('iad_frontend_port_help', 'iadlearning');
	$setting = new admin_setting_configtext($name, $title, $description, '');
	$settings->add($setting);

	//Front End non secure connection
	$name = 'mod_iadlearning/iad_frontend_nonsecure';
	$title = get_string('iad_frontend_nonsecure', 'iadlearning');
	$description = get_string('iad_frontend_nonsecure_help', 'iadlearning');
	$setting = new admin_setting_configcheckbox($name, $title, $description, 0);
	$settings->add($setting);

	// Backend URL
	$name = 'mod_iadlearning/iad_backend';
	$title = get_string('iad_backend', 'iad');
	$description = get_string('iad_backend_help', 'iad');
	$setting = new admin_setting_configtext($name, $title, $description, '');
	$settings->add($setting);

	// Backend port
	$name = 'mod_iadlearning/iad_backend_port';
	$title = get_string('iad_backend_port', 'iad');
	$description = get_string('iad_backend_port_help', 'iad');
	$setting = new admin_setting_configtext($name, $title, $description, '');
	$settings->add($setting);

	// Back End non secure connection
	$name = 'mod_iadlearning/iad_backend_nonsecure';
	$title = get_string('iad_backend_nonsecure', 'iadlearning');
	$description = get_string('iad_backend_nonsecure_help', 'iadlearning');
	$setting = new admin_setting_configcheckbox($name, $title, $description, 0);
	$settings->add($setting);

	// Access Key ID
	$name = 'mod_iadlearning/iad_access_key';
	$title = get_string('iad_access_key_id', 'iad');
	$description = get_string('iad_access_key_id_help', 'iad');
	$setting = new admin_setting_configtext($name, $title, $description, '');
	$settings->add($setting);

	// Secret Access key
	$name = 'mod_iadlearning/iad_secret_access_key';
	$title = get_string('iad_secret_access_key', 'iad');
	$description = get_string('iad_secret_access_key_help', 'iad');
	$setting = new admin_setting_configtext($name, $title, $description, '');
	$settings->add($setting);

}
?>
