<?
ini_set('memory_limit',-1);
include "../../../core/_lib.php";
include _CORE_PATH_."/system/class.MySQL.php";
$db = new MySQL;
unset($_config);

if($_SERVER['REMOTE_ADDR'] != "211.117.46.197") exit;
#--------------------------------------------------------------------------------------------------/
# 
# ����
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
					if(preg_match_all ($pattern, $csvArray[$i], $match)){ // �ֵ���ǥ���� ���ڿ��� �˻��ؼ� �޸��� �����ϰ� �ִ� ���ڿ��� �˻��Ѵ�.
						foreach($match as $key => $value){
							$returnfield = str_replace($value,str_replace(",","&#44;",$value),$csvArray[$i]); // �޸��� html Ư�����ڷ� ġȯ
						}
					}else{
						$returnfield = $csvArray[$i];			
					}
					$returnfield = str_replace("\"","",$returnfield);
					$field = split(",",addslashes($returnfield)); //�� ���� �޸��� �������� �� �ʵ忡 ������ DB�Է½� ������ ���� �ϱ����ؼ� addslashes�Լ��� �̿��� \�� ���δ�
					$value = "'" . trim(implode("','",$field)) . "'"; //�������� �� �ʵ忡 �յڿ� ������ �A�� ''����ǥ�� ���̰� ,�޸��� ������ ���ٷ� �����.
					$insertSQL = sprintf("INSERT INTO %s (%s) VALUES (%s)", _ZIPCODE_TABLE_, _ZIPCODE_TABLE_FIELD_, $value); // php�������� �̿��ؼ� �Է��Ѵ�.
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
		echo "�̹� ��ϵǾ����ϴ�.";
	}	
}
?>