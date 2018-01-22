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
 * @package    mod_iadlearning
 * @subpackage backup-moodle2
 * @copyright 2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * Define all the restore steps that will be used by the restore_iadlearning_activity_task.
 */
/**
 * Structure step to restore one iadlearning activity.
 */

defined('MOODLE_INTERNAL') || die();

class restore_iadlearning_activity_structure_step extends restore_activity_structure_step {
    protected function define_structure() {
        $paths = array();
        $paths[] = new restore_path_element('iadlearning', '/activity/iadlearning');
        // Return the paths wrapped into standard activity structure.
        return $this->prepare_activity_structure($paths);
    }
    protected function process_iadlearning($data) {
        global $DB;
        $data = (object)$data;
        $data->course = $this->get_courseid();
        // Any changes to the list of dates that needs to be rolled should be same during course restore and course reset.
        // See MDL-9367.
        // insert the iadlearning record.
        $newitemid = $DB->insert_record('iadlearning', $data);
        // Immediately after inserting "activity" record, call this.
        $this->apply_activity_instance($newitemid);
    }
    protected function after_execute() {
        // Add iadlearning related files, no need to match by itemname (just internally handled context).
        $this->add_related_files('mod_iadlearning', 'intro', null);
    }
}
