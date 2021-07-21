<?
ini_set('memory_limit',-1);
include "../../../core/_lib.php";
include _CORE_PATH_."/system/class.MySQL.php";
$db = new MySQL;
unset($_config);

if($_SERVER['REMOTE_ADDR'] != "211.117.46.197") exit;
#--------------------------------------------------------------------------------------------------/
# 
# 설정
define("_ZIPCODE_CSV_FILE_", dirname(__FILE__)."/zipcode_20090929.csv");
define("_ZIPCODE_TABLE_FIELD_","`zipcode`,`sido`,`gugun`,`dong`,`bunji`,`seq`");
#
#--------------------------------------------------------------------------------------------------/

#--------------------------------------------------------------------------------------------------/
# 

$Query = "
CREATE TABLE IF NOT EXISTS `ZIPCODE` (
  `zipcode` varchar(7) NOT NULL default '',
  `sido` varchar(8) NOT NULL default '',
  `gugun` varchar(30) NOT NULL default '',
  `dong` varchar(104) NOT NULL default '',
  `bunji` varchar(34) NOT NULL default '',
  `seq` int(11) NOT NULL default '0'
)";
$db -> ExecQuery($Query);

$CHECK = $db -> CheckTable(_ZIPCODE_TABLE_);
#
#--------------------------------------------------------------------------------------------------/

if($CHECK == 1){
	$CHECK2 = $db -> Total("Select Count(*) From "._ZIPCODE_TABLE_);
	if($CHECK2 == 0){

		echo "<pre>";
		$pattern = "/(\".*?\")/si";
		$handle   = fopen(_ZIPCODE_CSV_FILE_,"r"); 
		$contents = fread($handle ,filesize(_ZIPCODE_CSV_FILE_)); 
		fclose($handle); 

		$csvArray = explode("\n",$contents);
		for($i=1;$i<count($csvArray);$i++) {
			if(isset($csvArray[$i])){
				if(trim($csvArray[$i]) != ""){
					if(preg_match_all ($pattern, $csvArray[$i], $match)){ // 쌍따옴표안의 문자열을 검색해서 콤마를 포함하고 있는 문자열을 검색한다.
						foreach($match as $key => $value){
							$returnfield = str_replace($value,str_replace(",","&#44;",$value),$csvArray[$i]); // 콤마를 html 특수문자로 치환
						}
					}else{
						$returnfield = $csvArray[$i];			
					}
					$returnfield = str_replace("\"","",$returnfield);
					$field = split(",",addslashes($returnfield)); //각 행을 콤마를 기준으로 각 필드에 나누고 DB입력시 에러가 없게 하기위해서 addslashes함수를 이용해 \를 붙인다
					$value = "'" . trim(implode("','",$field)) . "'"; //나누어진 각 필드에 앞뒤에 공백을 뺸뒤 ''따옴표를 붙이고 ,콤마로 나눠서 한줄로 만든다.
					$insertSQL = sprintf("INSERT INTO %s (%s) VALUES (%s)", _ZIPCODE_TABLE_, _ZIPCODE_TABLE_FIELD_, $value); // php쿼리문을 이용해서 입력한다.
		//			echo $i." => ".$value."<br>";
		//			echo $i." => ".$insertSQL."<br>";
		//			$result=mysql_query($insertSQL,$connect);
					$Result = $db -> ExecQuery($insertSQL);
					if(!$Result){
						echo $insertSQL."<br>";
					}
				}
			}
		}
		echo "</pre>";
	}else{
		echo "이미 등록되었습니다.";
	}	
}
?>