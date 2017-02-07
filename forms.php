<?php




if (!defined('MOODLE_INTERNAL')) {
	die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->libdir.'/formslib.php');

class iad_get_keys_form extends moodleform {
	
	function definition() {

		global $DB, $USER, $CFG;

		$mform =& $this->_form;

		$mform->addElement('header', 'license', get_string('iad_license_info', 'iadlearning'));

		// nombre
		$mform->addElement ( 'text', 'name', get_string ( 'iad_name', 'iadlearning' ), 'maxlength=255, style="width: 40%"' );
		$mform->addRule ( 'name', null, 'required', null, 'license' );
		$mform->setType('name', PARAM_TEXT);

		// surname
		$mform->addElement ( 'text', 'lastname', get_string ( 'iad_lastname', 'iadlearning' ), 'maxlength=255, style="width: 40%"' );
		$mform->addRule ( 'lastname', null, 'required', null, 'license' );
		$mform->setType('lastname', PARAM_TEXT);

		// email
		$mform->addElement ( 'text', 'email', get_string ( 'iad_email', 'iadlearning' ), 'maxlength=255, style="width: 40%"' );
		$mform->addRule ( 'email', null, 'required', null, 'license' );
		$mform->setType('email', PARAM_TEXT);
		
		// password
		$mform->addElement ( 'text', 'institution', get_string ( 'iad_institution', 'iadlearning' ), 'maxlength=255, style="width: 40%"' );
		$mform->addRule ( 'institution', null, 'required', null, 'license' );
		$mform->setType('institution', PARAM_TEXT);
		
		// consumer key
		$mform->addElement ( 'text', 'phone', get_string ( 'iad_phone', 'iadlearning' ), 'maxlength=255, style="width: 40%"' );
		$mform->addRule ( 'phone', null, 'required', null, 'license' );
		$mform->setType('phone', PARAM_TEXT);

		$mform->addElement ( 'hidden', 'id' );
		$mform->setType('id', PARAM_INT);

		// buttons
		$this->add_action_buttons();

	}

	function validation($data, $files){
		$errors = parent::validation($data, $files);

		return $errors;
	}
}