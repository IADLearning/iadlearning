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
 * Activity backup class
 *
 * @package    mod_iadlearning
 * @subpackage backup-moodle2
 * @copyright  www.itoptraining.com
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/iadlearning/backup/moodle2/backup_iadlearning_stepslib.php'); // Because it exists (must).
require_once($CFG->dirroot . '/mod/iadlearning/backup/moodle2/backup_iadlearning_settingslib.php'); // Because it exists (optional).

/**
 * IADlearning backup task that provides all the settings and steps to perform the activity backup
 *
 * @copyright  www.itoptraining.com
 * @author     jose.omedes@itoptraining.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */
class backup_iadlearning_activity_task extends backup_activity_task {



    /**
     * Define (add) particular settings this activity can have.
     */
    protected function define_my_settings() {

        // No particular settings for this activity.
    }

    /**
     * Define (add) particular steps this activity can have.
     */
    protected function define_my_steps() {
        // IADlearning only has one structure step.
        $this->add_step(new backup_iadlearning_activity_structure_step('iadlearning_structure', 'iadlearning.xml'));
    }

    /**
     * Code the transformations to perform in the activity in
     * order to get transportable (encoded) links.
     *
     * @param string $content Link to encode
     *
     * @return string encoded link
     */
    static public function encode_content_links($content) {

        global $CFG;

        $base = preg_quote($CFG->wwwroot, "/");

        // Link to the list of choices.
        $search = "/(".$base."\/mod\/choice\/index.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@CHOICEINDEX*$2@$', $content);

        // Link to choice view by moduleid.
        $search = "/(".$base."\/mod\/choice\/view.php\?id\=)([0-9]+)/";
        $content = preg_replace($search, '$@CHOICEVIEWBYID*$2@$', $content);

        return $content;
    }
}