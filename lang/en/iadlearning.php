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
 * English strings for iad module
 *
 * @package    mod_iadlearning
 * @copyright  www.itoptraining.com
 * @author     jose.omedes@itoptraining.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'IADLearning';
$string['pluginadministration'] = 'IADLearning administration';
$string['load_courses'] = 'Load courses';
$string['iadconnectsettings'] = 'IADLearning connection settings';
$string['linkname'] = 'access to the course';
$string['modulename'] = 'IADLearning';
$string['modulenameplural'] = 'IADLearning';
$string['modulename_help'] = 'This module enables access to IADLearning from Moodle.';
$string['pluginadministration'] = 'IAD Administration';
$string['select_course'] = 'Select course';
$string['iad_ip'] = 'IP address';
$string['iad_ip_help'] = 'IADLearning\'s IP address.';
$string['iad_ip_help'] = 'IADLearning\'s IP address.';
$string['secret_key'] = 'Secret key';
$string['access_key'] = 'Access key';
$string['settings_error'] = 'Some module settings are not configured. Please, contact your system administrator';
$string['course_access'] = 'Click on the following link to ';
$string['iad_frontend'] = 'Front End Address';
$string['iad_frontend_port'] = 'Front End Connection Port';
$string['iad_frontend_nonsecure'] = 'Front End allows non HTTPS connection';
$string['iad_backend_nonsecure'] = 'Front End allows non HTTPS connection';
$string['iad_frontend_help'] = 'IADLearning Front End URL';
$string['iad_frontend_port_help'] = 'TCP/IP Connection Port used to access IADLearning Front End';
$string['iad_frontend_nonsecure_help'] = 'Click this option if you Front End connection does not require HTTPS';
$string['iad_backend_nonsecure_help'] = 'Click this option if you Back End connection does not require HTTPS';
$string['iad_backend'] = 'Back End Addresss';
$string['iad_backend_port'] = 'Back End Connection Port';
$string['iad_backend_help'] = 'IADLearning Back End URL (using http/https)';
$string['iad_backend_port_help'] = 'TCP/IP Connection Port used to access IADLearning Back End';
$string['iad_access_key_id'] = 'Access Key ID';
$string['iad_access_key_id_help'] = 'Access Key Identifier';
$string['iad_secret_access_key'] = 'Secret Access Key';
$string['iad_secret_access_key_help'] = 'Secret Access Key (provided by the administrator)';
$string['selected_course'] = 'Course selected previously';
$string['login_failed'] = 'There was an error with the combination of email and password. Please, try again';
$string['view_failed'] = 'There was an error when connecting to the course contents. Please, try again';

$string['iad_activity'] = 'Activity';
$string['iad_access_activity'] = 'Access Activity Content';
$string['iad_activity_info'] = 'Activity Information:';
$string['iad_last_access'] = 'Last Access';
$string['iad_last_access_unable'] = 'Unable to contact server to find out last access to this activity';
$string['iad_no_last_access'] = 'NEVER';
$string['iad_test_info'] = 'Tests Information:';
$string['iad_test_no_info'] = 'No test information available yet';

$string['iad_test_id'] = 'Test ID';
$string['iad_test_title'] = 'Test Title';
$string['iad_test_attempts'] = 'Number of Attempts';
$string['iad_test_score'] = 'Current Score';

$string['iad_test_user'] = 'User Name';

$string['iad_instance_list'] = 'List of IADLearning activities in the course:';
$string['iad_instance_name'] = 'Activity Name';
$string['iad_instance_course'] = 'IADLearning Course';
$string['iad_instance_none'] = 'There are no IADLearning activities in this course';


$string['iad_dt_search'] = 'Search:';
$string['iad_dt_first'] = 'First';
$string['iad_dt_previous'] = 'Previous';
$string['iad_dt_next'] = 'Next';
$string['iad_dt_last'] = 'Last';
$string['iad_dt_info'] = 'Showing _START_ to _END_ of _TOTAL_ elements';
$string['iad_dt_infoEmpty'] = 'Showing 0 to 0 of 0 elements';
$string['iad_dt_lengthMenu'] = 'Showing _MENU_ elements';

$string['iad_license_info'] = 'IADLearning License Information';
$string['iad_name'] = 'Name';
$string['iad_lastname'] = 'Lastname';
$string['iad_email'] = 'E-mail address';
$string['iad_institution'] = 'Institution';
$string['iad_phone'] = 'Phone Number';
$string['iad_credentials'] = 'IADLearning Access Credentials';
$string['iad_username'] = 'Username';
$string['iad_pass'] = 'Password';
$string['iad_autoprovisioning_error'] = 'There has been an error when retreiving your credentials.';
$string['iad_servercontact_error'] = 'There has been an error connecting to IADLearning server.';

$string['iad_get_demo_keys'] = 'Obtain demo keys';

$string['error_in_service'] = 'Error connecting to remote system';
$string['format_error'] = 'This field requires a different format';
$string['creator_id_error'] = 'The course creator ID should match your user ID';
$string['iad_course_error'] = 'The course ID is not valid';
$string['iad_course_name_error'] = 'The course name is not valid';

// Events.
$string['eventACCESSACTIVITY'] = 'Access to Activity Content';
$string['eventACCESSIADCOURSE'] = 'Access to IADLearning Course';
$string['eventACCESSIADCOURSEdesc'] = 'User accessed the IAD Learning Course where the Moodle activity is pointing to';