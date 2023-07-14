<?php

class mysqlCommand {

    private $cmdText;
    private $connection;
    public $result = array();
    public $numResults;

    public function mysqlCommand() {
        
    }

    public function commandText($cmd) {
        $this->cmdText = $cmd;
    }

    public function connection($con) {
        $this->connection = $con;
    }
    
    	public function ExecuteReader($htmlfilter){
	
		if($htmlfilter==null)
			$htmlfilter = false;

		$query = mysql_query($this->cmdText,$this->connection) or $this->error_message=mysql_error();
        if($query){
			$this->numResults = mysql_num_rows($query);
			
            for($i = 0; $i < $this->numResults; $i++)
            {
                $r = mysql_fetch_array($query);
                $key = array_keys($r);
                for($x = 0; $x < count($key); $x++)
                {
                    // Sanitizes keys so only alphavalues are allowed
                    if(!is_int($key[$x]))
                    {
						if(!$htmlfilter)
							if(mysql_num_rows($query) >= 1)
								$this->result[$i][$key[$x]] = utf8_encode($r[$key[$x]]);
							else
								$this->result = null;
						else
							if(mysql_num_rows($query) >= 1)
								$this->result[$i][$key[$x]] = $r[$key[$x]];
							else 
								$this->result = null;
                    }
                }
            }
			if(is_resource($query))
				mysql_free_result($query);
		}

		return $this->result;	
	}

//    public function ExecuteReader() {
//        $query = mysql_query($this->cmdText, $this->connection);
//        if ($query) {
//            $this->numResults = mysql_num_rows($query);
//
//            for ($i = 0; $i < $this->numResults; $i++) {
//                $r = mysql_fetch_array($query);
//                $key = array_keys($r);
//                for ($x = 0; $x < count($key); $x++) {
//                    // Sanitizes keys so only alphavalues are allowed
//                    if (!is_int($key[$x])) {
//                        if (mysql_num_rows($query) > 1)
//                            $this->result[$i][$key[$x]] = $r[$key[$x]];
//                        else if (mysql_num_rows($query) < 1)
//                            $this->result = null;
//                        else
//                            $this->result[$key[$x]] = $r[$key[$x]];
//                    }
//                }
//            }
//            if (is_resource($query))
//                mysql_free_result($query);
//        }
//
//        return $this->result;
//    }

    public function ExecuteNonEscalar() {
        $tempResult;
        $query = mysql_query($this->cmdText, $this->connection);
        if ($query) {
            $this->numResults = mysql_num_rows($query);

            for ($i = 0; $i < $this->numResults; $i++) {
                $r = mysql_fetch_array($query);
                $key = array_keys($r);
                for ($x = 0; $x < count($key); $x++) {
                    // Sanitizes keys so only alphavalues are allowed
                    if (!is_int($key[$x])) {
                        if (mysql_num_rows($query) > 1)
                            $tempResult[$i][$key[$x]] = $r[$key[$x]];
                        else if (mysql_num_rows($query) < 1)
                            $tempResult = null;
                        else
                            $tempResult[$key[$x]] = $r[$key[$x]];
                    }
                }
            }


            ### prepare result
            if ($this->numResults > 1) {
                $this->result = $tempResult;
            } else {
                if ($this->numResults > 0) {
                    array_push($this->result, $tempResult);
                }
            }

            ### end prepare result
            if (is_resource($query))
                mysql_free_result($query);
        }

        return $this->result;
    }

    public function ExecuteFetchRow() {
        $tempResult;
        $query = mysql_query($this->cmdText, $this->connection);
        if ($query) {
            $this->numResults = mysql_num_rows($query);

            for ($i = 0; $i < $this->numResults; $i++) {
                $r = mysql_fetch_array($query);
                $key = array_keys($r);
                for ($x = 0; $x < count($key); $x++) {
                    // Sanitizes keys so only alphavalues are allowed
                    if (!is_int($key[$x])) {
                        if (mysql_num_rows($query) > 1)
                            $tempResult[$i][$x] = $r[$key[$x]];
                        else if (mysql_num_rows($query) < 1)
                            $tempResult = null;
                        else
                            $tempResult[$x] = $r[$key[$x]];
                    }
                }
            }


            ### prepare result
            if ($this->numResults > 1) {
                $this->result = $tempResult;
            } else {
                if ($this->numResults > 0) {
                    array_push($this->result, $tempResult);
                }
            }

            ### end prepare result
            if (is_resource($query))
                mysql_free_result($query);
        }

        return $this->result;
    }

    public function ExecuteDictionary() {
        $query = mysql_query($this->cmdText, $this->connection);
        if ($query) {
            $this->numResults = mysql_num_rows($query);
            for ($i = 0; $i < $this->numResults; $i++) {
                $r = mysql_fetch_array($query);
                $this->result[$r["key_field"]] = $r["value_field"];
            }
            if (is_resource($query))
                mysql_free_result($query);
        }
        return $this->result;
    }

    public function ExecuteNonQuery() {
        $affected_rows = 0;
        try {
            $query = mysql_query($this->cmdText, $this->connection);
            if ($query) {
                $affected_rows = mysql_affected_rows($this->connection);
                if (is_resource($query))
                    mysql_free_result($query);
            }else {
                //echo @mysql_error();
            }
        } catch (Exception $ex) {
            throw new Exception("Error en la instrucción");
        }

        return $affected_rows;
    }

    public function ExecuteValidator($table, $filter = array()) {
        $row_exists = false;
        $filter_string = implode(" AND ", $filter);
        $query_string = "SELECT * FROM " . $table . " where " . $filter_string;
        try {
            $query = mysql_query($query_string, $this->connection);
            if ($query) {
                if (mysql_num_rows($query) > 0) {
                    $row_exists = true;
                }
                if (is_resource($query))
                    mysql_free_result($query);
            }
        } catch (Exception $ex) {
            throw new Exception("Error en la instrucción");
        }
        return $row_exists;
    }

    public function MessageBox($flag, $Message) {
        switch ($flag) {
            case "1":
                echo "Se agrego un registro<br>";
                break;
            case "2":
                echo "No se agrego el registro<br>";
                break;
            case "3":
                echo "Ya existe el registro<br>";
                break;
            default:
                echo $Message . "<br>";
                break;
        }
    }

}

?>