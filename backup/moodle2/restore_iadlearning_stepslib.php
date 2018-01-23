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
 * Defines all the steps required to perform a backuo on the IADLearning activity
 *
 * @package    mod_iadlearning
 * @subpackage backup-moodle2
 * @copyright  www.itoptraining.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

/**
 * Class containing the steps required for the activity restoration
 *
 * @copyright  www.itoptraining.com
 * @author     jose.omedes@itoptraining.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @access public
 */
class restore_iadlearning_activity_structure_step extends restore_activity_structure_step {

    /**
     *  Defines structure for restoration
     *
     * @return stdClass Restoration structure
     */
    protected function define_structure() {
        $paths = array();
        $paths[] = new restore_path_element('iadlearning', '/activity/iadlearning');
        // Return the paths wrapped into standard activity structure.
        return $this->prepare_activity_structure($paths);
    }

    /**
     * Adds restored data to the database
     *
     * @param stdClass $data Information to be inserted in the DB for restoration
     * @return void
     */
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

    /**
     * Post backup operations. Add activity files (if any)
     *
     * @return void
     */
    protected function after_execute() {
        // Add iadlearning related files, no need to match by itemname (just internally handled context).
        $this->add_related_files('mod_iadlearning', 'intro', null);
    }
}
