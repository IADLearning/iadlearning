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
 * Defines all the steps required to perform a backup on the IADLearning activity
 *
 * @package    mod_iadlearning
 * @subpackage backup-moodle2
 * @copyright  www.itoptraining.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


/**
 * Class containing the steps required for the activity backup
 *
 * @copyright  www.itoptraining.com
 * @author     jose.omedes@itoptraining.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */
class backup_iadlearning_activity_structure_step extends backup_activity_structure_step {

    /**
     *  Defines structure for backup
     *
     * @return stdClass backup structure
     */
    protected function define_structure() {

        // Define each element separated.
        $iadlearning = new backup_nested_element('iadlearning', array('id'), array(
            'name', 'intro', 'introformat', 'timecreated',
            'timemodified', 'creator_id', 'iad_course', 'iad_course_name'));

        // Build the tree.

        // Define sources.
        $iadlearning->set_source_table('iadlearning', array('id' => backup::VAR_ACTIVITYID));

        // Define id annotations.
        $iadlearning->annotate_ids('user', 'creator_id');

        // Define file annotations.
        $iadlearning->annotate_files('mod_iadlearning', 'intro', null, null);

        // Return the root element (iadlearning), wrapped into standard activity structure.
        return $this->prepare_activity_structure($iadlearning);

    }
}