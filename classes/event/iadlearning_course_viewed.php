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
 * Handles iadlearning events
 *
 * @package     mod_iadlearning
 * @copyright   www.itoptraining.com
 * @author      jose.omedes@itoptraining.com
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @date        2017-01-26
 */

namespace mod_iadlearning\event;

defined('MOODLE_INTERNAL') || die();

/**
 * The mod_wiziq session viewed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string error: the wiziq error in case any.
 * }
 *
 * @package    mod_wiziq
 * @since      Moodle 2.7
 * @copyright  www.wiziq.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class iadlearning_course_viewed extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'iadlearning';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventACCESSIADCOURSE', 'mod_iadlearning');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return sprintf(get_string("eventACCESSIADCOURSEdesc", "mod_iadlearning"), $this->userid,
            $this->objectid, $this->relateduserid,
            $this->contextinstanceid, $this->other['error']);
    }

    /**
     * Returns relevant URL.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/mod/iadlearning/view.php', array('id' => $this->courseid));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'iadlearning', get_string('eventACCESSIADCOURSE',
            'mod_iadlearning'), 'view.php?id=' . $this->courseid,
            $this->other['error'], $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (!isset($this->courseid)) {
            throw new \coding_exception('The \'courseid\' value must be set in other.');
        }
    }
}
