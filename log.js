var USERID = _HANNET_LOG_ID;
var Dimension = "0x0"; //해상도 ;;
var ColorDepth = "Unknown";

if(window.screen){
	//PL_sv = 12;
	Dimension = window.screen.width + 'x' + window.screen.height;
	ColorDepth = window.screen.colorDepth;
}

//hanlogstr = "<div height=\"0\" style=\"top:-1;position:absolute\">";
//hanlogstr += "<img src='http://"+USERID+"/log.php?uid="+USERID+"&dim="+Dimension+"&cd="+ColorDepth;
//hanlogstr += "&ref="+escape(document.referrer)+"&url="+escape(document.URL)+"' width='0' height='0' border='0'></div>";

// 수정 : 위 이미지 삽입방식 미작동 사례가 발견되어 아래 방식으로 변경 - 2012.10.30 (화) 김성중
hanlogstr = "<script language='javascript' src='http://"+USERID+"/log.php?dim="+Dimension+"&cd="+ColorDepth;
hanlogstr += "&ref="+escape(document.referrer)+"&url="+escape(document.URL)+"' ></script>";

document.write(hanlogstr);

//document.write("http://"+USERID+"/log.php?uid="+USERID+"&dim="+Dimension+"&cd="+ColorDepth+"&url="+escape(document.URL)+"&ref="+escape(document.referrer));
