<?php
define("CHARSET","UTF-8");
require_once str_replace("plugin/SmartEditorBasic.0.3.17/popup","",dirname(__FILE__))."_lib.php";
$edid = $_GET['edid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>SyntaxHighlighter</title> 

<link rel="stylesheet" href="../css/code.css" type="text/css"  charset="utf-8"/>
<script type="text/javascript">
// <![CDATA[
function source_code_insert(){
	var f = document.souce_code_form;	
	var codeName = f.code.value;
	if(!f.source_code.value){
		alert("소스코드를 입력하여 주세요.");
		f.source_code.focus();
		return;
	}
	returnHtmlValue = "[SOURCE_CODE]<pre class='brush:"+codeName+"'>"+"\r\n";
	returnHtmlValue =  returnHtmlValue +f.source_code.value +"\n</pre>[/SOURCE_CODE]";

	parent.parent.oEditors.getById["<?=$edid?>"].exec("PASTE_HTML", [returnHtmlValue]); 
	parent.parent.oEditors.getById["<?=$edid?>"].exec("SE_TOGGLE_SYNTAXHIGHLIGHT_LAYER");
}

function closeWindow() {
  parent.parent.oEditors.getById["<?=$edid?>"].exec("SE_TOGGLE_SYNTAXHIGHLIGHT_LAYER");
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
<body oncontextmenu="return false" onselectstart="return false" ondragstart="return false">

<div class="wrapper">
	<div class="header">
		<h1>소스코드 첨부</h1>
	</div>	

	<div class="body">
  	<form name="souce_code_form" id="souce_code_form" action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
		<dl class="alert">
		    <dt>소스선택
				<select name="code">
					<option value="bash, shell">Bash/shell</option>
					<option value="c-sharp, csharp">C#</option>
					<option value="cpp, c">C++</option>
					<option value="css">CSS</option>
					<option value="delphi, pas, pascal">Delphi</option>
					<option value="diff, patch">Diff</option>
					<option value="groovy">Groovy</option>
					<option value="js, jscript, javascript">JavaScript</option>
					<option value="java">Java</option>
					<option value="perl, pl">Perl</option>
					<option value="php">PHP</option>
					<option value="Text  plain, text">Plain</option>
					<option value="py, python">Python</option>
					<option value="rails, ror, ruby">Ruby</option>

					<option value="scala">Scala</option>
					<option value="sql">SQL</option>
					<option value="vb, vbnet">Visual Basic</option>
					<option value="xml, xhtml, xslt, html, xhtml">XML</option>
				</select>
				</dt>
		    <dd>
        <textarea name="source_code" style="width:510px;height:100px"></textarea>
			</dd>
		</dl>
		</form>
	</div>
	<div class="blank"></div>
	<div class="footer">
		<p><a href="#" onclick="closeWindow(); return false;" title="닫기" class="close">닫기</a></p>
		<ul>
			<li class="submit"><a href="#" onclick="source_code_insert(); return false;" title="업로드" class="btnlink">업로드</a> </li>
			<li class="cancel"><a href="#" onclick="closeWindow(); return false;" title="취소" class="btnlink">취소</a></li>
		</ul>
	</div>
	
</div>

</body>
</html>
