<?
// _lib.php 에서 호출했는지 확인
if(!defined("_hannet_included")) exit;

// config.php 2번 호출되지 않도록 확인
if(defined("_config_included")) return;
	define("_config_included",true);

/*====================================================================================================
▶ Database 설정
----------------------------------------------------------------------------------------------------*/

	// Master DB
	$mysql1['db_host'] = "localhost";
	$mysql1['db_user'] = "fracas";
	$mysql1['db_pass'] = "fracas@1004";
	$mysql1['db_name'] = "fracas";


	// Slave DB
	$mysql2['db_host'] = "";
	$mysql2['db_user'] = "";
	$mysql2['db_pass'] = "";
	$mysql2['db_name'] = "";

/*====================================================================================================
▶ 서버 접속정보
----------------------------------------------------------------------------------------------------*/
	// Email
	define("_SMTP_HOST_","");
	define("_SMTP_PORT_","");
	define("_SMTP_USER_","");
	define("_SMTP_USER_PASS_","");
	define("_SENDER_EMAIL_","");
	define("_SENDER_NAME_","");

	// SMS 1
	define("_SMS1_DB_HOST_","");
	define("_SMS1_DB_NAME_","");
	define("_SMS1_DB_USER_","");
	define("_SMS1_DB_PASS_","");

	// SMS 2
	define("_SMS2_DB_HOST_","");
	define("_SMS2_DB_NAME_","");
	define("_SMS2_DB_USER_","");
	define("_SMS2_DB_PASS_","");


/*===================================================================================================*/


/*====================================================================================================
▶ 경로 설정
----------------------------------------------------------------------------------------------------*/

	if(isset($_ENV['OS'])) {
		if(strstr( $_ENV['OS'],'Windows')){
			define("_ROOT_",str_replace("/",'\\',$_SERVER['DOCUMENT_ROOT']));
		}else{
			if(substr($_SERVER['DOCUMENT_ROOT'],-1) == "/") define("_ROOT_", substr($_SERVER['DOCUMENT_ROOT'],0,-1));
			else define("_ROOT_",$_SERVER['DOCUMENT_ROOT']);
		}
	}else{
			if(substr($_SERVER['DOCUMENT_ROOT'],-1) == "/") define("_ROOT_", substr($_SERVER['DOCUMENT_ROOT'],0,-1));
			else define("_ROOT_",$_SERVER['DOCUMENT_ROOT']);
	}

	define( "_DOMAIN_"      , "hansian.cafe24.com"    );
	define( "_HOME_"        , "http://".$_SERVER['HTTP_HOST']."/"   );

	define( "_FOLDER_"      , ""                );
	define( "_CORE_"        , _FOLDER_."/_core"        ); // 루트를 제외한 절대경로
	define( "_UPLOAD_"      , _FOLDER_."/_upload"      ); // 루트를 제외한 절대경로
	define( "_MODULE_"      , _FOLDER_."/_modules"     ); // 루트를 제외한 절대경로
	define( "_ADMIN_"       , _FOLDER_."/_hanadmin"    ); // 루트를 제외한 절대경로
	define( "_SELLER_"      , _FOLDER_."/_hanadmin"    ); // 루트를 제외한 절대경로

	define( "_PATH_"        , _ROOT_._FOLDER_          );
	define( "_CORE_PATH_"   , _ROOT_._CORE_            );
	define( "_UPLOAD_PATH_" , _ROOT_._UPLOAD_          );
	define( "_MODULE_PATH_" , _ROOT_._MODULE_          );
	define( "_ADMIN_PATH_"  , _ROOT_._ADMIN_           );
	define( "_SELLER_PATH_" , _ROOT_._SELLER_          );

	define( "_THIS_PATH_"   , realpath('.')                              );
	define( "_THIS_URI_"    , dirname($_SERVER["SCRIPT_NAME"])           );
	define( "_THIS_FOLDER_" , basename(dirname($_SERVER["SCRIPT_NAME"])) );

	define( "_PHPMYADMIN_"  , ""               );
	define( "_DEV_IP_"      , "211.117.46.197" );
	define( "_IP_"          , $_SERVER['REMOTE_ADDR'] );
	define( "_EMAIL_"       , "webmaster@"._DOMAIN_);

/*◀================================================================================================*/





/*====================================================================================================
▶ 에러 로그 설정
----------------------------------------------------------------------------------------------------*/

	define("_ERROR_REPORTING","on"); // on, off, log
	define("_ERROR_LOG_PATH",_CORE_PATH_."/_log"); //로그파일 폴더 경로 (절대경로로 설정할 것)

/*◀================================================================================================*/



/*====================================================================================================
▶ 기타 설정
----------------------------------------------------------------------------------------------------*/

	define( "DELIMITER"     , "^@^"                        );
	define( "ENTER"         , "".chr(13) . chr(10)         );
	define( "_CRIPT_KEY_"   , "asdf//sofielstqdf0987-asdf" );
	define( "_UPLOAD_MAX_SIZE_" , "500*1024"  );

/*◀================================================================================================*/


/*====================================================================================================
▶ 홈페이지 기본설정
----------------------------------------------------------------------------------------------------*/

	define("_HOMEPAGE_NAME_","경기 중장년 행복캠퍼스");  // 사이트 이름
	define("_HOMEPAGE_TITLE_", "경기 중장년 행복캠퍼스");         // 사이트 타이틀 <title>  </title>
	define("_HOMEPAGE_AUTHOR_", "경기 중장년 행복캠퍼스");         // 사이트 작성자 <meta name="author" content="" />
	define("_HOMEPAGE_KEYWORDS_", "경기 중장년 행복캠퍼스");       // 사이트 키워드 <meta name="keywords" content="" />
	define("_HOMEPAGE_DESCRIPTION_", "경기 중장년 행복캠퍼스에서 상담자들의 전문성 강화를 위한 유익한 강좌들을 준비하여 여러분을 초대합니다.");    // 사이트 설명   <meta name="description" content="" />
	define("_COPYRIGHT_","Copyright (c) Han Communication, All Rights Reserved."); // 사이트 카피라이트

/*◀================================================================================================*/


/*====================================================================================================
▶ 회원레벨정의
----------------------------------------------------------------------------------------------------*/

	define("_MEMBER_A_","100"); // 최고관리자 레벨
	define("_MEMBER_B_","9");  // 그룹관리자 레벨
	define("_MEMBER_C_","6");  // 정회원 레벨
	define("_MEMBER_D_","2");  // 준회원 레벨
	define("_MEMBER_E_","1");  // 회원가입시 기본레벨

/*◀================================================================================================*/


/*====================================================================================================
▶ SMS 설정
----------------------------------------------------------------------------------------------------*/
	define("_CALLBACK_","070-4046-8827");

/*◀================================================================================================*/


/*====================================================================================================
▶ tocken
----------------------------------------------------------------------------------------------------*/
  $token['joinEnd'] = str_replace(".","",_DOMAIN_)."_joinend";
  $token['bookmark'] = str_replace(".","",_DOMAIN_)."_bookmark";



/*====================================================================================================
▶ Email
----------------------------------------------------------------------------------------------------*/
function EmailList(){
	$EmailList = array(
		"naver.com",
		"chol.com",
		"dreamwiz.com",
		"empal.com",
		"freechal.com",
		"gmail.com",
		"hanafos.com",
		"hanmail.net",
		"hanmir.com",
		"hotmail.com",
		"korea.com",
		"lycos.co.kr",
		"nate.com",
		"netian.com",
		"paran.com",
		"yahoo.com",
		"yahoo.co.kr",
	);
  return $EmailList;
}


/*◀================================================================================================*/


/*====================================================================================================
▶ 국가코드
----------------------------------------------------------------------------------------------------*/
function CountryNumber(){
	$_CountryNumber['South Korea']='82';
	$_CountryNumber['United States']='1';
	$_CountryNumber['Afghanistan']='93';
	$_CountryNumber['Albania']='355';
	$_CountryNumber['Algeria']='213';
	$_CountryNumber['American Samoa']='684';
	$_CountryNumber['Andorra']='376';
	$_CountryNumber['Angola']='244';
	$_CountryNumber['Anguilla']='1';
	$_CountryNumber['Antarctica']='672';
	$_CountryNumber['Antigua & Barbuda']='1';
	$_CountryNumber['Argentina']='54';
	$_CountryNumber['Armenia']='374';
	$_CountryNumber['Aruba']='297';
	$_CountryNumber['Ascension Island']='247';
	$_CountryNumber['Australia']='61';
	$_CountryNumber['Austria']='43';
	$_CountryNumber['Azerbaijan']='994';
	$_CountryNumber['Bahamas']='1+242';
	$_CountryNumber['Bahrain']='973';
	$_CountryNumber['Bangladesh']='880';
	$_CountryNumber['Barbados']='1+246';
	$_CountryNumber['Barbuda']='1+809';
	$_CountryNumber['Belarus']='375';
	$_CountryNumber['Belgium']='32';
	$_CountryNumber['Belize']='501';
	$_CountryNumber['Benin']='229';
	$_CountryNumber['Bermuda']='1+441';
	$_CountryNumber['Bhutan']='975';
	$_CountryNumber['Bissau']='245';
	$_CountryNumber['Bolivia']='591';
	$_CountryNumber['Bonaire']='7';
	$_CountryNumber['Bosnia & Herzegovina']='387';
	$_CountryNumber['Botswana']='267';
	$_CountryNumber['Brazil']='55';
	$_CountryNumber['British Indian Ocean Territory']='246';
	$_CountryNumber['British Virgin Islands']='1';
	$_CountryNumber['Brunei']='673';
	$_CountryNumber['Brunei Darussalam']='673';
	$_CountryNumber['Bulgaria']='359';
	$_CountryNumber['Burkina Faso']='226';
	$_CountryNumber['Burundi']='257';
	$_CountryNumber['Cambodia']='855';
	$_CountryNumber['Cameroon']='237';
	$_CountryNumber['Canada']='1';
	$_CountryNumber['Canary Islands']='34';
	$_CountryNumber['Cape Verde Islands']='238';
	$_CountryNumber['Cayman Islands']='1';
	$_CountryNumber['Central African Republic']='236';
	$_CountryNumber['Chad']='235';
	$_CountryNumber['Chile']='56';
	$_CountryNumber['China']='86';
	$_CountryNumber['Christmas Island']='586';
	$_CountryNumber['Cocos (keeling) Islands']='61';
	$_CountryNumber['Colombia']='57';
	$_CountryNumber['Comoros/Mayotte']='269';
	$_CountryNumber['Congo']='242';
	$_CountryNumber['Congo-Democratic Republic']='243';
	$_CountryNumber['Cook Islands']='682';
	$_CountryNumber['Costa Rica']='506';
	$_CountryNumber["Cote D'Ivoire"]='225';
	$_CountryNumber['Croatia']='385';
	$_CountryNumber['Cuba']='53';
	$_CountryNumber['Curacao']='599';
	$_CountryNumber['Cyprus']='357';
	$_CountryNumber['Czech Republic']='420';
	$_CountryNumber['Denmark']='45';
	$_CountryNumber['Diego Garcia']='246';
	$_CountryNumber['Djibouti']='253';
	$_CountryNumber['Dominica']='1';
	$_CountryNumber['Dominican Republic']='1';
	$_CountryNumber['East Timor']='670';
	$_CountryNumber['Ecuador']='593';
	$_CountryNumber['Egypt']='20';
	$_CountryNumber['El Salvador']='503';
	$_CountryNumber['England']='44';
	$_CountryNumber['Equatorial Guinea']='240';
	$_CountryNumber['Eritrea']='291';
	$_CountryNumber['Estonia']='372';
	$_CountryNumber['Ethiopia']='251';
	$_CountryNumber['Falkland Islands']='500';
	$_CountryNumber['Faroe Islands']='298';
	$_CountryNumber['Fiji']='679';
	$_CountryNumber['Finland']='358';
	$_CountryNumber['France']='33';
	$_CountryNumber['French Guiana']='594';
	$_CountryNumber['French Polynesia']='689';
	$_CountryNumber['French Souther Terr']='33';
	$_CountryNumber['Gabon Republic']='241';
	$_CountryNumber['Gambia']='220';
	$_CountryNumber['Georgia']='995';
	$_CountryNumber['Germany']='49';
	$_CountryNumber['Ghana']='233';
	$_CountryNumber['Gibraltar']='350';
	$_CountryNumber['Greece']='30';
	$_CountryNumber['Greenland']='299';
	$_CountryNumber['Grenada and Carriacuou']='1';
	$_CountryNumber['Guadeloupe']='590';
	$_CountryNumber['Guatemala']='502';
	$_CountryNumber['Guinea']='224';
	$_CountryNumber['Guinea-Bissau']='245';
	$_CountryNumber['Guyana']='592';
	$_CountryNumber['Haiti']='509';
	$_CountryNumber['Heard and Mcdonalds Islands']='61';
	$_CountryNumber['Holy See (vatican City )']='39+6';
	$_CountryNumber['Honduras']='504';
	$_CountryNumber['Hong Kong']='852';
	$_CountryNumber['Hungary']='36';
	$_CountryNumber['Iceland']='354';
	$_CountryNumber['India']='91';
	$_CountryNumber['Indonesia']='62';
	$_CountryNumber['Iran']='98';
	$_CountryNumber['Iraq']='964';
	$_CountryNumber['Ireland']='353';
	$_CountryNumber['Israel']='972';
	$_CountryNumber['Italy']='39';
	$_CountryNumber['Ivory Coast']='225';
	$_CountryNumber['Jamaica']='1';
	$_CountryNumber['Japan']='81';
	$_CountryNumber['Jordan']='962';
	$_CountryNumber['Kazakhstan']='7';
	$_CountryNumber['Kenya']='254';
	$_CountryNumber['Kiribati']='686';
	$_CountryNumber['Kuwait']='965';
	$_CountryNumber['Kyrgyzstan']='996';
	$_CountryNumber['Laos']='856';
	$_CountryNumber['Latvia']='371';
	$_CountryNumber['Lebanon']='961';
	$_CountryNumber['Lesotho']='266';
	$_CountryNumber['Liberia']='231';
	$_CountryNumber['Libya']='218';
	$_CountryNumber['Liechtenstein']='41';
	$_CountryNumber['Lithuania']='370';
	$_CountryNumber['Luxembourg']='352';
	$_CountryNumber['Macau']='853';
	$_CountryNumber['Macedonia']='389';
	$_CountryNumber['Madagascar']='261';
	$_CountryNumber['Malawi']='265';
	$_CountryNumber['Malaysia']='60';
	$_CountryNumber['Maldives']='960';
	$_CountryNumber['Mali']='223';
	$_CountryNumber['Malta']='356';
	$_CountryNumber['Marshall Islands']='692';
	$_CountryNumber['Martinique']='596';
	$_CountryNumber['Mauritania']='222';
	$_CountryNumber['Mauritius']='230';
	$_CountryNumber['Mayotte']='269';
	$_CountryNumber['Mexico']='52';
	$_CountryNumber['Micronesia']='691';
	$_CountryNumber['Moldova']='373';
	$_CountryNumber['Monaco']='377';
	$_CountryNumber['Mongolia']='976';
	$_CountryNumber['Montserrat']='1';
	$_CountryNumber['Morocco']='212';
	$_CountryNumber['Mozambique']='258';
	$_CountryNumber['Myanmar (burma)']='95';
	$_CountryNumber['Namibia']='264';
	$_CountryNumber['Nauru']='674';
	$_CountryNumber['Nepal']='977';
	$_CountryNumber['Netherlands']='31';
	$_CountryNumber['Netherlands Antilles']='599';
	$_CountryNumber['Nevis']='1869';
	$_CountryNumber['New Caledonia']='687';
	$_CountryNumber['New Zealand']='64';
	$_CountryNumber['Nicaragua']='505';
	$_CountryNumber['Niger']='227';
	$_CountryNumber['Nigeria']='234';
	$_CountryNumber['Niue']='683';
	$_CountryNumber['Norfolk Island']='672';
	$_CountryNumber['North Korea']='850';
	$_CountryNumber['Northern Mariana Islands']='1';
	$_CountryNumber['Norway']='47';
	$_CountryNumber['Oman']='968';
	$_CountryNumber['Pakistan']='92';
	$_CountryNumber['Palau']='680';
	$_CountryNumber['Palestinian Territory Occupied']='970';
	$_CountryNumber['Panama']='507';
	$_CountryNumber['Papua New Guinea']='685';
	$_CountryNumber['Paraguay']='595';
	$_CountryNumber['Peru']='51';
	$_CountryNumber['Philippines']='63';
	$_CountryNumber['Pitcairn Islands']='872';
	$_CountryNumber['Poland']='48';
	$_CountryNumber['Portugal']='351';
	$_CountryNumber['Qatar']='974';
	$_CountryNumber['Reunion Island']='262';
	$_CountryNumber['Romania']='40';
	$_CountryNumber['Russian Fed']='7';
	$_CountryNumber['Rwanda']='250';
	$_CountryNumber['Saint Kitts & Nevis Anguillas']='1';
	$_CountryNumber['Saipan']='670';
	$_CountryNumber['Samoa']='685';
	$_CountryNumber['San Marino']='378';
	$_CountryNumber['Sao Tome & Principe']='239';
	$_CountryNumber['Saudi Arabia']='966';
	$_CountryNumber['Senegal']='221';
	$_CountryNumber['Serbia & Montenegro']='381';
	$_CountryNumber['Seychelles']='248';
	$_CountryNumber['Sierra Leone']='232';
	$_CountryNumber['Singapore']='65';
	$_CountryNumber['Slovakia']='421';
	$_CountryNumber['Slovenia']='386';
	$_CountryNumber['Solomon Islands']='677';
	$_CountryNumber['Somalia']='252';
	$_CountryNumber['South Africa']='27';
	$_CountryNumber['South Georgia']='500';
	$_CountryNumber['Spain']='34';
	$_CountryNumber['Sri Lanka']='94';
	$_CountryNumber['St Helena']='290';
	$_CountryNumber['St Kitts']='1+809';
	$_CountryNumber['St Lucia']='1+758';
	$_CountryNumber['St Pierre & Miquelon']='508';
	$_CountryNumber['St Vincent and Grenadines']='1';
	$_CountryNumber['Sudan']='249';
	$_CountryNumber['Suriname']='597';
	$_CountryNumber['Svalbard']='47';
	$_CountryNumber['Swaziland']='268';
	$_CountryNumber['Sweden']='46';
	$_CountryNumber['Switzerland']='41';
	$_CountryNumber['Syrian Arab Rep']='967';
	$_CountryNumber['Tahiti']='689';
	$_CountryNumber['Taiwan Roc']='886';
	$_CountryNumber['Tajikistan']='992';
	$_CountryNumber['Tanzania']='255';
	$_CountryNumber['Thailand']='66';
	$_CountryNumber['Togo']='228';
	$_CountryNumber['Tokelau']='690';
	$_CountryNumber['Tonga']='676';
	$_CountryNumber['Trinidad & Tobago']='1';
	$_CountryNumber['Tunisia']='216';
	$_CountryNumber['Turkey']='90';
	$_CountryNumber['Turkmenistan']='993';
	$_CountryNumber['Turks & Caicos Islands']='1';
	$_CountryNumber['Tuvalu']='688';
	$_CountryNumber['Us Minor Outlying Islands']='1';
	$_CountryNumber['Uganda']='256';
	$_CountryNumber['Ukraine']='380';
	$_CountryNumber['United Arab Emirates']='971';
	$_CountryNumber['United Kingdom']='44';
	$_CountryNumber['Uruguay']='598';
	$_CountryNumber['Uzbekistan']='998';
	$_CountryNumber['Vanuatu']='678';
	$_CountryNumber['Venezuela']='58';
	$_CountryNumber['Vietnam']='84';
	$_CountryNumber['Wallis & Futuna']='681';
	$_CountryNumber['Western Sahara']='212';
	$_CountryNumber['Yemen']='967';
	$_CountryNumber['Yemen Dem Rep']='381';
	$_CountryNumber['Yugoslavia']='381';
	$_CountryNumber['Zaire']='243';
	$_CountryNumber['Zambia']='260';
	$_CountryNumber['Zimbabwe']='263';
  return $_CountryNumber;
}


/*====================================================================================================
▶ 배송회사
----------------------------------------------------------------------------------------------------*/
function DeliveryCompany(){
	$_Delivery['a01'] = array("CJ GLS","Y","http://www.cjgls.co.kr/kor/service/service02_02.asp?slipno=");
	$_Delivery['a02'] = array("CVSnet 편의점택배","Y","http://was.cvsnet.co.kr/src/ctod_status.jsp?invoice_no=");
	$_Delivery['a03'] = array("우체국택배","Y","http://service.epost.go.kr/trace.RetrieveRegiPrclDeliv.postal?sid1=");
	$_Delivery['a04'] = array("대한통운","Y","https://www.doortodoor.co.kr/doortodoor.do?fsp_cmd=retrieveInvNoACT&fsp_action=PARC_ACT_002&invc_no=");
	$_Delivery['a05'] = array("한진택배","Y","http://www.hanjin.co.kr/Delivery_html/inquiry/result_waybill.jsp?wbl_num=");
	$_Delivery['a06'] = array("로젠택배","Y","http://www.ilogen.com/iLOGEN.Web.New/TRACE/TraceView.aspx?gubun=slipno&slipno=");
	$_Delivery['a07'] = array("DHL","Y","http://www.dhl.co.kr/asp/tracking/k_track_result_fr.asp?awb=");
	$_Delivery['a08'] = array("현대택배","Y","http://www.hyundaiexpress.com/hydex/servlet/tracking/cargoSearchResult?InvoiceNumber=");
	$_Delivery['a09'] = array("KG옐로우캡택배","Y","http://www.yellowcap.co.kr/custom/inquiry_result.asp?INVOICE_NO=");
	$_Delivery['a10'] = array("KGB택배","Y","http://www.kgbls.co.kr/tracing.asp?number=");
	$_Delivery['a11'] = array("EMS","Y","http://service.epost.go.kr/trace.RetrieveEmsTrace.postal?POST_CODE=");
	$_Delivery['a12'] = array("하나로택배","Y","http://www.hanarologis.com/branch/chase/listbody.html?a_gb=center&a_cd=4&a_item=0&fr_slipno=");
	$_Delivery['a13'] = array("동부익스프레스","Y","http://www.dongbuexpress.co.kr/Html/Delivery/DeliveryCheckView.jsp?item_no=");
	$_Delivery['a14'] = array("건영택배","Y","http://www.dongbuexpress.co.kr/Html/Delivery/DeliveryCheckView.jsp?item_no=");
	$_Delivery['a15'] = array("천일택배","Y","http://www.cyber1001.co.kr/HTrace/HTrace.jsp?transNo=");
	$_Delivery['a16'] = array("굿모닝택배","N","http://www.good8282.co.kr");
	$_Delivery['a17'] = array("탑로지스","N","http://www.toplogis.co.kr");
	$_Delivery['a18'] = array("대신택배","Y","http://home.daesinlogistics.co.kr/daesin/jsp/d_freight_chase/d_general_process.jsp?billno1=&billno2=&billno3=");
	$_Delivery['a19'] = array("일양로지스택배","Y","http://www.ilyanglogis.com/functionality/tracking_result.asp?hawb_no=");
	$_Delivery['a20'] = array("이노지스택배","Y","http://www.innogis.net/Tracking/Tracking_view.asp?invoice=");
	$_Delivery['a21'] = array("경동택배","Y","http://www.kdexp.com/sub4_1.asp?stype=1&p_item=");
	$_Delivery['a22'] = array("우체국 직접연동","Y","http://service.epost.go.kr/trace.RetrieveRegiPrclDelivTibco.postal?sid1=");
	$_Delivery['a23'] = array("GTX","Y","http://www.gtx2010.co.kr/interpark/ip.asp?awblno=");
	$_Delivery['a24'] = array("한덱스(HANDEX)","Y","http://btob.sedex.co.kr/work/app/tm/tmtr01/tmtr01_s4.jsp?IC_INV_NO=");
	$_Delivery['a25'] = array("UPS","Y","http://www.ups.com/WebTracking/track?loc=ko_KR&InquiryNumber1=");
	$_Delivery['a26'] = array("우편등기","Y","http://service.epost.go.kr/iservice/trace/Trace_ok.jsp?sid1=");
	$_Delivery['a27'] = array("TNT Express","Y","http://www.tnt.com/webtracker/tracking.do?respCountry=kr&respLang=ko&searchType=CON&cons=");
	$_Delivery['a28'] = array("한의사랑택배(HPL)","Y","http://www.hanips.com/html/sub03_03_1.html?logicnum=");
	$_Delivery['a29'] = array("FedEx","Y","http://www.hanips.com/html/sub03_03_1.html?logicnum=");
	$_Delivery['a30'] = array("OCSKorea","Y","http://www.ocskorea.com/bl_search.asp?mode=search&search_no=");
  return $_Delivery;
}


/*====================================================================================================
▶ 결제정보
----------------------------------------------------------------------------------------------------*/
	//주문상태
	$_Order['Status']['temp']      = "임시주문";
	$_Order['Status']['fail']      = "주문실패";
	$_Order['Status']['order_can'] = "주문취소";
	$_Order['Status']['ready_in']  = "주문접수";
	$_Order['Status']['ready_ok']  = "주문확인";
	$_Order['Status']['del_in']    = "배송준비";
	$_Order['Status']['del_ok']    = "배송완료";
	$_Order['Status']['order_ok']  = "배송완료";

/*====================================================================================================
▶ 결제정보 - 이니시스
----------------------------------------------------------------------------------------------------*/
	//이니시스 결제구분
	/*
	신용카드(ISP):	VCard
	신용카드(안심클릭)	Card
	OK CashBag 포인트	OCBPoint
	실시간계좌이체	DirectBank
	핸드폰	HPP
	무통장입금(가상계좌)	VBank
	1588 전화결제	Ars1588Bill
	폰빌전화결제	PhoneBill
	문화상품권	Culture
	틴캐시(TeenCash)	TEEN
	게임문화 상품권	DGCL
	도서문화 상품권	BCSH
	네이트온 미니뱅크	OABK
	*/
	$_Order['INISYS']['Card']['01'] = "외환";
	$_Order['INISYS']['Card']['03'] = "롯데";
	$_Order['INISYS']['Card']['04'] = "현대";
	$_Order['INISYS']['Card']['06'] = "국민";
	$_Order['INISYS']['Card']['11'] = "BC";
	$_Order['INISYS']['Card']['12'] = "삼성";
	$_Order['INISYS']['Card']['14'] = "신한";
	$_Order['INISYS']['Card']['15'] = "한미(시티)";
	$_Order['INISYS']['Card']['16'] = "NH";
	$_Order['INISYS']['Card']['17'] = "하나 SK";

	$_Order['INISYS']['Card']['21'] = "해외비자";
	$_Order['INISYS']['Card']['22'] = "해외마스터";
	$_Order['INISYS']['Card']['23'] = "JCB";
	$_Order['INISYS']['Card']['24'] = "해외아멕스";
	$_Order['INISYS']['Card']['25'] = "해외다이너스";


/*====================================================================================================
▶ 지역
----------------------------------------------------------------------------------------------------*/

	$RegionList = array(
		"서울/경기",
		"강원도",
		"경상도",
		"충청도",
		"전라도",
		"제주도",
	);

/*====================================================================================================
▶ 소속
----------------------------------------------------------------------------------------------------*/

	$GroupList = array(
		"대학생",
		"직장인",
		"자유인",
		"예술인",
		"사회인",
		"외계인",
	);


/*====================================================================================================
▶ 별자리
----------------------------------------------------------------------------------------------------*/
	$starsign['Aquarius'];

  function StarSign($date){
    $return = null;
    $date = (int)$date;
    if($date){
      if($date > 119 && $date < 219 )    $return = "물병자리";
      if($date > 218 && $date < 321 )    $return = "물고기자리";
      if($date > 320 && $date < 420 )    $return = "양자리";

      if($date > 419 && $date < 521 )    $return = "황소자리";
      if($date > 520 && $date < 622 )    $return = "쌍둥이자리";
      if($date > 621 && $date < 723 )    $return = "게자리";

      if($date > 722 && $date < 823 )    $return = "사자자리";
      if($date > 822 && $date < 924 )    $return = "처녀자리";
      if($date > 923 && $date < 1023 )    $return = "천칭자리";

      if($date > 1022 && $date < 1123 )    $return = "전갈자리";
      if($date > 1122 && $date < 1225 )    $return = "궁수자리";
      if($date > 1224 || $date < 120 )    $return = "바다염소자리";
    }
    return $return;
  }


  function StarPoint($date){
    $return = null;
    $date = str_replace("-","",$date);
    $date = (int)$date;
    if($date){
      if($date > 119 && $date < 219 )    $point = 1;
      if($date > 218 && $date < 321 )    $point = 2;
      if($date > 320 && $date < 420 )    $point = 3;

      if($date > 419 && $date < 521 )    $point = 1;
      if($date > 520 && $date < 622 )    $point = 2;
      if($date > 621 && $date < 723 )    $point = 3;

      if($date > 722 && $date < 823 )    $point = 1;
      if($date > 822 && $date < 924 )    $point = 2;
      if($date > 923 && $date < 1023 )   $point = 3;

      if($date > 1022 && $date < 1123 )  $point = 1;
      if($date > 1122 && $date < 1225 )  $point = 2;
      if($date > 1224 || $date < 120 )   $point = 3;
    }
    $day = date("d")%6;

    if($point == "1"){
      switch($day){
        case 0:
        case 2:
        case 5:
          $return = "green";break;
        case 1:
        case 3:
          $return = "yellow";break;
        case 4:
          $return = "red";break;
      }
    }
    if($point == "2"){
      switch($day){
        case 0:
        case 4:
          $return = "yellow";break;
        case 3:
          $return = "red";break;
        case 1:
        case 2:
        case 5:
          $return = "green";break;
      }
    }
    if($point == "3"){
      switch($day){
        case 0:
          $return = "red";break;
        case 1:
        case 3:
        case 4:
          $return = "green";break;
        case 2:
        case 5:
          $return = "yellow";break;
      }
    }


    return $return;
  }
  /*

물병자리
 Aquarius [ə|kweriəs]
 1.20 - 2.18

물고기자리
 Pisces [|paɪsi:z]
 2.19 - 3.20

양자리
 Aries [|eri:z]
 3.21 - 4.19

황소자리
 Taurus [|tɔ:rəs]
 4.20 - 5.20

쌍둥이자리
 Gemini [|dƷemɪnai]
 5.21 - 6.21

게자리
 Cancer [|kӕnsə(r)]
 6.22 - 7.22

사자자리
 Leo [|li:oʊ]
 7.23 - 8.22

처녀자리
 Virgo [|v3:rgoʊ]
 8.23 - 9.23

천칭자리
 Libra [|li:brə]
 9.24 - 10.22

전갈자리
 Scorpius [skɔ́:rpiəs]
 10.23 - 11.22

궁수자리
 Sagittarius [|sӕdƷɪ|teriəs]
 11.23 - 12.24

바다염소자리
 Capricornus [kæ̀prikɔ́:rnəs]
 12.25 - 1. 19
 */


/*====================================================================================================
▶ 키워드
----------------------------------------------------------------------------------------------------*/
$Keyword['M']['01']['a'] = array("댄디한","귀여운","평범한","개성파","빈티지","럭셔리","섹시한");
$Keyword['M']['01']['b'] = array("남자다운","세심한","시크한","다정한","애교있는","유머러스한","엉뚱4차원");
$Keyword['M']['01']['c'] = array("스키니한","표준체형","슬림몸짱","불끈근육","후덕몸매","귀염통통","기골장대");

$Keyword['F']['01']['a'] = array("섹시한","청순한","귀여운","평범한","개성파","럭셔리","보이시");
$Keyword['F']['01']['b'] = array("수줍은","애교넘치는","도도한","털털한","여성스러운","발랄한","엉뚱4차원");
$Keyword['F']['01']['c'] = array("가녀린","스키니한","표준체형","굴곡몸매","볼륨글래머","귀염통통","정감가는");

$Keyword['M']['02']['a'] = array("고기류","야채/샐러드","디저트류","회/수산물","분식류","coffee/tea","쥬스/탄산","술/칵테일");
$Keyword['M']['02']['b'] = array("액션","멜로","공포","로맨틱","코메디","스릴러","SF/판타지");
$Keyword['M']['02']['c'] = array("R&B/힙합","뉴에이지","발라드","락","하우스","댄스","트로트");

$Keyword['F']['02']['a'] = array("고기류","야채/샐러드","디저트류","회/수산물","분식류","coffee/tea","쥬스/탄산","술/칵테일");
$Keyword['F']['02']['b'] = array("액션","멜로","공포","로맨틱","코메디","스릴러","SF/판타지");
$Keyword['F']['02']['c'] = array("R&B/힙합","뉴에이지","발라드","락","하우스","댄스","트로트");

$Keyword['M']['03']['a'] = array("잘난척하는","담배피는","예의없는","술버릇있는","무관심한","연락안되는","패션센스제로");
$Keyword['F']['03']['a'] = array("잘난척하는","담배피는","예의없는","술버릇있는","무관심한","연락안되는","패션센스제로");

$Keyword['M']['04']['a'] = $Keyword['F']['01']['a'];
$Keyword['M']['04']['b'] = $Keyword['F']['01']['b'];
$Keyword['M']['04']['c'] = $Keyword['F']['01']['c'];

$Keyword['F']['04']['a'] = $Keyword['M']['01']['a'];
$Keyword['F']['04']['b'] = $Keyword['M']['01']['b'];
$Keyword['F']['04']['c'] = $Keyword['M']['01']['c'];

$Keyword['M']['05']['a'] = array("영화보기","음악듣기","책읽기","드라이브","쇼핑하기","음주가무","게임하기");
$Keyword['M']['05']['b'] = array("사랑/연애","시사/경제","연예/가쉽","패션/뷰티","사진/예술","요리/음식","여행/휴가");

$Keyword['F']['05']['a'] = array("영화보기","음악듣기","책읽기","드라이브","쇼핑하기","음주가무","게임하기");
$Keyword['F']['05']['b'] = array("사랑/연애","시사/경제","연예/가쉽","패션/뷰티","사진/예술","요리/음식","여행/휴가");

$Keyword['M']['06']['a'] = array("노코멘트","고졸","대학교","대학원","배울만큼");
$Keyword['F']['06']['a'] = array("노코멘트","고졸","대학교","대학원","배울만큼");

$Keyword['M']['07']['a'] = array("설레는것","달콤한것","뜨거운것","미치는것","편안한것","다주는것","슬프고아픈것");
$Keyword['F']['07']['a'] = array("설레는것","달콤한것","뜨거운것","미치는것","편안한것","다주는것","슬프고아픈것");



?>