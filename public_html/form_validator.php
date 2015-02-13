<?php

require_once 'states.php';

class Form_Validator {

	public $errors = array();
	public $sanitized = array();
	private $raw_data = array();
	private $validation_rules = array();

	/*
	@param $rules_array an associative array of form variable names and rules to validate with.
		$rules_array has the following form:

		$rules_array = array(
        'pin'=>array('rule_to_use'=>'pin', 'required'=>true, 'pretty_string' => 'Pin Number'),
        'credit_card'=>array('rule_to_use'=>'pin', 'required'=>true, 'pretty_string' => 'Pin Number');

	@param $data_array an array of form raw form data, typically $_POST
	*/
	public function __construct($rules_array, $data_array) {
		$this->validation_rules = $rules_array;
		$this->raw_data = $data_array;
	}

	/*
	Validates and santizes form data.
	Puts sanitized output in the $sanitized associative array.
	Puts input error messages in the $errors associative array.
	Returns true if no error messages generated, false otherwise.
	*/
	public function validateAndSanitizeForm() {
		foreach ($this->validation_rules as $varname => $rule_and_options) {

			//if form field is empty
			if (empty($this->raw_data[$varname])) {
				//if rule is required
				if (array_key_exists('required', $rule_and_options)) {
					$this->errors[$varname] = $rule_and_options['pretty_name'] . " is required";
				}
				continue;
			}

			//else if form field is not empty, validate and sanitized
			switch($rule_and_options['rule_name']) {
				case 'login_name':
					$this->processLoginName($varname, $rule_and_options['pretty_name']);
					break;
				case 'pin':
					$this->processPin($varname, $rule_and_options['pretty_name']);
					break;
				case 'retype_pin':
					$this->processPin($varname, $rule_and_options['pretty_name']);
					
					//note: in the form if a retype_pin is present, the name of the other pin variable must be 'pin'
					if ($this->raw_data['retype_pin'] !== $this->raw_data['pin']) {
						$this->errors['retype_pin'] = "Pins did not match";
					}
					break;
				case 'string':
					$this->processString($varname);
					break;
				case 'zipcode':
					$this->processZipcode($varname);
					break;
				case 'credit_card_type':
					$this->processCreditCardType($varname);
					break;
				case 'credit_card_number':
					$this->processCreditCardNumber($varname);
					break;
				case 'credit_card_expiration_date':
					$this->processCreditCardExpirationDate($varname);
					break;
				case 'state':
					$this->processState($varname);
					break;
				default:
			}
		}
		if (count($this->errors) === 0) {
			return true;
		}
		return false;
	}

	private function processLoginName($varname, $pretty_string) {
		//if login name doesn't contain only letters, numbers, or underscores
		if (!filter_var($this->raw_data[$varname], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\w*$/")))) {
			$this->errors[$varname] = "$pretty_string must only contain letters, numbers, or underscores";
		}
		//even if login is invalid we sanitize it so we can safely redisplay what the user typed in the form
		$this->sanitized[$varname] = filter_var($this->raw_data[$varname], FILTER_SANITIZE_STRING);	
	}
	
	private function processPin($varname, $pretty_name) {
		//sanitize pin
		$this->sanitized[$varname] = filter_var($this->raw_data[$varname], FILTER_SANITIZE_STRING);

		//pin is invalid if it does not match sanitized pin
		if($this->raw_data[$varname] !== $this->sanitized[$varname]){
			$this->errors[$varname] = "$pretty_name must not contain html tags";
		}
	}

	private function processString($varname) {
		$this->sanitized[$varname] = filter_var($this->raw_data[$varname], FILTER_SANITIZE_STRING);
	}

	private function processZipcode($varname) {
		if (!filter_var($this->raw_data[$varname], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{5}(?:-\d{4})?$/")))) {
			$this->errors[$varname] = "Invlaid Zipcode format";
		}
		//even if zipcode is invalid we sanitize it so we can safely redisplay what the user typed in the form
		$this->sanitized[$varname] = filter_var($this->raw_data[$varname], FILTER_SANITIZE_STRING);	
	}

	private function processCreditCardNumber($varname) {
		if (!filter_var($this->raw_data[$varname], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^\d{16,19}$/")))) {
			$this->errors[$varname] = "Credit Card Number must be between 13 and 19 digits long";
		}
		$this->sanitized[$varname] = filter_var($this->raw_data[$varname], FILTER_SANITIZE_NUMBER_INT);
	}

	private function processCreditCardExpirationDate($varname) {

		if (!filter_var($this->raw_data[$varname], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"#^\d{2}/\d{2}$#")))) {
			$this->errors[$varname] = "Expiration Date must have format MM/YY";
		}
		$this->sanitized[$varname] = filter_var($this->raw_data[$varname], FILTER_SANITIZE_STRING);
	}

	private function processState($varname) {
		if(States::validateState($this->raw_data[$varname])) {
			$this->sanitized[$varname] = $this->raw_data[$varname];
		} else {
			$this->errors[$varname] = "Choose a State";
		}
	}

	private function processCreditCardType($varname) {
		if (array_search($this->raw_data[$varname], array ("MASTER", "DISCOVER", "VISA")) !== false){
			$this->sanitized[$varname] = $this->raw_data[$varname];
		} else {
			$this->errors[$varname] = "Choose a Credit Card Type";
		}
	}

	public function printSanitizedValues() {
		foreach ($this->sanitized as $varname => $value) {
			echo '<br>' . $varname . ' =' .$value;
		}
	}	

	public function printErrors() {
		foreach ($this->errors as $varname => $value) {
			echo '<br>' . $value;
		}
	}
}
?>
