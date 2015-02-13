<?php 

class States {
	private static $the_states = array( 'Alabama','Alaska','Arizona','Arkansas','California','Colorado',
		'Connecticut','Delaware','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas',
		'Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan','Minnesota','Mississippi',
		'Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York',
		'North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island',
		'South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington',
		'West Virginia','Wisconsin','Wyoming');
	
	public static function echoSelectOptions() {
		echo 'function reached';
		foreach (self::$the_states as $state) {
			echo '<option value ="'.$state.'">'.$state.'</option>'; 
		}
	}

	public static function validateState($otherState) {
		//an awesome linear search
		foreach(self::$the_states as $state) {
			if ($otherState === $state) {
				return true;
			}
		}
		return false;
	}
}
?>