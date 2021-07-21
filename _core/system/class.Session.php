<?php 
	if(!defined("db_host")){
		define("db_host",$mysql1['db_host']);
		define("db_user",$mysql1['db_user']);
		define("db_pass",$mysql1['db_pass']);
		define("db_name",$mysql1['db_name']);
	}
	$mytimeout = 60 * 60 * 24; 
	ini_set('session.gc_maxlifetime', $mytimeout);



class session { 
	// session-lifetime 
	var $lifeTime; 
	// mysql-handle 
	var $dbHandle; 
	function open($savePath, $sessName) { 
	 // get session-lifetime 
	 $this->lifeTime = get_cfg_var("session.gc_maxlifetime"); 
	 // open database-connection 
	 $dbHandle = @mysql_connect(db_host,db_user,db_pass); 
	 $dbSel = @mysql_select_db(db_name,$dbHandle); 
	 // return success 
	 if(!$dbHandle || !$dbSel) 
			 return false; 
	 $this->dbHandle = $dbHandle; 
	 return true; 
	} 

	function close() { 
		$this->gc(ini_get('session.gc_maxlifetime')); 
		// close database-connection 
		return @mysql_close($this->dbHandle); 
	} 

	function read($sessID) { 
		// fetch session-data 
		$res = @mysql_query("SELECT sdata AS d FROM G_SESSION 
												WHERE session_id = '$sessID' 
												AND session_expires > ".time(),$this->dbHandle); 
		// return data or an empty string at failure 
    if(!is_resource($res)){
      $table = "G_SESSION";
      $exists = mysql_query('SHOW TABLES FROM `'.db_name.'` LIKE \''.$table.'\'', $this->dbHandle);

      if(mysql_num_rows($exists) < 1){
        $Query = "
          CREATE TABLE IF NOT EXISTS `G_SESSION` (
            `session_id` varchar(32) NOT NULL,
            `sdata` text NOT NULL,
            `session_expires` int(11) NOT NULL,
            KEY `session_id` (`session_id`)
          )          
        ";
        mysql_query($Query);
        echo "<meta http-equiv=Refresh content='0'>";
        exit;
      }
    }else{
  		if($row = mysql_fetch_assoc($res)) 
	  			return $row['d']; 
    }
		return ""; 
	} 

	function write($sessID,$sessData) { 


		// new session-expire-time 
		$newExp = time() + $this->lifeTime; 
		// is a session with this id in the database? 
		$res = mysql_query("SELECT * FROM G_SESSION 
												WHERE session_id = '$sessID'",$this->dbHandle); 
		// if yes, 
		if(mysql_num_rows($res)) { 
			// ...update session-data 
			mysql_query("UPDATE G_SESSION 
									 SET session_expires = '$newExp', 
									 sdata = '$sessData' 
									 WHERE session_id = '$sessID'",$this->dbHandle); 

			// if something happened, return true 
			if(mysql_affected_rows($this->dbHandle)) 
					return true; 
		} 
		// if no session-data was found, 
		else { 
			// create a new row 
			$res = @mysql_query("INSERT INTO G_SESSION ( 
									 session_id, 
									 session_expires, 
									 sdata) 
									 VALUES( 
									 '$sessID', 
									 '$newExp', 
									 '$sessData')",$this->dbHandle); 
			// if row was created, return true 
      if(!is_resource($res)){
        $table = "G_SESSION";
        $exists = mysql_query('SHOW TABLES FROM `'.db_name.'` LIKE \''.$table.'\'', $this->dbHandle);

        if(mysql_num_rows($exists) < 1){
          $Query = "
            CREATE TABLE IF NOT EXISTS `G_SESSION` (
              `session_id` varchar(32) NOT NULL,
              `sdata` text NOT NULL,
              `session_expires` int(11) NOT NULL,
              KEY `session_id` (`session_id`)
            )          
          ";
          mysql_query($Query);
          echo "<meta http-equiv=Refresh content='0'>";
          exit;
        }
      }else{
			  if(mysql_affected_rows($this->dbHandle)) 
					return true; 
      }
		} 
		// an unknown error occured 
		return false; 
	} 
	function destroy($sessID) { 
		// delete session-data 
		mysql_query("DELETE FROM G_SESSION WHERE session_id = '$sessID'",$this->dbHandle); 
		// if session was deleted, return true, 
		if(mysql_affected_rows($this->dbHandle)) 
				return true; 
		// ...else return false 
		return false; 
	} 
	function gc($sessMaxLifeTime) { 
		// delete old sessions 
		mysql_query("DELETE FROM G_SESSION WHERE session_expires < ".time(),$this->dbHandle); 
		// return affected rows 
		return mysql_affected_rows($this->dbHandle); 
	} 
} 
$_SESSION = new session(); 
session_set_save_handler(array(&$_SESSION,"open"), 
                         array(&$_SESSION,"close"), 
                         array(&$_SESSION,"read"), 
                         array(&$_SESSION,"write"), 
                         array(&$_SESSION,"destroy"), 
                         array(&$_SESSION,"gc")); 

//session_id($sid);


//  get session id of an existing session
$sid = time().str_replace(".","",$_SERVER['REMOTE_ADDR']).rand(1111,9999);

session_start(); 


?>