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

global $CFG;

defined('MOODLE_INTERNAL') || die();

if ($CFG->version >= 2015111600) {  //Moodle 30

	$plugin->version	= 2016120600;		// The current module version (Date: YYYYMMDDXX)
	$plugin->requires	= 2012120311;		// Requires this Moodle version
	$plugin->cron		= 0;				// Period for cron to check this module (secs)
	$plugin->component	= 'mod_iadlearning';
	$plugin->maturity	= MATURITY_STABLE;
	$plugin->release	= '1.0';			// User-friendly version number

} else {

	$module->version   = 2017020701;	
	$module->requires  = 2012120311;	
	$module->cron      = 0;				
	$module->component = 'mod_iadlearning';		
	$module->maturity = MATURITY_STABLE;
	$module->release = '1.0';
}



