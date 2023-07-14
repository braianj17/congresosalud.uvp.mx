<?php 
class TextArea{
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
		$this->objStructure="<textarea name=\"".$this->Name."\" id=\"".$this->Name."\" class=\"textarea\" onKeyPress=\"return filterInput(3, event, false)\">".$this->value."</textarea>";
		return $this->objStructure;
	}
}

?>