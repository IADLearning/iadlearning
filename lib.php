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
 * Library of interface functions and constants for iad module
 *
 * All the core Moodle functions needed to allow the module to work integrated in Moodle, should be placed here.
 * All the iad specific functions, needed to implement all the module logic, should go to locallib.php.
 * This will help to save some memory when Moodle is performing actions across all modules.
 *
 * @package     mod_iadlearning
 * @copyright   www.itoptraining.com
 * @author      jose.omedes@itoptraining.com
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @date        2017-02*10
 */

defined('MOODLE_INTERNAL') || die();

/**
 * List of features supported in iadlearning module
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, false if not, null if doesn't know
 */
function iadlearning_supports($feature) {
    switch($feature) {
        case FEATURE_BACKUP_MOODLE2: {
            return true;
        }
        default:{
            return null;
        }
    }
}

/**
 * Add an iad instance.
 *
 * @param stdClass $iad
 * @return int new iad instance id
 */
function iadlearning_add_instance($iad) {
    global $DB;

    // Create the iad.
    $iad->timecreated = time();
    $iad->timemodified = $iad->timecreated;

    return $DB->insert_record('iadlearning', $iad);
}

/**
 * Update iad instance.
 *
 * @param stdClass $iad
 * @return bool true
 */
function iadlearning_update_instance($iad) {
    global $DB;

    // Update the iad.
    $iad->timemodified = time();
    $iad->id = $iad->instance;

    return $DB->update_record('iadlearning', $iad);
}

/**
 * Given an ID of an instance of this module,
 * this function will permanently delete the instance
 * and any data that depends on it.
 *
 * @param int $id
 * @return bool true if successful
 */
function iadlearning_delete_instance($id) {
    global $DB;

    // Ensure the iad exists.
    if (!$DB->get_record('iadlearning', array('id' => $id))) {
        return false;
    }

    // Prepare file record object.
    if (!get_coursemodule_from_instance('iadlearning', $id)) {
        return false;
    }

    $result = true;
    if (!$DB->delete_records('iadlearning', array('id' => $id))) {
        $result = false;
    }

    return $result;
}

/**
 * Returns instances of IADLearning in a given course
 *
 * @param int $id
 * @return object instances found
 */
function iadlearning_get_instances_course($id) {
    global $DB;

    return $DB->get_records('iadlearning', array('course' => $id));

}