<?php
class service extends c_controller {
	
	public $result;
	public $template;
	
	function __construct($format) {
		
		if (method_exists ( $this, parent::route () )) {
			$this->{parent::route ()} ();
		} else {
			parent::controllerErrorHandler ();
		}
	
	}
	
	function controllerCreateHelp() {
	
	}
	
	
	function controllerCreateCategory() {
	
	}
	
	function controllerEditHelp() {
	
	}
	
	function controllerEditCategory() {
	
	}
	
	function controllerViewHelp() {
		echo "service view help";
	}
	
	private function formatCallResult() {
		$this->template = "404error.tpl";
	}
}