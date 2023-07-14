<?php 
include_once "mssql_connection.php";
include_once "mssqlCommand.php";

class dataCollection{
	public $mssql,$con;

	public function __construct($host,$user,$passwd,$initial_catalog){
		$this->mssql = new mssqlCnx($host,$user,$passwd,$initial_catalog);
		$this->con=$this->mssql->Open();		
	}
	
	public function dictionary($table,$key_field,$value_field,$filter=array()){
		$result=array();
		$query_filter="";	
		if(count($filter)>0){
			$filter_string=implode(" AND ",$filter);
			$query_filter=" WHERE ".$filter_string;
		}
		$query_string="SELECT ".$key_field." as key_field,".$value_field." as value_field FROM ".$table.$query_filter;
		$cmd= new mssqlCommand($query_string,$this->con);
		$result=$cmd->executeReader();
                //echo 'count'.$cmd->numResults;
		if($cmd->numResults>0){
			if($cmd->numResults>=1){
                            //echo $result[0]['value_field'];
                            
				return $result;	
			}else{
				$result_full=array();
				array_push($result_full,$result);
				return $result_full;
			}
		}else{
			return null;
		}
	}

	public function odictionary($table,$key_field,$value_field,$filter=array(),$order){
		$result=array();
		$query_filter="";	
		if(count($filter)>0){
			$filter_string=implode(" AND ",$filter);
			$query_filter=" WHERE ".$filter_string;
		}
		$query_string="SELECT ".$key_field." as key_field,".$value_field." as value_field FROM ".$table.$query_filter." order by ".$order;
		$cmd= new mssqlCommand($query_string,$this->con);
		$result=$cmd->executeReader();
		
		if($cmd->numResults>1){
			return $result;	
		}else{
			$result_full=array();
			array_push($result_full,$result);
			return $result_full;
		}
	}


	public function genericDictionary($table,$key_field,$value_field,$filter=array()){
		$result=array();
		$query_filter="";	
		if(count($filter)>0){
			$filter_string=implode(" AND ",$filter);
			$query_filter=" WHERE ".$filter_string;
		}
		$query_string="SELECT ".$key_field." as key_field,".$value_field." as value_field FROM ".$table.$query_filter;
		$cmd= new mssqlCommand($query_string,$this->con);
		$result=$cmd->executeDictionary();
		return $result;	
	}
	
	
}

?>