<?php
// This file is part of Wiziq - http://www.wiziq.com/
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
 * Defines the version of iad module
 *
 * @package    mod_iadlearning
 * @copyright  www.itoptraining.com 
 * @author     jose.omedes@itoptraining.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

if ($CFG->version >= 2015111600) {  //Moodle 3.0

	$plugin->version   = 2017012601;			// The current module version (Date: YYYYMMDDXX)
	$plugin->requires  = 2012120311;			// Requires this Moodle version
	$plugin->component = 'mod_iadlearning';		// Full name of the plugin (used for diagnostics)
	$plugin->cron      = 0;
	$plugin->maturity = MATURITY_STABLE;
	$plugin->release = '1.0';

} else { 

	$module->version   = 2016090901;			// The current module version (Date: YYYYMMDDXX)
	$module->requires  = 2012120311;			// Requires this Moodle version
	$module->component = 'mod_iadlearning';		// Full name of the plugin (used for diagnostics)
	$module->cron      = 0;
	$module->maturity = MATURITY_STABLE;
	$module->release = '1.0';
	
}
