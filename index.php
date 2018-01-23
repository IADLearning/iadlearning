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
 * Prints the list of iadlearning instances avalilable in a course.
 *
 * @package     mod_iadlearning
 * @copyright   www.itoptraining.com
 * @author      jose.omedes@itoptraining.com
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/lib.php');
require_once($CFG->libdir . '/pagelib.php');

global $CFG, $DB, $OUTPUT, $USER, $PAGE;

$id = required_param('id', PARAM_INT);

// Ensure that the course specified is valid.
if (!$course = $DB->get_record('course', array('id' => $id))) {
    print_error('Course ID is incorrect');
}

require_course_login($course);
$context = context_course::instance($course->id);

$PAGE->set_context($context);
$PAGE->set_url('/mod/iadlearning/index.php', array('id' => $id));
$PAGE->set_pagelayout('incourse');

// Gather existing IADLearning instances present in a course and compile a table.
$instancesexist = false;
$courseiadinstances = iadlearning_get_instances_course($id);

if ($courseiadinstances) {
    $instancesexist = true;
    $data = array();
    foreach ($courseiadinstances as $iadinstance) {
        $row = array("name" => $iadinstance->name, "coursename" => $iadinstance->iad_course_name);
        array_push($data, $row);
    }
}

// UI Messages.
$renderdata = new stdClass();
$renderdata->instancesexist = $instancesexist;
$renderdata->iad_instance_list = get_string('iad_instance_list', 'iadlearning');
$renderdata->iad_instance_name = get_string('iad_instance_name', 'iadlearning');
$renderdata->iad_instance_course = get_string('iad_instance_course', 'iadlearning');
$renderdata->data = $data;

// Actual view page.
echo $OUTPUT->header();

echo $OUTPUT->render_from_template('mod_iadlearning/index', $renderdata);

echo $OUTPUT->footer();