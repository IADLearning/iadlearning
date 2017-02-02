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
 * Prints the list oof iadlearning instances avalilable in a course
 *
 * @package     mod_iadlearning
 * @copyright   www.itoptraining.com 
 * @author      jose.omedes@itoptraining.com
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @date		2017-01-26
 */


require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/lib.php');
require_once($CFG->libdir . '/pagelib.php');

global $CFG, $DB, $OUTPUT, $USER, $PAGE;

$id = required_param('id', PARAM_INT);

// Ensure that the course specified is valid
if (!$course = $DB->get_record('course', array('id'=> $id))) {
    print_error('Course ID is incorrect');
}

// Set up display page
require_course_login($course);
$context = context_course::instance($course->id);

$PAGE->set_context($context);
$PAGE->set_url('/mod/iadlearning/index.php', array('id' => $id));
$PAGE->requires->css(new moodle_url('http://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css'), true);
$PAGE->requires->js(new moodle_url ('http://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js'), true);
$PAGE->set_pagelayout('incourse');


// Gather existing IADLearning instances present in a course and compile a table
$instances_exist = false;
$course_iad_instances = iadlearning_get_instances_course($id);

if ($course_iad_instances) {
	
	$instances_exist = true;
	$table = new html_table();
	$table->id = "tests";
	$table->align = array('left', 'left');
	$table->size = array('40%', '60%');
	$table->head = array(get_string('iad_instance_name', 'iadlearning'), get_string('iad_instance_course', 'iadlearning'));

	$table->data = array();
	foreach ($course_iad_instances as $iad_instance) {
			$table_row = array($iad_instance->name, $iad_instance->iad_course_name);
			array_push($table->data, $table_row);
	}

}


/*
*   ACTUAL VIEW PAGE
*/

/** Print the page header */
echo $OUTPUT->header();

if ($instances_exist) {

	echo "<br />";
	echo "<h4 style=\"text-align: left\"; color: \"red\">" . get_string('iad_instance_list', 'iadlearning') . ": " .   "</h4>";
	echo "<br />";

	echo html_writer::table($table);

}
else {

	echo "<br />";
	echo "<h4 style=\"text-align: left\"; color: \"red\">" . get_string('iad_instance_none', 'iadlearning') . ". " . "</h4>";
	echo "<br />";

}


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


/** Print the page header */
echo $OUTPUT->footer(); 



?>