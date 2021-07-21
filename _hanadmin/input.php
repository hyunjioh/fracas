<?
exit;
	function strip_quota($str){
		if(substr($str,0,1) == "\""){
			$str = substr($str,1);
		}

		if(substr($str,-1) == "\""){
			$str = substr($str,0,-1);
		}

		$return = $str;
		return $return;
	}

	$mysql['db_host'] = "localhost";
	$mysql['db_user'] = "hanprintkorea";
	$mysql['db_pass'] = "printkorea1004";
	$mysql['db_name'] = "hanprintkorea";

	$connect = mysql_connect($mysql['db_host'], $mysql['db_user'], $mysql['db_pass'],$mysql['db_name']) or die("connection error");
	mysql_select_db($mysql['db_name'],$connect);
	ini_set('memory_limit',-1);
	$filepath = "./temp.csv";

	$pattern = "/(\".*?\")/si";
	$fd =fopen($filepath,"r"); 
	$csv =fread($fd,filesize($filepath)); 
	fclose($fd); 
  $csvArray = explode("\n",$csv);
	for($i=0;$i<count($csvArray)-1;$i++){
		if(preg_match_all ($pattern, $csvArray[$i], $match)){
			foreach($match as $key => $value){
				$returnfield = str_replace($value,str_replace(",","&#44;",$value),$csvArray[$i]);
			}
		}else{
			$returnfield = $csvArray[$i];			
		}
		$values = explode(",",$returnfield);
		



		$req['Subject']  = strip_quota($values[0]);
		$req['Company']  = strip_quota($values[1]);
		$req['UserName'] = strip_quota($values[2]);
		$req['UserAddr'] = strip_quota($values[3]);
		$req['UserTel']  = strip_quota($values[4]);
		$req['UserFax']  = strip_quota($values[5]);
		$req['UserEmail']= strip_quota($values[6]);
		$req['UserHomepage']= strip_quota($values[7]);
		$req['Content']= strip_quota($values[8]);


		$Field = array(
			"BoardID"     => 'Company',
			"Category"    => $req['Category'],
			"Html"        => $req['Html'],
			"Notice"      => $req['Notice'],
			"Secret"      => $req['Secret'],

			"UserID"       => $req['UserID'],
			"UserName"     => $req['UserName'],
			"UserEmail"    => $req['UserEmail'],
			"UserTel"      => $req['UserTel'],
			"UserFax"      => $req['UserFax'],
			"UserHp"       => $req['UserHp'],
			"UserAddr"     => $req['UserAddr'],
			"UserHomepage" => $req['UserHomepage'],
			"Company"      => $req['Company'],
				
			"Link1"       => $req['Link1'],
			"Subject"     => $req['Subject'],
			"Content"     => $req['Content'],

			"Hit"         => $req['Hit'],
			"RegID" 	    => $req['UserID'],
			"RegIP" 	    => $_SERVER['REMOTE_ADDR'],
			"RegDate"     => date("Y-m-d"),
		);


		$Query = "INSERT INTO G_Board (`".implode("`, `", array_keys($Field))."`)  VALUES ('".implode("', '", $Field)."')";		
		$RESULT = mysql_query($Query);

		if(!$RESULT){
			echo "<font color=red>".$Query."</font><br>";			
		}else{
			echo "<font color=blue>".$Query."</font><br>";			
		}
	}
?>