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



function xmldb_iad_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if($oldversion < 2015041501) {
    	$table = new xmldb_table('iad');
    	$field = new xmldb_field('iad_course_name', XMLDB_TYPE_CHAR, '256',null, null, null, null, null);

    	if(!$dbman->field_exists($table, $field)) {
    		// Adds the column 'iad_course_name'
    		$dbman->add_field($table, $field);
    	}

    	upgrade_plugin_savepoint(true, 2015041501, 'mod', 'iad');
    }

    return true;
}
?>