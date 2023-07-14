<?php 
class TextBox{
	private $Name;
	public $value;
	
	public function __construct($objName){
		$this->Name=$objName;
	}

	public function getValue($defaultValue){
		if(isset($_POST[$this->Name]) && $_POST[$this->Name]!=$defaultValue){
			$value=$_POST[$this->Name];
		}else{
			$value=$defaultValue;
		}
		return $value;
	}
	
	public function setValue($value){
		$this->value=$value;	
	}
	
	public function Dispose(){
		$this->objStructure="<input type=\"text\" name=\"".$this->Name."\" id=\"".$this->Name."\" value=\"".$this->value."\" class=\"longinput\" onKeyPress=\"return filterInput(3, event, false)\">";
		return $this->objStructure;
	}
}

?>