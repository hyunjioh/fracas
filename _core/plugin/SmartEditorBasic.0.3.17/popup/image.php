<?php
define("CHARSET","UTF-8");
require_once str_replace("plugin/SmartEditorBasic.0.3.17/popup","",dirname(__FILE__))."_lib.php";

$set['ImagePath'] = _UPLOAD_PATH_."/editor/".date("Y/m/d");
$set['ImageURL']  = _UPLOAD_."/editor/".date("Y/m/d");
$set['prevWidth'] = 80;
$set['prevHeight'] = 60;

$set['max_file_size'] = 1000*1024*10;
$set['allow_file_ext'] = array("jpg","gif","jpeg","bmp","png");

$updir = _UPLOAD_PATH_."/editor";
umask(0);
if(file_exists($updir)) @chmod( $updir, 0777);
else mkdir( $updir , 0777);
$dateDir = date("Y/");
$updir = _UPLOAD_PATH_."/editor/$dateDir";
umask(0);
if(file_exists($updir)) @chmod( $updir, 0777);
else mkdir( $updir , 0777);
$dateDir = date("Y/m/");
$updir = _UPLOAD_PATH_."/editor/$dateDir";
umask(0);
if(file_exists($updir)) @chmod( $updir, 0777);
else mkdir( $updir , 0777);
$dateDir = date("Y/m/d/");
$updir = _UPLOAD_PATH_."/editor/$dateDir";
umask(0);
if(file_exists($updir)) @chmod( $updir, 0777);
else mkdir( $updir , 0777);



$imageurl = $file_org_name = '';
$file_org_size = 0;
$prev_txt = "<FONT face=돋움>이미지 정렬은 현재 보이는 형식으로 보여지게 됩니다. 이미지의 크기는 미리보기를 하기 위해 임의로 줄여진 크기입니다. <br>확인을 누르시면 이미지를 삽입하실 수 있습니다.</FONT>";

if(!is_writable($set['ImagePath'])){
	umask(0);
	if(file_exists($set['ImagePath'])) chmod($set['ImagePath'], 0777);
	else		@mkdir($set['ImagePath'] , 0777);		
}
if(!file_exists($set['ImagePath'])) {
	echo "저장폴더[".$set['ImagePath']."]가 생성되지 않았습니다.";
	exit;
}
if(!is_writable($set['ImagePath'])) {
	echo "저장폴더에 쓰기 권한이 없습니다.";
	exit;
}

if( isset($_POST['uploaded']) and $_POST['uploaded'] == 'upload_now' && !$_FILES['image_file']['error'] ) { 

	$edid = $_POST['edid'];
	$bid =  $_POST['bid'];
  $file_org_name = $_FILES['image_file']['name'] ;
  $file_org_size = $_FILES['image_file']['size'] ;
  $file_org_type = $_FILES['image_file']['type'] ;
  
	$needle = strrpos($file_org_name, ".") + 1; // 파일 마지막의 "." 문자의 위치를 반환한다. 
	$slice = substr($file_org_name, $needle); // 확장자 문자를 반환한다. 
	$file_ext = strtolower($slice); // 반환된 확장자를 소문자로 바꾼다. 

	if($file_org_size > $set['max_file_size']) historyback( printbyte($set['max_file_size'])." 까지업로드하실 수 있습니다.");
	if (!in_array(strtolower($file_ext),$set['allow_file_ext'])) historyback($file_org_name."은 업로드하실 수 없는 파일입니다.");		
	if (!getimagesize($_FILES['image_file']['tmp_name'])) historyback($file_org_name."은 업로드하실 수 없는 파일입니다.");		

	
	$file_name = $bid."-".time()."_".md5(uniqid(rand())).".".$file_ext; 	
  move_uploaded_file($_FILES['image_file']['tmp_name'] , $set['ImagePath'].'/' . $file_name ) ;
  $imageurl =  $set['ImageURL'].'/' . $file_name ;

	list($width, $height, $type, $attr) = getimagesize($set['ImagePath']."/".$file_name);
	if($height > $set['prevHeight']){
		$prev_height = $set['prevHeight'];
		$prev_width = ($width/$height)*$set['prevHeight'];
	}else{
		if($width > $set['prevWidth']){
			$prev_width = $set['prevWidth'];	
		}else{
			$prev_width = $width;
		}
		$prev_height = $height;
	}
}else{
	$edid = $_GET['edid'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>이미지 첨부</title> 

<link rel="stylesheet" href="../css/popup.css" type="text/css"  charset="utf-8"/>
<script type="text/javascript">
// <![CDATA[
  document.oncontextmenu = function (e) {
   return false;
  }
	
function upload() {
	var theFrm = document.image_upload;		
  fileName = theFrm.image_file.value;
  if (fileName == "") {
    alert('본문에 삽입할 이미지를 선택해주세요.');
    return;
  }
    pathpoint = fileName.lastIndexOf('.');
    filepoint = fileName.substring(pathpoint+1,fileName.length);
    filetype = filepoint.toLowerCase();
    if (filetype != 'jpg' && filetype != 'gif' && filetype != 'png' && filetype != 'jpeg' && filetype !='bmp') {
        alert('이미지 파일만 선택할 수 있습니다.');
        self.close();
        return;
    }
  try {
		theFrm.submit();
  } catch (e) {
    theFrm.reset();
    alert('파일을 업로드할 수 없습니다.');
    return;
  }
}
  

function returnImage(){
	var f = document.image_upload;		

	imageName = f.image_name.value;
	imageUrl = f.image_url.value;
	imageAlign = f.image_align.value;
	width = f.image_width.value;
	height = f.image_height.value;

	if(width > 980){
		alert("이미지의 크기(폭)가 본문(폭)보다 크게 지정되어있습니다.\n\n본문에 삽입할 이미지의 폭은 최대 980px 입니다.");
		return;
	}

	if(width < 50){
		alert("이미지의 최소 크기(폭)은 50px 입니다.");
		return;
	}

	if(imageAlign == "L"){
		returnHtmlValue = "<p style=\"text-align: left\"><img src=\""+imageUrl+"\" class=\"editor-image\" width=\""+width+"\" height=\""+height+"\" style=\"float: none; clear: none;\"/></p>";
	}
	if(imageAlign == "C"){
		returnHtmlValue = "<p style=\"text-align: center\"><img src=\""+imageUrl+"\" class=\"editor-image\" width=\""+width+"\" height=\""+height+"\" style=\"float: none; clear: none;\"/></p>";
	}
	if(imageAlign == "FL"){
		returnHtmlValue = "<p style=\"text-align: left\"><img src=\""+imageUrl+"\" class=\"editor-image\" width=\""+width+"\" height=\""+height+"\" style=\"float: left; clear: both;\"/></p>";
	}
	if(imageAlign == "FR"){
		returnHtmlValue = "<p style=\"text-align: left\"><img src=\""+imageUrl+"\" class=\"editor-image\"  width=\""+width+"\" height=\""+height+"\" style=\"float: right; clear: both;\"/></p>";
	}

	parent.parent.oEditors.getById["<?=$edid?>"].exec("PASTE_HTML", [returnHtmlValue]); 
	parent.parent.oEditors.getById["<?=$edid?>"].exec("SE_TOGGLE_IMAGEUPLOAD_LAYER");
}

function closeWindow() {
  parent.parent.oEditors.getById["<?=$edid?>"].exec("SE_TOGGLE_IMAGEUPLOAD_LAYER");
  return false;
}
// ]]>
</script>

<script language="javascript">
<!--
var capaHTML = 0;
var isGecko = 0;

if ( navigator.product == "Gecko" ) {
  capaHTML = 1;
  isGecko = 1;
}



function fileCheck(obj) {
		var f = document.image_upload;		
		var val = obj.value;
    pathpoint = val.lastIndexOf('.');
    filepoint = val.substring(pathpoint+1,obj.length);
    filetype = filepoint.toLowerCase();
    if(filetype=='jpg' || filetype=='gif' || filetype=='png' || filetype=='jpeg' || filetype=='bmp') {

    } else {
        alert('이미지 파일만 선택할 수 있습니다.');
        return false;
    }
    if(filetype=='bmp') {
        if(confirm('BMP 파일은 웹상에서 사용하기엔 적절한 이미지 포맷이 아닙니다.\n그래도 계속 하시겠습니까?')){
					
				}else{
				 f.reset(); 


				}

    }
}

























var checkValue = 0;
function imageRatioCheck(obj){
	var f = document.image_upload;
	if(checkValue == 0){
		f.img_size_option.value = 'N';
		checkValue = 1;
		obj.src = "images/chkbox_off.gif";
	}else{
		f.img_size_option.value = 'Y';	
		checkValue = 0;
		obj.src = "images/chkbox_on.gif";
	}
}

function imageSizeReset(){
	var f = document.image_upload;
	f.image_width.value = f.org_width.value;
	f.image_height.value = f.org_height.value;
}

function imageResize(kind){
	var f = document.image_upload;	
	if(f.img_size_option.value == "Y"){
		if( kind == "width" ){
			f.image_height.value = Math.ceil((f.org_height.value / f.org_width.value) * f.image_width.value );
		}else{
			f.image_width.value = Math.ceil((f.org_width.value / f.org_height.value) * f.image_height.value);	
		}
	}
}


function image_align_change(obj, val, classname){
	var f = document.image_upload;	
	image_align_icon = new Array(4);
	image_align_icon[0] = tx_image_l;
	image_align_icon[1] = tx_image_c;
	image_align_icon[2] = tx_image_fl;
	image_align_icon[3] = tx_image_fr;

	for(i = 0; i < image_align_icon.length; i++){
		image_align_icon[i].className = image_align_icon[i].className.replace("-pushed","");
	}
	obj.className = classname;
	f.image_align.value = val;
	
	image_width = f.prev_width.value;
	image_height = f.prev_height.value;
	prev_txt = prev_text.innerHTML;
	if(val == "L"){
		image_prev.innerHTML = "<p style=\"TEXT-ALIGN: left\"><img src=\"<?=$imageurl?>\" class=\"editor-image\" onError=\"this.src='../images/icon/pn_preview.gif';\" width=\""+image_width+"\" height=\""+image_height+"\" style=\"FLOAT: none; CLEAR: none;\"/></p><p>"+prev_txt+"</p>";
	}
	if(val == "C"){
		image_prev.innerHTML = "<p style=\"TEXT-ALIGN: center\"><img src=\"<?=$imageurl?>\" class=\"editor-image\" onError=\"this.src='../images/icon/pn_preview.gif';\" width=\""+image_width+"\" height=\""+image_height+"\" style=\"FLOAT: none; CLEAR: none;\"/></p><p>"+prev_txt+"</p>";
	}
	if(val == "FL"){
		image_prev.innerHTML = "<p style=\"TEXT-ALIGN: left\"><img src=\"<?=$imageurl?>\" class=\"editor-image\" onError=\"this.src='../images/icon/pn_preview.gif';\" width=\""+image_width+"\" height=\""+image_height+"\" style=\"FLOAT: left; CLEAR: both;\"/></p><p>"+prev_txt+"</p>";
	}
	if(val == "FR"){
		image_prev.innerHTML = "<p style=\"TEXT-ALIGN: left\"><img src=\"<?=$imageurl?>\" class=\"editor-image\" onError=\"this.src='../images/icon/pn_preview.gif';\" width=\""+image_width+"\" height=\""+image_height+"\" style=\"FLOAT: right; CLEAR: both;\"/></p><p>"+prev_txt+"</p>";
	}
	f.img_align.value = val;

	return;
}

function image_align_onmouseover(obj, classname){
	var thisClassName = obj.className;
	var pattern = /(pushed)/;
	var result = pattern.test(thisClassName);
	if(result == false)	obj.className = classname;
	return;
}

function image_align_onmouseout(obj, classname){
	var thisClassName = obj.className;
	var pattern = /(pushed)/;
	var result = pattern.test(thisClassName);
	if(result == false)	obj.className = classname;
	return;
}



/* 
// Function : onOnlyNumber
// Description : 숫자만 입력받도록
//  Param  : obj - text
//  Return  : true or false
*/
function onOnlyNumber(obj)
{
 for (var i = 0; i < obj.value.length ; i++){
  chr = obj.value.substr(i,1);  
  chr = escape(chr);
  key_eg = chr.charAt(1);
  if (key_eg == 'u'){
   key_num = chr.substr(i,(chr.length-1));   
   if((key_num < "AC00") || (key_num > "D7A3")) { 
    event.returnValue = false;
   }    
  }
 }
 if (event.keyCode >= 48 && event.keyCode <= 57) {
  
 } else {
  event.returnValue = false;
 }
}



//-->
</script>
</head>
<body>

<div class="wrapper">
	<div class="header">
		<h1>사진 첨부</h1>
	</div>	

<?php
if( !isset($_POST['uploaded']) or $_POST['uploaded'] != 'upload_now' ) :
?>
	<div class="body">
  	<form name="image_upload" id="image_upload" action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
		<dl class="alert">
		    <dt>사진 첨부 하기</dt>
		    <dd>
        	<input type="hidden" name="edid" value="<?=$_GET['edid']?>">
        	<input type="hidden" name="bid" value="<?=$_GET['bid']?>">
        	<input type="hidden" name="uploaded" value="upload_now">
        	<input type=file name="image_file" size=30 onchange="fileCheck(this);">
			</dd>
		</dl>
		</form>
	</div>
	<div class="blank"></div>
	<div class="footer">
		<p><a href="#" onclick="closeWindow(); return false;" onmousedown="closeWindow();" title="닫기" class="close">닫기</a></p>
		<ul>
			<li class="submit"><a href="#" onclick="upload(); return false;" onmousedown="upload();" title="업로드" class="btnlink">업로드</a> </li>
			<li class="cancel"><a href="#" onclick="closeWindow(); return false;" onmousedown="closeWindow();" title="취소" class="btnlink">취소</a></li>
		</ul>
	</div>

<?php
else:
?>
	<div class="body">
	<form name="image_upload">
	<input type="hidden" name="image_name" value="<?=$file_name?>">
	<input type="hidden" name="image_url" value="<?=$imageurl?>">
	<!-- 이미지 옵션 수정시 변수 -->
	<input type="hidden" name="org_width" value="<?=$width?>">
	<input type="hidden" name="org_height" value="<?=$height?>">
	<input type="hidden" name="img_size_option" value="Y">
	<!-- 이미지 값 -->
	<input type="hidden" name="prev_width" value="<?=$prev_width?>">
	<input type="hidden" name="prev_height" value="<?=$prev_height?>">
	<input type="hidden" name="img_align" value="L">


	<div style='display:none' id="returnHTML"><p style="TEXT-ALIGN: left"><img src="<?=$imageurl?>" onError="this.src='../images/icon/pn_preview.gif';" width="<?=$prev_width?>" height="<?=$prev_height?>" style="FLOAT: none; CLEAR: none;" /></p></div>
	<!--
		<dl class="alert">
		    <dt>사진 첨부 확인</dt>
		</dl>
	-->
	</div>

	<div class="tx-attach-div">
		<div class="tx-attach-box">
			<div class="tx-attach-box-inner">
				<div class="tx-attach-preview"><div id="image_prev"><p style="TEXT-ALIGN: left"><img src="<?=$imageurl?>" onError="this.src='../images/icon/pn_preview.gif';" width="<?=$prev_width?>" height="<?=$prev_height?>" style="FLOAT: none; CLEAR: none;" /></p><p><?=$prev_txt?></p></div><div id="prev_text" style="display:none"><?=$prev_txt?></div></div>
				<div class="tx-attach-main">
				<div class="field">
				<table>
				<tr>
					<td>
					<dl>
							<dt>옵션</dt>
							<dd>
							<table>
								<tr>
									<td>정렬</td>
									<td>
									<div class="tx-toolbar">
									<ul class="tx-bar tx-bar-left tx-selected-image"> 
										<li class="tx-list"><div class="tx-btn-lbg-pushed tx-alignleft" id="tx_image_l" onmouseover="image_align_onmouseover(this,'tx-btn-lbg-hovered tx-alignleft');" onmouseout="image_align_onmouseout(this,'tx-btn-lbg tx-alignleft');" onClick="image_align_change(this, 'L','tx-btn-lbg-pushed tx-alignleft');">
										<a href="javascript:;" class="tx-icon" title="왼쪽정렬">왼쪽정렬</a></div></li>

										<li class="tx-list"><div class="tx-btn-bg tx-aligncenter" id="tx_image_c" onmouseover="image_align_onmouseover(this,'tx-btn-bg-hovered tx-aligncenter');" onmouseout="image_align_onmouseout(this,'tx-btn-bg tx-aligncenter');" onClick="image_align_change(this, 'C','tx-btn-bg-pushed tx-aligncenter');">
										<a href="javascript:;" class="tx-icon" title="가운데정렬">가운데정렬</a></div></li>

										<li class="tx-list"><div class="tx-btn-bg tx-alignright" id="tx_image_fl" onmouseover="image_align_onmouseover(this,'tx-btn-bg-hovered tx-alignright');" onmouseout="image_align_onmouseout(this,'tx-btn-bg tx-alignright');" onClick="image_align_change(this, 'FL','tx-btn-bg-pushed tx-alignright');">
										<a href="javascript:;" class="tx-icon" title="왼쪽글흐름">왼쪽글흐름</a></div></li>
										<li class="tx-list"><div class="tx-btn-rbg tx-alignfull" id="tx_image_fr" onmouseover="image_align_onmouseover(this,'tx-btn-rbg-hovered tx-alignfull');" onmouseout="image_align_onmouseout(this,'tx-btn-bg tx-alignfull');" onClick="image_align_change(this, 'FR','tx-btn-lbg-pushed tx-alignfull');">
										<a href="javascript:;" class="tx-icon" title="오른쪽글흐름">오른쪽글흐름</a></div></li>
									</ul>
									</div><input type="hidden" name="image_align" value="L">
									</td>
								</tr>
								<tr>
									<td>폭</td>
									<td><input type="text" name="image_width" class="image-attr" size="4" maxlength="4" style="IME-MODE:disabled;" onKeyPress="onOnlyNumber(this);" value="<?=$width?>" onKeyUp="imageResize('width');"> px &nbsp;<img src="images/chkbox_on.gif" align="absmiddle" id="size_checkbox" onClick="imageRatioCheck(this)"> 비율유지</td>
								</tr>
								<tr>
									<td>높이</td>
									<td><input type="text" name="image_height" class="image-attr" size="4" maxlength="4" style="IME-MODE:disabled;" onKeyPress="onOnlyNumber(this);" value="<?=$height?>" onKeyUp="imageResize('height');"> px &nbsp;<img src="images/undo.gif" align="absmiddle" onClick="imageSizeReset();" style="cursor:pointer">초기화</td>
								</tr>
							</table></dd>
					</dl>					
					</td>
				</tr>
				</table>
				</div>
				</div>
			</div>
		</div>
		</form>
	</div>

	<div class="footer">
		<p><a href="#" onclick="closeWindow(); return false;" onmousedown="closeWindow();"  title="닫기" class="close">닫기</a></p>
		<ul>
			<li class="submit"><a href="#" onclick="returnImage();return false;" onmousedown="returnImage();"  title="등록" class="btnlink">등록</a> </li>
			<li class="cancel"><a href="#" onclick="closeWindow();return false;" onmousedown="closeWindow();"  title="취소" class="btnlink">취소</a></li>
		</ul>
	</div>

<?php
endif;
?>
	
</div>

</body>
</html>
