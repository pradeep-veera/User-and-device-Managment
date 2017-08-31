<!--
	Diese datei zeigt den code für Mysql vorbindung
		-> connect
		-> disconnect
		-> select
		-> update
		-> delete
		-> selectname
		-> startTransaction
		-> commitTransaction
		-> rollbackTransaction
		-> tableExists
-->
<?php

class Database
{
	private $db_host = "localhost";
	private $db_user = "meddevlic_user";
	private $db_pass = "#Dr2meddev";
	private $db_name = "meddevlic";
	public $Admin = "admin";

	private $result = array();

	
	/* Verbindung zur Datenbank */
	public function connect()
    {
        if(!$this->con)
        {
            $this->myconn = mysql_connect($this->db_host,$this->db_user,$this->db_pass);
            if($this->myconn)
            {
                $seldb = mysql_select_db($this->db_name,$this->myconn);
                if($seldb)
                {
                    $this->con = true; 
                    return true; 
                } else
                {
                    return false; 
                }
            } else
            {
                return false; 
            }
        } else
        {
            return true; 
        }
    }

	/*trennen, um Datenbank */
	public function disconnect() 
	{
		if($this->con)
		{
			if(mysql_close())
			{
                $this->con = false; 
				return true; 
			}
			else
			{
				return false; 
			}
		}		
	}
	
	/*überprüfen Sie die Existenz der Tabelle*/
 
	public function tableExists($table)
    {
        $tablesInDb = @mysql_query('SHOW TABLES LIKE "'.$table.'"');
        if($tablesInDb)
        {
            if(mysql_num_rows($tablesInDb)==1)
            {
                return true; 
            }
            else
            { 
                return false; 
            }
        }
    }
	
	public function tableColumns($table)
	{
		$tableCol = @mysql_query('SELECT count(*) FROM information_schema.columns WHERE table_name like "'.$table.'"');
		if($tableCol)
		{
			while($row = mysql_fetch_array($tableCol))
			{
				$nummer = $row[0];
			}
			return $nummer;
		}
	}

	
	/* Wählen Sie die Abfrage für die Tabelle */
	public function select($table, $row_num, $where = null, $order = null, $sort = 0)
    {
		$this->result = "";
		if ($row_num == " " || $row_num == "*") {
			$q = 'SELECT  *  FROM '.$table;
			$tableColNum = $this->tableColumns($table);
		}	
		else 	
			$q = 'SELECT  distinct ' .$row_num. ' FROM '.$table;
        if($where != null){
            $q .= ' WHERE '.$where;
		}	
        if($order != null)
            $q .= ' ORDER BY '.$order;
		if($sort == 1)
			$q .= ' DESC ';
		else if ($sort == 2)
			$q .= ' ASC ';	
        if($this->tableExists($table))
       {
			$query = @mysql_query($q);
			if($query)
			{
				$j = 0;$i = 0;
				while($row = mysql_fetch_array($query))
				{
					if ($row_num == " " || $row_num == "*"){
						for ($i = 0; $i<= $tableColNum; $i++) {
							$this->result[$j] = $row[$i];
							$j++;
						}	
					} else {
						$this->result[$i] = $row[$row_num];
						$i++;
					}	
				}						
				return true;
			}
			else
			{
				return false; 
			}
		}
		else
			return false; 
	}
	
	/*Insert Query */	
	public function insert($table,$values,$rows = null)
	{
		$this->result = "";
        if($this->tableExists($table))
        {
            $insert = 'INSERT INTO '.$table;
            if($rows != null)
            {
                $insert .= ' ('.$rows.')'; 
            }
            for($i = 0; $i < count($values); $i++)
            {
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';	
            $ins = @mysql_query($insert);  
            if($ins)
            {
                return true; 
            }
            else
            {
                return false; 
            }
        }	
	}
	
	/*Delete Query */
	public function delete($table,$where = null)
	{
		$this->result = "";	
	    if($this->tableExists($table))
        {
            if($where == null)
            {
                $delete = 'DELETE '.$table; 
            }
            else
            {
                $delete = 'DELETE FROM '.$table.' WHERE '.$where; 
            }

            $del = @mysql_query($delete);

            if($del)
            {
                return true; 
            }
            else
            {
               return false; 
            }
        }
        else
        {
            return false; 
        }
	}
	
	/*Update Query */
	public function update($table, $row_name, $row_value, $where)
	{
		$this->result = "";	
	    if($this->tableExists($table))
        {
            $update = 'UPDATE '.$table.' SET ';

			if(($row_name && $row_value) && (count($row_name) == count($row_value)))
			{
				$i = count($row_name); 
				while($i>0) {
					$i--;
					if ($i != 0)
						$value .= $row_name[$i].' = "'.$row_value[$i].'",';
					else 
						$value .= $row_name[$i].' = "'.$row_value[$i].'"';	
				}
				$update .=$value;
			}
            $update .= ' WHERE '.$where;
            $query = @mysql_query($update);
            if($query)
            {
                return true; 
            }
            else
            {
                return false; 
            }
        }
        else
        {
            return false; 
        }
	}
	
	/* SELECT-anweisung für die suche */
	public function suche($table,$row = "*" ,$value, $row_name )
	{
		$this->result = "";	
		$i = 0;
		if($this->tableExists($table))
		{
			$q = 'SELECT '.$row.' FROM '.$table;
			if ($value != "" && (count($row_name) ==1 ))
			{
				$q .= ' WHERE ' .$row_name. ' LIKE ' ."'%$value%'";
			}else if ( count($row_name) > 1 )
			{
				for($i = 0; $i < count($row_name); $i++)
				{
					if(is_string($row_name[$i]))
					{
						if ($i == 0)
							$q .= ' WHERE ' .$row_name[$i]. ' LIKE ' ."'%$value%'";
						else 
							$q .= ' OR '.$row_name[$i]. ' LIKE ' ."'%$value%'";
					}
				}
			}

			$query = @mysql_query($q);
			if ($query)
			{
				$i = 0;
				while($row1 = mysql_fetch_array($query))
				{
					$this->result[$i] = $row1[$row];
					$i++;
				}
				return true;
			}else 
				return false;			
		}	
	}
	
	
	/* SELECT-anweisung für die benutzerName (Titel, Vorname, Nachname) */
	public function selectname($table ,$value,$order = 1)
	{
		$this->result = "";	
		if($this->tableExists($table))
		{
			$q = "SELECT CONCAT(' ',Titel,' ',Vorname,' ',Nachname ) As name, Benutzer_Id FROM ".$table;
			if ($value != "")
			{
				$q .= " WHERE (CONCAT_WS(`Titel`,' ',`Vorname`,' ',`Nachname`)) LIKE " ."'%$value%' AND Vorname NOT LIKE 'admin'";			
			}else {
				$q .= " WHERE Vorname NOT LIKE 'admin'";
			}
			if ($order)
			{
				$q .= " ORDER by name ASC";
			}
			echo $query;
			$query = @mysql_query($q);
			if ($query)
			{
				$i = 0;
				while($row1 = mysql_fetch_array($query))
				{
					$this->name[$i] = $row1['name'];
					$this->result[$i] = $row1['Benutzer_Id'];
					$i++;
				}
				return true;
			}else 
				return false;
		}else 
			return false;
	}		
																			// Start Trasaction
	public function startTransaction()
	{
		mysql_query("BEGIN");
	}
																			// Commit Trasaction
	public function commitTransaction()
	{
		mysql_query("COMMIT");			
	}
	public function rollbackTransaction()							
// Rollback Trasaction
	{
		mysql_query("ROLLBACK");		
	}	

	public function getResult()										
	// Get query result
	{
		return $this->result;
	}
	
	public function getBenutzername()									// Get Benutzer name
	{
		return $this->name;
	}	
}

?>	
