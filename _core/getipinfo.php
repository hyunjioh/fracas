<?
header("Content-Type: text/html; charset=utf-8"); 
ini_set("allow_url_fopen",1);
$row['rss_url'] = "http://xml.utrace.de/?query=211.172.46.197";
/*
include "Snoopy.class.php";
$url = parse_url($row['rss_url']);
$snoopy = new Snoopy;
$snoopy->host = $url['host'];
$snoopy->fetch($row['rss_url']);
$xml_data = $snoopy->results;
print trim($xml_data);
*/



class yskXmlClass { 

    ## private 
    var $_xml_parser; 
    var $_xml_encoding; 
    var $_xml_chk        = 'n'; 
    var $_xml_item        = array(); 
    var $_xml_result    = array(); 

    /* 
    ## [실행 1] xml 열기 
    ------------------------------------------------------------------------------------------- 
    include './class/yskXmlClass.php'; 

    $xml = new yskXmlClass; 
    $prt = $xml->xmlOpen('http://blog.rss.naver.com/thinkfactory.xml','item'); 

    $count = count($prt['item']); 
    for($x=0; $x<$count; $x++) { 
        echo $prt['title'][$x]['value'].'<br>'; 
        echo $prt['link'][$x]['value'].'<br>'; 
        echo $prt['description'][$x]['value'].'<br><br><hr>'; 
    } 
    ------------------------------------------------------------------------------------------- 
    */ 
    function xmlOpen($url, $tag) { 
			$xml_data = null;
        $this->_tag = $tag; 
        if($fp = fopen($url, 'r')) { 
            while(!feof ($fp)) { 
                $xml_data .= fgets($fp, 4096); 
            } 
            fclose ($fp); 
	          $this->_xmlDefine($xml_data); 
            return $this->_xmlInte(); 
        } else { 
						return false;
            //$this->_error('xml open error : xml 파일열기 실패 => '.$url); 
        } 
    } 

    ## xml 선언 
    function _xmlDefine($xml_data) { 
        preg_match('/encoding="[^"]+"/', $xml_data, $pattern); 

				if(isset($pattern[0]))  $this->_xml_encoding = strtolower(preg_replace('/(encoding=)|(")/', '', $pattern[0])); 

        $this->_xml_parser = xml_parser_create(); 
        xml_parser_set_option($this->_xml_parser, XML_OPTION_CASE_FOLDING, 0); //태그 이름을 소문자로 뿌려줌 
        xml_parse_into_struct($this->_xml_parser, $xml_data, $this->_xml_item, $index); 
        xml_parser_free($this->_xml_parser); 
    } 

    ## xml 추출 
    function _xmlInte() { 
        foreach($this->_xml_item as $v) { 
            if($v['tag'] == $this->_tag && $v['type'] == 'open') { 
                $this->_xml_result[$v['tag']][] = ''; 
                $this->_xml_chk = 'y'; 
            } 
            if($v['type'] == 'complete' && $this->_xml_chk == 'y') { 
                if($this->_xml_encoding == 'utf-8') { 
										if(isset($v['attributes'])){
	                    $this->_xml_result[$v['tag']][] = array('value'=>trim($v['value']),'att'=>trim($v['attributes'])); 
										}else{
											if(isset($v['value'])){
		                    $this->_xml_result[$v['tag']][] = array('value'=>trim($v['value']),'att'=>''); 										
											}else{
												$this->_xml_result[$v['tag']][] = array('value'=>'','attr'=>'');
											}
										}
//                    $this->_xml_result[$v['tag']][] = array('value'=>iconv('utf-8', 'euc-kr', $v['value']),'att'=>iconv('utf-8', 'euc-kr', $v['attributes'])); 
                } else { 
										if(isset($v['value'])){
											$v['value'] = (isset($v['value'])) ? iconv( mb_detect_encoding($v['value']),"utf-8", $v['value'] ) : null;
											$v['attributes'] = (isset($v['attributes'])) ? iconv( mb_detect_encoding($v['attributes']),"utf-8", $v['attributes'] ) : null;
										}else{
											$v['value'] = $v['attributes'] = null;										
										}

                    $this->_xml_result[$v['tag']][] = array('value'=>trim($v['value']),'att'=>trim($v['attributes'])); 
                } 
            } 
        } 
        return $this->_xml_result; 
    } 

    ## 에러표시 
    function _error($msg='') { 
        echo $msg; 
        exit; 
    } 
} 


/*
$xml = new yskXmlClass; 
$arr = $xml->xmlOpen($row['rss_url'],'result'); 

// 국가
$Country = $arr[countrycode][0][value];
// 지역
$Region = $arr[region][0][value];
// ISP
$ISP = $arr[isp][0][value];
// 위도
$LAT = $arr[latitude][0][value];
// 경도
$LNG = $arr[longitude][0][value];
*/
?>
<?
function objectsIntoArray($arrObjData, $arrSkipIndices = array()){
    $arrData = array();
    
    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}


$xmlUrl = $row['rss_url']; // XML feed file/URL
$xmlStr = file_get_contents($xmlUrl);
$xmlObj = simplexml_load_string($xmlStr);
$arrXml = objectsIntoArray($xmlObj);


// 국가
$Country = $arrXml[result][countrycode];
// 지역
$Region = $arrXml[result][region];
// ISP
$ISP = $arrXml[result][isp];
// 위도
$LAT = $arrXml[result][latitude];
// 경도
$LNG = $arrXml[result][longitude];


?>