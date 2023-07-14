<?php
class dataCollection{
	public $con;
	public $cmd;

	public function __construct($cmd,$con){
		$this->cmd=$cmd;
		$this->con=$con;		
	}
	
	public function dictionary($table,$key_field,$value_field,$filter=array()){
		$result=array();
		$query_filter="";	
		if(count($filter)>0){
			$filter_string=implode(" AND ",$filter);
			$query_filter=" WHERE ".$filter_string;
		}
		$query_string="SELECT ".$key_field." as key_field,".$value_field." as value_field FROM ".$table.$query_filter;
		$cmd= new mysqlCommand();
		$this->cmd->commandText($query_string);
		$this->cmd->connection($this->con);
		$result=$this->cmd->ExecuteNonEscalar();
		return $result;	
	}

	public function EscalarDictionary($start,$end){
		$result=array();
		for($i=$start; $i<=$end; $i++){
			array_push($result,array("key_field"=>$i,"value_field"=>$i));
	
		}
		return $result;	
	}

	public function MonthDictionary(){
		$MONTHS=array("01"=>"Ene","02"=>"Feb","03"=>"Mar","04"=>"Abr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Ago","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dic");
		$result=array();
		foreach($MONTHS as $key=>$val){
			array_push($result,array("key_field"=>$key,"value_field"=>$val));
	
		}
		return $result;	
	}

	public function DayDictionary(){
		$DAYS=array("01"=>"01","02"=>"02","03"=>"03","04"=>"04","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24","25"=>"25","26"=>"26","27"=>"27","28"=>"28","29"=>"29","30"=>"30","31"=>"31");
		$result=array();
		foreach($DAYS as $key=>$val){
			array_push($result,array("key_field"=>$key,"value_field"=>$val));
	
		}
		return $result;	
	}

	public function TimeDictionary(){
		$TIME=array("00"=>"00","01"=>"01","02"=>"02","03"=>"03","04"=>"04","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24","25"=>"25","26"=>"26","27"=>"27","28"=>"28","29"=>"29","30"=>"30","31"=>"31","32"=>"32","33"=>"33","34"=>"34","35"=>"35","36"=>"36","37"=>"37","38"=>"38","39"=>"39","40"=>"40","41"=>"41","42"=>"42","43"=>"43","44"=>"44","45"=>"45","46"=>"46","47"=>"47","48"=>"48","49"=>"49","50"=>"50","51"=>"51","52"=>"52","53"=>"53","54"=>"54","55"=>"55","56"=>"56","57"=>"57","58"=>"58","59"=>"59");
		$result=array();
		foreach($TIME as $key=>$val){
			array_push($result,array("key_field"=>$key,"value_field"=>$val));
	
		}
		return $result;	
	}

	public function HourDictionary(){
		$HOUR=array("00"=>"00","01"=>"01","02"=>"02","03"=>"03","04"=>"04","05"=>"05","06"=>"06","07"=>"07","08"=>"08","09"=>"09","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23");
		$result=array();
		foreach($HOUR as $key=>$val){
			array_push($result,array("key_field"=>$key,"value_field"=>$val));
	
		}
		return $result;	
	}


	public function genericDictionary($table,$key_field,$value_field,$filter=array()){
		$result=array();
		$query_filter="";	
		if(count($filter)>0){
			$filter_string=implode(" AND ",$filter);
			$query_filter=" WHERE ".$filter_string;
		}
		$query_string="SELECT ".$key_field." as key_field,".$value_field." as value_field FROM ".$table.$query_filter;
		$this->cmd->commandText($query_string);
		$this->cmd->connection($this->con);
		$result=$this->cmd->executeDictionary();
		return $result;	
	}
	
	
}

?>