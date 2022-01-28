<?php 
ob_start();
session_start();
ignore_user_abort();
$favicon = '<link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🌐</text></svg>">';
if (isset($_GET['logout'])) 
{
	unset($_SESSION['USERNAME']);
	unset($_SESSION['PASSWORD']);
	unset($_SESSION['LOGGED_IN']);
	echo 'youre logged out';
	exit();
	 die();
}
if (isset($_GET['loggedincheck']) || isset($_GET['isdir'])) 
{
	ob_flush();
	if($_SESSION['USERNAME'] == "WEBMASTER" && $_SESSION['PASSWORD'] == "ADMIN6626" && $_SESSION['LOGGED_IN'] == 1)
	{
		if(isset($_GET['isdir']))
		{
			 if(is_dir(urldecode($_GET['isdir'])))
			{
				 echo 'true';
				 exit();
				 die();
			}
			else
			{
				echo "false ".$_GET['isdir']." is not a folder";
				 exit();
				 die();
			}
		}
		echo 'true';
		 session_regenerate_id();
		 $_SESSION['COUNT']>=0?$_SESSION['COUNT']=$_SESSION['COUNT']+1:$_SESSION['COUNT']=0;
		echo ",".$_SESSION['COUNT'];
	}
	else
	{
		echo 'false';
		echo "USERNAME: ".$_SESSION['USERNAME']." PASSWORD: ".$_SESSION['PASSWORD']." LOGGED_IN: ".$_SESSION['LOGGED_IN'];
	}
	exit();
	 die();
}
function loginform()
{
	echo '<form id="loginform" method="post" enctype="multipart/form-data" action="#">';
	echo "<p><input name='PASSWORD' type='text' value='' data-onenter='loginform' ><input type='submit' value='Submit'></p>";
	echo " </form>";
}
function loginpage()
{
	echo "<!DOCTYPE html>";
	echo "<html lang='en-US'>";
	echo"<head>";
	echo "<meta charset='utf-8'>";
	echo "<title> - My Editor - </title>";
	echo "</head><body>";
	loginform();
	echo "</body>";
	echo "</html>";
}
if (isset($_POST['PASSWORD']) && $_POST['PASSWORD'] === "ADMIN6626") 
{
	ob_flush();
	 $_SESSION['USERNAME'] = "WEBMASTER";
	 $_SESSION['PASSWORD'] = "ADMIN6626";
	 $_SESSION['LOGGED_IN'] = true;
}
if (!isset($_SESSION['LOGGED_IN']) || $_SESSION['LOGGED_IN'] !== true)
{
	ob_flush();
	loginpage();
	exit();
	die();
}
if (!isset($_SESSION['LOGGED_IN']) OR $_SESSION['LOGGED_IN'] != true)
{
	 exit();
	 die();
}
function rrmdir($src)
{
	ob_flush();
	rmdir($src);
}
function mkfolder($thisfolder)
{
	ob_flush();
	if (!is_dir($thisfolder)) 
	{
		mkdir($thisfolder, 0755, true);
	}
}
mkfolder('./SAVED/');
mkfolder('./UPLOAD/');
mkfolder('./TEST/');
mkfolder('./TEST/TEST/');
mkfolder('./TEST/TEST1/');
if (isset($_FILES['file1']) && !empty($_FILES['file1'])) 
{
	function reorder(&$file_post)
	{
		 $file_ary = array();
		 $file_count = count($file_post['name']);
		 $file_keys = array_keys($file_post);
		for ($i = 0; $i < $file_count; $i++) 
		{
			foreach ($file_keys as $key) 
			{
				 $file_ary[$i][$key] = $file_post[$key][$i];
			}
		}
		return $file_ary;
	}
	 $file_ary = reorder($_FILES['file1']);
	foreach ($file_ary as $file) 
	{
		if (file_exists("./UPLOAD/" . $file['name']))
		{
			rename("./UPLOAD/" . $file['name'], "./SAVED/" . time() . "_" . $file['name']);
		}
		if (move_uploaded_file($file['tmp_name'], "./UPLOAD/". $file['name']))
		{
			echo 'success';
		}
		else 
		{
			echo 'fail';
		}
	}
	usleep(1);
	exit();
}
function folder2list($path)
{
	 $fileslist = "";
	 $dir = scandir($path);
	foreach ($dir as $f)
	{
		if ($f != "." && $f != "..")
		{
			 $full = realpath($path . '/' . $f);
			if (is_dir($full))
			{
				clearstatcache();
				echo "<li id='$f' data-full='$full' class='folder' onclick='fetchfolder(this)'> $f </li>";
				echo "<ol class='$f'> </ol>";
			}
			if (is_file($full)) 
			{
				clearstatcache();
				 $ext = pathinfo($full, PATHINFO_EXTENSION);
				 $fileslist .= "<li id='$f' data-full='$full' data-ext='$ext' class='file' onclick=\"filehandle('openfile',this.dataset.full)\"> $f </li>";
			}
		}
	}
	echo $fileslist;
}
if (isset($_POST['savefile']))
{
	if (file_exists($_POST['savefile']))
	{
		 $newname = "./SAVED/" . time() . "_" . pathinfo($_POST['savefile'], PATHINFO_BASENAME);
		copy($_POST['savefile'], $newname);
	}
	if(file_put_contents($_POST['savefile'], $_POST['contents']))
	{
		echo 'saved:'.$_POST['savefile']."\n";
	}
	else
	{
		echo 'FAILURE';
	}
	clearstatcache();
	exit();
}
if (isset($_POST['deletefile']))
{
	if (file_exists($_POST['deletefile']))
	{
		if(rmdir($_POST['deletefile']))
		{
			echo "deleted:".$_POST['deletefile']."\n";
		}
		else
		{
			echo 'FAILURE';
		}
	}
	clearstatcache();
	exit();
}
if (isset($_POST['downloadfile']))
{
	if (file_exists($_POST['downloadfile']))
	{
		echo 'download:'.end(explode("/",$_POST['downloadfile']))."\n";
		echo file_get_contents($_POST['downloadfile']);
	}
	else
	{
		echo 'FAILURE';
	}
	clearstatcache();
	exit();
}
if (isset($_POST['copyfile']))
{
	if (file_exists($_POST['copyfile']))
	{
		echo 'copied:'.$_POST['copyfile']."\n";
		echo file_get_contents($_POST['copyfile']);
	}
	else
	{
		echo 'FAILURE';
	}
	clearstatcache();
	exit();
}
if (isset($_POST['openfile']))
{
	if (file_exists($_POST['openfile']) && is_file($_POST['openfile']))
	{
		echo "opened:".$_POST['openfile']."\n";
		echo file_get_contents($_POST['openfile']);
	}
	else
	{
		echo 'FAILURE';
	}
	clearstatcache();
	exit();
}
if (isset($_GET['openfolder']))
{
	if (is_dir($_GET['openfolder'] . "/"))
	{
		folder2list($_GET['openfolder']);
	}
	else
	{
		echo 'FAILURE';
	}
	ob_flush();
	ob_start();
	clearstatcache();
	exit();
}
if (isset($_POST['deletefolder']))
{
	clearstatcache();
	if (is_dir($_POST['deletefolder'] . "/"))
	{
		rmdir($_POST['deletefolder'] . "/");
	}
	else
	{
		echo 'FAILURE';
	}
	 ob_flush();
	 exit();
}
  $Server = array(
 "php_self" => $_SERVER["PHP_SELF"],
 "document_root" => $_SERVER["DOCUMENT_ROOT"],
 "http_host" => $_SERVER["HTTP_HOST"],
 "script_filename" => $_SERVER["SCRIPT_FILENAME"],
 "server_addr" => $_SERVER["SERVER_ADDR"],
 "server_port" => $_SERVER["SERVER_PORT"],
 "remote_addr" => $_SERVER["REMOTE_ADDR"],
 "free_space" => disk_free_space('/'),
 "total_space" => disk_total_space('/'),
 ); ?>
	<!DOCTYPE html>
		<html lang="en-US">
			<head>
			<meta name = "viewport" content = "width=device-width, initial-scale=1.0">
			 <?=$favicon; ?>
				<title>My Editor
			</title>
			 <SCRIPT  type="text/javascript"> "use strict"
const spc = ["<", ">", "(", ")", "{", "}", "[", "]", "`", "~", "\\", "/", "?", "'", "\"", "|", "-", "+", "*", "@", "!", "&", "$", "#", "%", "^", ".", ",", "=", ";", ":"];
var scrolllock = true;
var timeouthandle;
var SAVED;
let hault = function(propag)
{
	event.preventDefault();
	if(propag == "true" || propag == "t")
	{
		event.stopPropagation();
	}
}
var bufferhandle;
function buffer(func, ms)
{
	if(ms === undefined)
	{
		ms = 900;
	}
	if(bufferhandle)
	{
		clearTimeout(bufferhandle);
	}
	bufferhandle = setTimeout(func, ms);
}
function $(id)
{
	if(typeof id == "object")
	{
		alert('function $ expects parameter 1 to be a string');
		return id;
	}
	return document.getElementById(id);
}
function $Q(selector)
{
	return document.querySelectorAll(selector);
}
function $q(selector)
{
	return document.querySelector(selector);
}
function lset(key,value)
{
	localStorage.setItem(key,value);
}
function lget(key)
{
	if(tmp(localStorage.getItem(key)))
	{
		return Tmp;
	}
}
const myclipboard = [];
function cset(clipText)
{
	if(clipText === undefined)
	{
		clipText = window.getSelection().toString();
	}
	alert(event.target.id);
	myclipboard.push(clipText);
	navigator.clipboard.writeText(clipText);
}
function cget()
{
	navigator.clipboard.readText()
	.then(text => 
	{
		myclipboard.push(text);
	})
	 .catch(err => 
	{
		console.error('Failed to read clipboard contents: ', err);
	});
	return myclipboard.last();
}
let myMouse="up";
function modal(io, x)
{
	if(io=="off")
	{
		 $('modal').remove();
		document.body.classList.remove("modal");
		let newdiv = document.createElement("DIV");
		newdiv.setAttribute("id","modal");
		document.body.insertBefore(newdiv, document.body.firstChild);
		return;
	}
	if(io=="on")
	{
		document.body.classList.add("modal");
		if(x != true)
		{
			 $('modal').setAttribute('onclick',"modal('off')");
		}
		if(x == true)
		{
			 $('modal').appendChild(make("div","id=mclose&onclick=modal('off')","X"));
		}
		return $('modal');
	}
}
const delay = ms => new Promise(res => setTimeout(res, ms));
 (function(window)
{
	window.htmlentities = 
	{
		encode : function(str) 
		{
			var buf = [];
			for (var i=str.length-1;i>=0;i--) 
			{
				buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
			}
			return buf.join('');
		}
		 ,
		decode : function(str) 
		{
			return str.replace(/&#(\d+);/g, function(match, dec) 
			 {
			return String.fromCharCode(dec);
			 });
		}
	}
	 ;
})(window);
function x(int,step)
{
	let x=Array();
	let i;
	for(i=0;
	i<int;
	i++)
	{
		x.push(i);
		i=i+step|0;
	}
	return x;
}
function islong(obj)
{
	return obj != null;
}
Object.prototype.prev = function()
{
	return this.previousElementSibling;
}
 ;
Object.prototype.nex = function()
{
	return this.nextElementSibling;
}
 ;
Object.prototype.wid = function(arg)
{
	return stylecheck(this, 'width', arg);
}
Object.prototype.hei = function(arg)
{
	return stylecheck(this,'height',arg);
}
String.prototype.btn = function() 
{
	return this.replace(/(\w{1,})button/,'$1');
}
String.prototype.sym = function() 
{
	return htmlentities.encode(this);
}
Array.prototype.last = function()
{
	return this[this.length-1];
}
var cp=1;
function codepoints()
{
	if($('poster'))
	{
		poster = $('poster');
	}
	else
	{
		let mymodal = modal('on',true);
		let poster = make("div", "id=poster&style=background-color:lightblue;", "codepoints");
		let arrow = make("div", "id=moredownarrowbutton&onclick=codepoints();easescroll($('poster'))", "arrow");
		poster.appendChild(arrow);
		mymodal.appendChild(poster);
	}
	var highNumber = 50000;
	let stoppat = cp + 500;
	for( cp = cp ;
	cp < Math.min(stoppat, highNumber) ;
	cp++ )
	{
		   $('poster').innerHTML += " "+cp+":"+String.fromCharCode(cp)+" ";
	}
}
var easehandle;
var ease;
function easescroll(el, int)
{
	if(easehandle)
	{
		clearInterval(ease);
		clearTimeout(easehandle);
	}
	let start = el.scrollTop;
	let end = int;
	let step;
	start>end?set=2:step = -2;
	ease = setInterval(function(el,step,end)
	{
		el.scrollTop += step;
		if(end - el.scrollTop <2)
		{
			 clearInterval(ease);
		}
	}
	, 300);
}
function mysplit(str,dlm)
{
	let delim=dlm;
	 [spc[27],spc[28],spc[21]].forEach(function(element)
	{
		if(str.indexOf(element) > -1 && delim == undefined)
		{
			delim = element;
		}
	});
	if(delim==="" || delim == undefined)
	{
		return Array(str);
	}
	let arr = str.split(delim);
	let results = arr.filter( word => word != undefined||null||"");
	return results;
}
function make(tag,option,text)
{
	let node = document.createElement(tag.toUpperCase());
	if(option != 'undefined')
	{
		let opt = mysplit(option,'&');
		opt.forEach(function(element)
		{
			let attr = mysplit(element,'=');
			node.setAttribute(attr[0], attr[1]);
		});
	}
	node.appendChild(document.createTextNode(text));
	return node;
}
function mytypeof(element)
{
	let typ = typeof element;
	if(typ === undefined)
	{
		return "undefined";
	}
	if(!typ)
	{
		return "Null";
	}
	 ;
	if(typ === "object")
	{
		typ = Object.prototype.toString.call(element);
		typ = typ.replaceAll(/object| |\]|\[/g, "");
	}
	return typ;
}
function myrect(elem)
{
	let arr = [];
	let obj = elem.getBoundingClientRect();
	arr.push(obj.top);
	arr.push(obj.left);
	arr.push(obj.width);
	arr.push(obj.height);
	arr.push(obj.left + obj.width);
	arr.push(obj.top + obj.height);
	return arr;
}
function replaceselection()
{
	editor.focus(
	{
		preventScroll: true
	});
	let pat = $('findbar').value;
	let re = new RegExp(pat,"gi");
	let selec = window.getSelection().toString();
	if(re.test(selec))
	{
		let selstart = editor.selectionStart;
		let selend = editor.selectionEnd;
		let stext = editor.value;
		if(selend === stext.length)
		{
			 return;
		}
		let starttxt = stext.substring(0, selstart);
		let endtxt = stext.substring(selend, stext.length);
		let rep = $('replacementbar').value;
		selec = selec.replace(re, rep);
		editor.value = starttxt + selec + endtxt;
		selend = parseInt(selstart + selec.length);
		editor.selectionStart = selstart;
		editor.selectionEnd = selend;
	}
	else
	{
		 searcher();
	}
}
function searcher()
{
	editor.focus(
	{
		preventScroll: true
	});
	let selstart = function()
	{
		 return editor.selectionStart;
	}
	let selend = function()
	{
		 return editor.selectionEnd;
	}
	let stext = function()
	{
		 return editor.value;
	}
	if(selend() === stext().length)
	{
		editor.selectionStart = editor.selectionEnd = 0;
	}
	let pat = $('findbar').value;
	let re;
	if($('caseinsensitive').checked && $('regex').checked) 
	{
		re = new RegExp(pat,"ig");
	}
	if($('caseinsensitive').checked && !$('regex').checked) 
	{
		pat = pat.replaceAll(/([\\\/\?\(\)\<\>\+\.\"\'\:\[\}\{\]\"\'\$\^\&\*])/g,"\\$1"); re= new RegExp(pat,"ig"); }
		if(!$('caseinsensitive').checked && $('regex').checked) {re = new RegExp(pat,"g"); }
		if(!$('caseinsensitive').checked && !$('regex').checked) {pat = pat.replaceAll(/([\\\/\?\(\)\<\>\+\.\"\'\:\[\}\{\]\"\'\$\^\&\*])/g,"\\$1"); re=pat; }
		let maches = function(){ return stext().matchAll(re); }
		let mach = function() { return Array.from(maches()); }
		if(mach().length > 0){
		for(let i = 0;
		 i <= mach().length;
		 i++)
		 { 
		if(i== mach().length){ editor.selectionStart = editor.selectionEnd = 0; i=0; }
		if(mach()[i].index > selstart())
		 {
		if($('up').checked){ i = i - 2; }
		if(i < 0){ i = 0; }
		 let sstart = parseInt(mach()[i].index);
		let num = parseInt(mach()[i].toString().length);
		editor.selectionStart = editor.selectionEnd = sstart;
		let ssend = sstart + num;
		editor.selectionEnd = ssend;
		 centerview()
		 let results = $('frresults');
		results.innerHTML = ++i + " of " + mach().length; 
		break; 
		 }
		 }
		 }else{ let results = $('frresults');
		results.innerHTML = "no matches";}
		 }
		function centerview(){
		let selecend = editor.selectionEnd;
		let substr = editor.value.substring(0,selecend);
		let lines = substr.split("\n");
		let line = lines.pop();
		lines = lines.length;
		let offset = editor.hei(true)/2;
		let scrltop = lines * 18;
		scrltop -= offset; 
		editor.scrollTop = Math.max(scrltop,0);
		line = line.replace(/\t/ig," ");
		line = line.length;
		offset = editor.wid(true)/2;
		let scrllft = line * 7;
		scrllft -= offset;
		editor.scrollLeft = Math.max(scrllft,0);
		}
		function text2file(txt,fname)
		{
		var filename = fname;
		if(filename === undefined)
		 {
		filename = document.getElementById("openfilename").value;
		 }
		var textToWrite = txt;
		if(txt === undefined)
		 {
		textToWrite = editor.value;
		 }
		var textFileAsBlob = new Blob([textToWrite], 
		{
			type:'text/plain'
		});
		var downloadLink = document.createElement("a");
		downloadLink.download = filename;
		downloadLink.innerHTML = "Download File";
		if (window.webkitURL != null)
		 {
		downloadLink.href = window.webkitURL.createObjectURL(textFileAsBlob);
		 }
		else
		 {
		downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
		downloadLink.onclick = destroyClickedElement;
		downloadLink.style.display = "none";
		document.body.appendChild(downloadLink);
		 }
		downloadLink.click();
		}
		let scrlstp;
		function scrollstep(event)
		{
		if(scrlstp)
		 {
		clearTimeout(scrlstp);
		 }
		scrlstp = setTimeout(function()
		{
			let top = editor.scrollTop;
			let offset = top%18;
			offset>9?top+=(18-offset):top-=offset;
			 $('gutter').scrollTop = editor.scrollTop = top;
		}
		 , 200);
		}
		var Tmp ="";
		function tmp(TMP)
		{
		return TMP;
		}
		var Nod ="";
		function nod(NOD)
		{
		Nod=NOD;
		return NOD;
		}
		function tooltip(event)
		{
		if ($('ttcheckbox').checked === true)
		 {
		let left;
		let top;
		let el = event.target;
		var posx = event.clientX;
		var posy= event.clientY;
		var wid = window.innerWidth / 2;
		posx>wid?left = posx - 40:left=posx;
		var hei = window.innerHeight / 2;
		posy>hei?top = posy - 80:top=posy + 30;
		let text = el.outerHTML.replace("\n","");
		let len = 1;
		let newtext = "";
		for(let i = 0;
		i< text.length;
		i++)
		 {
		newtext += text[i];
		if(i%40 === 0)
		 {
		len++;
		newtext += "<br>";
		 }
		 }
		el.classList.add('tooltip');
		document.body.appendChild(make("span", "id=tooltip&style=overflow:hidden;padding:2px;position:absolute;top:"+top+"px;left:"+left+"px;height:"+len*1.2+"em;background-color:tan;z-index:75;max-width:20em;", newtext));
		 }
		}
		</SCRIPT>
			 <STYLE>
 @media only screen and (min-width: 600px)
{
	 :root 
	{
		 /*min 600 px*/
		 --main-left: 365px;
		 --line-height: 18px;
		 --font-size: 12px;
		 --main-bottom: 5px;
		 --main-bg: rgba(255, 255, 255, .9);
		 --main-black: rgba(33, 31, 38, .9);
	}
	 *
	{
		 /*min 600 px*/
		box-sizing: border-box;
		line-height: var(--line-height);
		font-size: var(--font-size);
		font-family: monospace;
		font-size-adjust:12px;
		 -webkit-user-select: none;
		 -ms-user-select: none;
		user-select: none;
	}
	input, textarea
	{
		 /*min 600 px*/
		 -webkit-user-select: text;
		 -ms-user-select: text;
		user-select: text;
	}
	 #sidebar 
	{
		 /*min 600 px*/
		padding-left:0px;
		padding-right:0px;
		top: 5px;
		border-radius:16px;
		bottom:5px;
		position: absolute;
		display: block;
		left: calc(var(--main-left) - 345px);
		width: 340px;
		overflow-y: hidden;
		overflow-x: hidden;
		height:calc(100vh - 10px);
		min-height:calc(100vh - 290px);
		background-color: whitesmoke;
	}
	 .side
	{
		 /*min 600 px*/
		position:absolute;
		width:calc(98% - 0px);
		margin-left:1%;
		margin-right:1%;
		border:1px solid red;
		padding:5px;
		overflow:auto;
		display:none;
		top:75px;
		bottom:230px;
	}
	body, html 
	{
		 /*min 600 px*/
		margin: 0px 0px 0px 0px;
		border: black solid 0px;
		padding: 2px 2px 2px 2px;
		min-height: 400px !important;
		min-width: 600px !important;
		width: 100vw;
		height: 100vh;
		max-width: 100vw;
		max-height: 100vh;
		overflow:hidden;
		background-color: var(--main-black);
		overflow: hidden;
	}
	 .ybar 
	{
		 /*min 600 px*/
		width: 100%;
		height: 7px;
		background-color: dodgerblue;
		display: block;
		position: relative;
		top: -2px;
		cursor: ns-resize;
	}
	 .xbar 
	{
		 /*min 600 px*/
		width: 3px;
		height: 100%;
		background-color: dodgerblue;
		position: relative;
		cursor: ew-resize;
		float: right;
	}
	 #navbar 
	{
		 /*min 600 px*/
		height: 70px;
		background-color: var(--main-black);
		top:0px;
		position:absolute;
		left:0px;
		width: 350px;
		border: 3px solid dodgerblue;
		border-top-left-radius: 16px;
		border-top-right-radius: 16px;
		text-align: center;
		color: white;
	}
	 #docker
	{
		 /*min 600 px*/
		border-top: 3px smooth dodgerblue;
		width: 350px;
		height: 225px;
		position:absolute;
		display: inline-block;
		padding: 5px 5px 5px 5px;
		background-color: var(--main-black);
		overflow: hidden;
		border: 3px solid dodgerblue;
		bottom:0px;
	}
	 #findbar, #replacementbar, #omnibox, #openfilename 
	{
		 /*min 600 px*/
		width:100%;
		height:1.5em;
		padding:3px;
		outline:none;
		border:2px solid dodgerblue;
		line-height:1.5em;
		border-radius:10px;
	}
}
ol>ol 
{
	margin-left: 20px;
}
ol, li
{
	margin-left: 05px;
	padding-left: 0px;
	cursor: pointer;
}
 #moredownarrowbutton
{
	position: fixed;
	bottom: 5%;
	height: 20px;
	width: 50%;
	background-color: brown;
	z-index: 50;
}
 #poster 
{
	columns: 4;
	overflow: scroll;
	font-size: 20px;
	line-height:24px;
}
li:hover 
{
	background-color: rgb(191, 184, 185);
}
li.selected 
{
	background-color: gray;
	color: white;
	cursor: pointer;
}
ol>li, li
{
	list-style-type: none;
	margin-left: -6px;
}
 #scriptTagInnerText 
{
	width: 100%;
}
 #scriptTagInner
{
	width: 200px;
	height: 7em;
	resize: vertical;
	margin-left: 5px;
}
textarea, [type='text'] 
{
	background-color: whitesmoke;
}
 #tooltip
{
	word-break: break-all;
}
 #editor
{
	tab-size: 4;
	 -moz-tab-size: 4;
	position: absolute;
	min-width: calc(100% - 45px);
	width: calc(100% - 45px);
	max-width: calc(100% - 45px);
	min-height: 100%;
	height: 100%;
	max-height: 100%;
	resize: none;
	overflow: auto;
	box-sizing: border-box;
	line-height: var(--line-height);
	font-size: var(--font-size);
}
 #gutter
{
	width: 45px !important;
	height: 100% !important;
	line-height: var(--line-height);
	font-size: var(--font-size);
	margin: 0px 0px;
	resize: none;
	overflow: hidden;
	box-sizing: border-box;
	position: relative;
	left: 0px;
	text-align: right;
	cursor: pointer;
}
 #container
{
	box-sizing:border-box;
	height:calc(100vh - 20px);
	position: absolute;
	display: block;
	width: 745px;
	top: 20px;
	left: calc(var(--main-left) + 15px);
	bottom: 5px;
	overflow: hidden;
	white-space: nowrap;
	cursor: pointer;
	border: 3px dodgerblue solid;
	border-top:none;
	border-bottom-left-radius: 16px;
	border-bottom-right-radius: 16px;
}
 .stage:focus 
{
	outline: none;
}
 .stage:active 
{
	outline: none;
}
 .selected 
{
	display: block !important;
}
 .active
{
	display: block !important;
	background-color: white;
}
 #toolbar>button 
{
	margin: 3px 3px 3px 3px;
	min-width:30px;
}
#toolbar:hover, #toolbar.show
{
	top: 0px;
	transition-origin:0& 50%;
	transform: rotateX(0deg);
	border-bottom-width:3px;
	border-bottom-left-radius: 16px;
	border-bottom-right-radius: 16px;
}
#toolbar
{
	cursor: pointer;
	padding-bottom: 5px;
	padding-left: 5px;
	height: 80px;
	position: absolute;
	display: inline-block;
	width: 745px;
	left: calc(var(--main-left) + 15px);
	top: -60px;
	background-color: var(--main-black);
	overflow: hidden;
	z-index: 50;
	box-sizing: border-box;
	border: 3px groove dodgerblue;
	border-bottom-width:20px;
	backface-visibility:hidden;
	transition-origin:top center;
	transform: rotateX(0deg);
	transition-timing-function:ease-out;
	trasition-direction: forward;
	transition-iteration-count:1;
	transition-delay: 0s;
	transition-duration: .8s;
	transition-origin: 0& 50%;
	transition property: top;
}
 #openfilename,
 #omnibox
{
	width: 29em;
	margin-left: 3px;
}
 #cmd>input[type='text'] 
{
	width: 90%;
}
 #poster
{
	border: 3px solid green;
	background-color: lightblue;
	position: fixed;
	left: 5%;
	right: 5%;
	top: 5%;
	bottom: 5%;
}
th>button, th>input[type='button']
{
	padding: 3px;
	border-radius: 2px;
	box-shadow: none;
	border: none;
	min-width: 100%;
	max-width: 30px;
	height: auto;
	background-color: dodgerblue;
	color: white;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	cursor: pointer;
}
th 
{
	height: 2em;
}
b
{
	font-size: 1em;
	height: 1em;
	width: 1em;
	float: left;
}
 #modal
{
	padding:50px;
	width: 100vw;
	height: 100vh;
	position: fixed;
	top: -50px;
	right: 0px;
	left: -50px;
	bottom: 0px;
	background-color: rgba(0, 0, 0, .2);
	color: black;
	text-align: center;
	box-sizing:content-box;
	z-index:100;
	justify-content: center;
	display:none;
}
body.modal>#modal
{
	display:inline-block;
}
table
{
	width: 95%;
	height: auto;
	table-layout: fixed;
}
 .schange
{
	width: 4em;
	max-width: 4em;
	min-width: 4em;
	inline-size: 4em;
	max-inline-size: 4em;
	min-inline-size: 4em;
}
 .codemode
{
	background-color: black;
	color: #2bff00;
	font-stretch: expanded;
	line-height: var(--line-height);
	font-size: var(--font-size);
	font-weight: 900;
	letter-spacing: 1px;
	font-smooth: antialiased;
	 -webkit-font-smoothing: antialiased;
	 -moz-osx-font-smoothing: grayscale;
}
 .hidden 
{
	display: none !important;
}
#favicon::before 
{
	content: "♥";
}
button, [type='button']
{
	padding: 3px;
	border-radius: 2px;
	box-shadow: none;
	border: none;
	height: auto;
	background-color: dodgerblue;
	color: white;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	cursor: pointer;
	font-variant:small-caps slashed-zero;
}
 .folder::before 
{
	content: "\01F4C1";
}
 .open::before /*no mq px*/
{
	content: "\01F4C2" !important;
}
 .file::before /*no mq px*/
{
	content: "\01F4C4" !important;
}
li>a
{
	 /*no mq px*/
	color: white;
	cursor: pointer;
}
 #contextmenu
{
	 /*no mq px*/
	z-index: 100;
	position: absolute;
	width: 200px;
	height: 200px;
	line-height: 16px;
	font-size: 14px;
	border-radius: 15px;
	color: white;
	background-color: rgba(33, 31, 38, .9);
}
progress
{
	 /*no mq */
	width: 100px;
}
 #mclose
{
	 /* no mq */
	margin: 0px 0px 0px 0px;
	padding: 10px 10px 10px 10px;
	position: fixed;
	top: 0px;
	right: 0px;
	max-width: 50px;
	max-height: 50px;
	font-size: 50px;
	line-height: 50px;
	color: white;
	cursor: pointer;
	text-align: center;
	justify-content: center;
}
 #splitscreen
{
	 /* no mq */
	width: 7px;
	background-color: dodgerblue;
	top: 10px;
	bottom: 10px;
	left: var(--main-left);
	position: absolute;
	cursor: ew-resize;
}
 #board
{
	 /* no mq */
	width: 80%;
	height: 90%;
}
main 
{
	 /* no mq */
	min-width: 110vw;
	min-height: 110vh;
	margin: 0px 0px 0px 0px;
	left: 0px;
	top: 0px;
	width: 110vw;
	height: 110vh;
	overflow: hidden;
}
#frbox
{
	 /* no mq */
	width: 320px;
	height: 120px;
	position: fixed;
	right: 100px;
	bottom: 0px;
	overflow: hidden;
	z-index:50;
	background-color:var(--main-black);
}
#frbox>table /* no mq */
{
	width: 100%;
	height: 100%;
}
 #toasthead
{
	 /* no mq */
	margin:0px 0px 0px 0px;
	text-align: center;
	box-sizing:border-box;
	color: #fff;
}
 #toastmsg
{
	 /* no mq */
	color: #fff;
	margin:0px 0px 0px 0px;
	white-space: nowrap;
	width: auto;
	height: 49%;
	box-sizing: border-box;
}
 .toast
{
	 /* no mq */
	min-width: 100px;
	height: 4.5em;
	color: #fff;
	border-radius: 2px;
	position: fixed;
	z-index: 100;
	right:50px;
	top:50px;
	display:inline-block;
	margin:0px 0px 0px 0px;
	padding:5px;
	text-align: center;
	background-color: black;
	animation-name: hitcorners;
	animation-duration: 4s;
	animation-fill-mode: forwards;
}
 @keyframes fadein /* no mq */
{
	from 
	{
		opacity: 0;
	}
	to 
	{
		opacity: 1;
	}
}
 @keyframes fadeout /* no mq */
{
	from 
	{
		opacity: 1;
	}
	to 
	{
		opacity: 0;
	}
}
 @keyframes hitcorners /* no mq */
{
	0%
	{
		opacity:0;
		top: unset;
		right: 10px;
		left:unset;
		bottom:100%;
	}
	15%
	{
		opacity:1;
		top: unset;
		right: 10px;
		left:unset;
		bottom:90%;
	}
	85%
	{
		opacity:1;
		top: unset;
		right: 10px;
		left:unset;
		bottom:10%;
	}
	90%
	{
		opacity:0;
		top: unset;
		right: 10px;
		left:unset;
		bottom:50%;
	}
	100%
	{
		opacity:0;
		top: unset;
		right: 10px;
		left:unset;
		bottom:50%;
	}
}
footer[data-status='1']
{
	height: 225px !important;
}
footer[data-status='2']
{
	height: 90% !important;
}
@media only screen and (max-width: 600px)
{
	 :root /* max 600px */
	{
		 --main-left: Calc(0px);
		 --line-height: 18px;
		 --font-size: 12px;
		 --main-bottom: 5px;
		 --main-bg: rgba(255, 255, 255, .9);
		 --main-black: rgba(33, 31, 38, .9);
	}
	 *
	{
		 /*max 600px*/
		box-sizing: border-box;
		font-family: monospace;
	}
	 #sidebar
	{
		 /*max 600 px*/
		padding-left:0px;
		padding-right:0px;
		top: 5px;
		border-radius:16px;
		bottom:5px;
		position: absolute;
		display: block;
		right:var(--main-left);
		width: 350px;
		overflow-y: hidden;
		overflow-x: hidden;
		height:calc(100vh - 10px);
		min-height:calc(100vh - 290px);
		background-color: whitesmoke;
	}
	 .side
	{
		 /*max 600 px*/
		position:absolute;
		width:100%;
		border:1px solid red;
		padding:5px;
		overflow:auto;
		display:none;
		top:75px;
		bottom:230px;
	}
	body, html/*max 600 px*/
	{
		margin: 0px 0px 0px 0px;
		border: black solid 0px;
		padding: 2px 2px 2px 2px;
		min-height: 400px !important;
		min-width: 600px !important;
		width: 100vw;
		height: 100vh;
		max-width: 100vw;
		max-height: 100vh;
		overflow:hidden;
		background-color: var(--main-black);
		overflow: hidden;
	}
	 .ybar /*max 600 px*/
	{
		width: 100%;
		height: 7px;
		background-color: dodgerblue;
		display: block;
		position: relative;
		top: -2px;
		cursor: ns-resize;
	}
	 .xbar /*max 600 px*/
	{
		width: 3px;
		height: 100%;
		background-color: dodgerblue;
		position: relative;
		cursor: ew-resize;
		float: right;
	}
	 #navbar 
	{
		 /*max 600 px*/
		height: 70px;
		background-color: var(--main-black);
		top:0px;
		position:absolute;
		left:0px;
		width: 350px;
		border: 3px solid dodgerblue;
		border-top-left-radius: 16px;
		border-top-right-radius: 16px;
		text-align: center;
		color: white;
	}
	 #docker 
	{
		 /*max 600 px*/
		border-top: 3px smooth dodgerblue;
		width: 350px;
		height: 225px;
		position:absolute;
		display: inline-block;
		padding: 5px 5px 5px 5px;
		background-color: var(--main-black);
		overflow: hidden;
		border: 3px solid dodgerblue;
		bottom:0px;
	}
	 #findbar, #replacementbar
	{
		 /*max 600 px*/
		width:100%;
		height:1.5em;
		padding:3px;
		outline:none;
		border:2px solid dodgerblue;
		line-height:1.5em;
		border-radius:10px;
	}
}
   </STYLE>
		</head>
			<body class="loading">
				<div id="modal">
			</div>
				<aside id="sidebar" class="cmd dotfiles">
					<header id="navbar">
						<button onclick="unloadcheck = false;location.reload()" id='reloadbtn'>RELOAD
					</button> 
						<button onclick="unloadcheck = false;location.replace(window.location.href)" id='replacebtn'>REPLACE
					</button> 
						<button onclick="unloadcheck = false;location.assign(myServer.php_self)">assign
					</button>
					<hr>
						<label for="ttcheckbox">Ttips
					</label> 
					<input id="ttcheckbox" type="checkbox"> 
						<label for="rootfoldercheckbox">Rfolder
					</label>
					<input id="rootfoldercheckbox" type="checkbox" onclick=" this.checked? $('homeroot').dataset.full=$('homeroot').innerHTML=myServer.document_root.replace('\/public_html',''):$('homeroot').dataset.full=$('homeroot').innerHTML=myServer.document_root;" >
						<label for="dotfiles">DF
					</label> 
					<input id="dotfiles" type="checkbox" onchange="this.checked?sidebar.classList.add('dotfiles'):sidebar.classList.remove('dotfiles');"> 
						<label for="wordwrap">Wwrap 
					</label>
					<input id="wordwrap" type="checkbox" onclick="if(this.checked){ editor.setAttribute('wrap','soft'); }else{ editor.setAttribute('wrap','off'); }">
				</header>
					<div id="cmd" class="side">
					 <SCRIPT  id="myScript"></SCRIPT>
						<span id="scriptTagInnerText">
					</span> 
						<textarea id="scriptTagInner" cols="30" rows="10" style="width:80%;outline:3px solid dodgerblue;float:left" onfocus="if(typeof myScript!='object'){const scrpt=document.createElement('script');scrpt.setAttribute('id','myScript'); document.head.appendChild(scrpt);}">
					</textarea>
					<input type="button" value="Set" onmousedown="lset('SCRPTINR',this.previousElementSibling.value)" onmouseup="$('scriptTagInnerText').innerHTML=lget('SCRPTINR');this.previousElementSibling.value='';" onclick="try{$('myScript').innerHTML+=lget('SCRPTINR')}catch(error){console.log(error);}"> 
						<button onclick="$('myScript').remove(); $('scriptTagInnerText').innerHTML=''">clear
					</button>
					<hr>
						<label for="commandline">Command Line Interface
					</label> 
					<input id="commandline" autocomplete="off" type="text" data-command="console.log(''),alert(''),$(''),$q('')," value="" oninput="" onkeydown="if(event.which===13){this.nex().focus();}">
					<input type="button" id="runcmdline" value="Run" onfocus="this.setAttribute('onclick','try{'+this.prev().value+'}catch(error){log(error);}')" onmousedown="this.setAttribute('onclick','try{'+this.prev().value+'}catch(error){log(error);}')" onmouseup="" onclick="">
					<hr>
						<label for="console">Console.logs
					</label>
					<input id="console" type="text" data-command="spc.indexOf(''),window.innerWidth,location.href,Date.now()" value="" onblur="" autocomplete="off" spellcheck="false" oninput="this.nextElementSibling.setAttribute('onclick','console.log('+this.value+')')" onkeydown="if(event.which===13){this.nextElementSibling.click();}">
					<input type="button" id="logbutton" value="log" onfocus="" onmousedown="" onmouseup="" onclick="">
						<button onclick="$('myLog').innerHTML=''; console.logs.length=0;">clear
					</button> 
					<hr>
						<div id="myLog"> 
					</div>
				</div>
					<div id='upload' class="side">
						<form id="upload_form" enctype="multipart/form-data" method="post" onsubmit="return false" action="Server.php_self" name="upload_form">
							<p>
							<input type="file" name="file1[]" id="file1" multiple>
							<br>
							<input type="button" name="Upload" value="Upload File" onclick="uploadFile()">
								<progress id="progressBar" value="0" max="100">
							</progress>
						</p>
							<p id="uploadstatus">
						</p>
							<p id="status">
						</p>
					</form>
						<div id="uploadedfiles">
							<li id="uploadedroot" class="folder" data-full="<?= (__DIR__); ?>/UPLOAD/" onclick="fetchfolder(this)">
							 <?= (__DIR__); ?>/UPLOAD
						</li>
							<ol>
						</ol>
					</div>
				</div>
					<div id="server" class="side">
						<p id="ssemessage"> 
					</p>
				</div>
					<div id="spare" class="side">
				</div>
					<div id="filesystem" class="side">
						<ol>
							<li id="homeroot" class="folder" data-full="<?= (__DIR__); ?>" onclick="fetchfolder(this)">
							 <?= (__DIR__); ?> 
						</li>
							<ol>
								<f/ol>
							</ol>
						</div>
							<footer id="docker" data-status="1">
								<button onclick="if(docker.dataset.status==1){ this.innerHTML='⬇️'; docker.dataset.status=2; }else{ docker.dataset.status=1;this.innerHTML=' ⬆️ ';$('sidebar').style.bottom='5%';};" style="position:relative;top:-10px;">⬆️
							</button> 
								<table style="table-layout:fixed;max-width:95% !important;margin-left:2.5%;overflow:hidden;">
									<caption id="captiontext" style="color:white">Alert: You are signed in
								</caption>
									<colgroup> 
										<col span="1" style="background-color:limegreen"> 
											<col span="1" style="background-color:tan"> 
												<col span="1" style="background-color:red"> 
													<col span="1" style="background-color:white"> 
												</colgroup>
													<thead> 
														<tr>
															<th>
																<button id="cmdbutton" onclick='sidebar.setAttribute("class",this.id.btn());' class='sbbtn'>CMD
															</button>
														</th>
															<th>
																<button id="serverbutton" onclick='sidebar.setAttribute("class",this.id.btn());' class='sbbtn'>Server
															</button>
														</th>
															<th>
																<button id="filesystembutton" onclick='sidebar.setAttribute("class",this.id.btn());$("homeroot").click()' class='sbbtn'>Files
															</button>
														</th>
															<th>
																<button id="uploadbutton" onclick='sidebar.setAttribute("class",this.id.btn());' class='sbbtn'>Upload
															</button>
														</th>
													</tr>
														<tr>
															<th>
															<input type=button value=innerHeight onclick=toast(window.innerHeight)> 
														</th>
															<th>
																<button style="max-width:50%" onclick="window.open('https://www.w3schools.com/php/phptryit.asp?filename=tryphp_compiler')">PHP
															</button>
														</th>
															<th>
																<button onclick="window.open('https://www.w3schools.com/cssref/default.asp')">CSS
															</button>
														</th>
															<th>
																<button onclick="filehandle('openfile',myServer.document_root+'/myScript.js');if(!sidebar.classList.contains('filesystem')){$('filesystembutton').click();}setTimeout(function(){ if(nod($('myScript.js'))){ Nod.classList.add('selected'); } },3000); ">Script
															</button> 
														</th>
													</tr>
														<tr>
															<th>
																<button onclick='codemode();'>code mode 
															</button>
														</th>
															<th>
																<button id ='frboxbutton' onclick="frbox.classList.toggle('hidden'); frbox.classList.contains('hidden')?this.innerHTML ='Find Replace':this.innerHTML = 'FR OFF';" > Find Replace 
															</button>
														</th>
															<th>
																<button onclick="gettokens()">get tokens 
															</button>
														</th>
															<th>
																<button onclick="filehandle('openfile',myServer.document_root+'/boilerplate.js');if(!sidebar.classList.contains('filesystem')){$('filesystembutton').click();}setTimeout(function(){ if(nod($('boilerplate.js'))){ Nod.classList.add('selected'); } },3000); ">Boiler
															</button>
														</th>
													</tr>
														<tr>
															<th>
																<button onclick="navigator.clipboard.writeText(editor.value);toast('Copied To Clipboard',omnibox.vale)">Copy 
																<wbr>Text
															</button>
														</th>
															<th>
														</th>
															<th>
																<button onclick="prettyprint($('openfilename').value.split('.').last())">prettyfy
															</button>
														</th>
															<th>
																<button onclick="if(!sidebar.classList.contains('filesystem')){$('filesystembutton').click();}setTimeout(function(){ if(nod($('index.php'))){ Nod.click(); } },3000); ">Index
															</button>
														</th>
													</tr>
														<tr>
															<th>
															<input type="button" value="art">
														</th>
															<th>
																<button onclick="toast('head','message')">toast
															</button>
														</th>
															<th>
																<button onclick="editor.value=editor.value.replace(/\s{1,}/ig,' ')">Minify
															</button>
														</th>
															<th>
																<button onclick="filehandle('openfile',myServer.document_root+'/myStylesheet.css');if(!sidebar.classList.contains('filesystem')){$('filesystembutton').click();}setTimeout(function(){ if(nod($('myStylesheet.css'))){ Nod.classList.add('selected'); } },3000); ">Style
															</button> 
														</th>
													</tr>
														<tr>
															<th>
																<button style="" onclick="text2file(editor.value, openfilename.value)">SavePage
															</button>
														</th>
															<th>
																<button onclick="editor.value += htmlentities.decode(basictemplate)">Tplate
															</button>
														</th>
															<th>
																<button style="" onclick="codepoints()">cpoint
															</button>
														</th>
															<th>
																<button onclick="filehandle('openfile',myServer.document_root+'/head.php');if(!sidebar.classList.contains('filesystem')){$('filesystembutton').click();}setTimeout(function(){ if(nod($('head.php'))){ Nod.classList.add('selected'); } },3000); ">head
															</button> 
														</th>
													</tr>
												</thead>
											</table>
										</footer>
									</aside>
										<header id="toolbar">
										<input id="omnibox" type="url" autocomplete="off" spellcheck="false" onkeydown="if(event.which===13){frameHandle('src',this.value);}"> 
											<button onclick="var newWin=window.open($('omnibox').value);">newTab
										</button> 
											<button onclick="stage('myFrame');framehandle(omnibox.value);">inframe
										</button> 
											<button onclick="lset(editor.value,omnibox.value);">TA2SRCDOC
										</button>
										<hr>
										<input id="openfilename" autocomplete="off" spellcheck="false" type="text" onfocus="this.value=this.value.replace(myServer.document_root+'/','')" oninput="omnibox.value =path2url(this.value);" onblur="this.value=myServer.document_root='/'+this.value.replace(myServer.document_root,""); $('omnibox').value =path2url(this.value);" placeholder="/home3/johnnzh5/public_html/"> 
											<button onclick="buffer(savefile);stage('editor');">save
										</button> 
											<button onclick="lset('editorsaved',editor.value);editor.value=''; openfilename.value=myServer.document_root+'/'+'NewFile.html'">new
										</button> 
											<button onclick="let T; T = JSON.parse(lget(openfilename.value.split('/').last())); alert(T);">open
										</button>
									</header>
										<section id="container" onclick="" class="editor">
											<textarea id="gutter" cols="6" onscroll="this.scrollTop=editor.scrollTop" onclick="hault(true); return false;" disabled>
										</textarea> 
											<textarea class="stage" data-scroll="0" onscroll="" id="editor" cols="40" wrap="off" onfocus="" oninput="centerview()" autocomplete="off" spellcheck="false" > 
										</textarea> 
											<span class="xbar" style="max-height:95%" onmousedown="dragboth(containerwidth);"> 
										</span>
									</section>
										<span id="splitscreen" onmousedown="dragboth(mainleft)">
									</span> 
										<audio id="beeper">
										<source src="https://shahintutorials.com/beep.wav" type="audio/ogg">
									</audio>
										<div id="frbox" class="hidden">
											<div style="width:20px; height:20px; background-color:red;float:left;" onmousedown="dragboth(frboxdrag)">
										</div>
											<div style="width:20px; height:20px; background-color:yellow;float:right;" onclick="frboxbutton.click()">
										</div>
											<table style="height:100px; width:100%, margin-top:0px;background-color:white;border-collapse: collapse;" >
												<tbody style="height:100px;">
													<tr>
														<td colspan=2> 
														<input id="findbar" autocomplete="off" spellcheck="false" type='text' style="margin:0px; width:90%;" data-onenter="findbutton" >
													</td>
														<td> 
														<input id="findbutton" type=button value="search" onclick="searcher()">
													</td>
														<td> 
															<span id="frresults">
														</span>
													</td>
												</tr>
													<tr>
														<td colspan=2> 
														<input id="replacementbar" autocomplete="off" spellcheck="false" type='text' style="margin:0px; width:90%;" >
													</td>
														<td> 
														<input id="replacementbutton" type='button' value="replace" onclick="replaceselection()" style="margin:auto auto">
													</td>
														<td> 
															<label for="caseinsensitive">i
														</label>
														<input type=checkbox id="caseinsensitive" value="i">
															<label for="up">up
														</label>
														<input type=checkbox id='up' value="up">
															<label for="regex">RegExp
														</label>
														<input type=checkbox id='regex' value="regex">
													</td>
												</tr>
											</tbody>
										</table> 
									</div>
									 <SCRIPT > const myServer = <?=json_encode($Server); ?>;
		SAVED = `<?php print_r($Server); ?>`;
		 </SCRIPT> 
									 <SCRIPT  type="text/javascript">"use strict"
		function beep()
		{
		 $('beeper').play();
		}
		SAVED = SAVED.replace(/Array\s\(\s([^\)]*)\)/g,"$1");
		SAVED = SAVED.replace(/=>/g,"\n<br>");
		SAVED = SAVED.replace(/\[/g,"\n<br>\n<br>[");
		SAVED = SAVED.replace(/^[^\[]*/m,"");
		$("server").innerHTML = SAVED+"<br><br>"+"Last Modified:"+"<br>"+document.lastModified;
		const container = $('container');
		const editor = $('editor');
		const sidebar = $('sidebar');
		const navbar = $('navbar');
		const toolbar = $('toolbar');
		const docker = $('docker');
		const captiontext=$('captiontext');
		const OPENFILENAME = $('openfilename');
		const $openfilename = $('openfilename');
		var frbox = $('frbox');
		var gutter = $('gutter');
		var omnibox = $('omnibox');
		let mymodal;
		let poster;
		var openfile;
		function toast(head,msg)
		{
			let toasts = document.getElementsByClassName('toast');
			let toast = document.createElement("DIV");
			toast.setAttribute("class","toast");
			toast.setAttribute("onmouseover","this.remove();");
			let toasthead = document.createElement("DIV");
			toasthead.setAttribute("id","toasthead");
			let toastmsg = document.createElement("DIV");
			toastmsg.setAttribute("id","toastmsg");
			if(msg != undefined)
			{
				toastmsg.appendChild(document.createTextNode(msg));
			}
			if(head != undefined)
			{
				toasthead.appendChild(document.createTextNode(head));
			}
			toast.appendChild(toasthead);
			toast.appendChild(document.createElement("BR"));
			toast.appendChild(toastmsg);
			document.body.appendChild(toast);
			timeouthandle = setTimeout(function()
			 {
			if(islong(toasts[0]))
			 {
			toasts[0].remove();
			 }
			 }, 5000);
		}
		 (function(proxied) 
		{
		window.alert = function() 
		 {
		return toast.apply("Alert",arguments);
		 };
		})(window.alert);
		function gettokens()
		{
			let text = editor.value;
			text = text.replace("\h*","@");
			text = text.split("");
			let i = 0;
			const tokens = new Set();
			const symbols = new Set();
			let toke = "";
			let sym = "";
			while (i < text.length)
			{
				if (/\w/.test(text[i]))
				{
					toke += text[i];
				}
				else
				{
					tokens.add(toke);
					toke = "";
				}
				if (/\W/.test(text[i]))
				{
					sym += text[i];
				}
				else
				{
					symbols.add(sym);
					sym = "";
				}
				i++;
			}
			editor.value = "";
			const iterator1 = tokens.entries();
			for (const toks of iterator1)
			{
				editor.value += toks + "\n";
			}
			const iterator2 = symbols.entries();
			for (const syms of iterator2)
			{
				editor.value += syms + "\n";
			}
		}
		function savestate(flag)
		{
			if (flag === "open")
			{
				if( lget('pagesaved') )
				{
					editor.value = lget('pagesaved');
				}
				if( lget('omnisave') )
				{
					 $('omnibox').value = lget('omnisave');
				}
				if( lget('openfilesave') )
				{
					 $openfilename.value = lget('openfilesave');
				}
				if( lget('openfilesave2') )
				{
					 $openfilename.placeholder = lget('openfilesave2');
				}
				if(lget('codemode') === "on")
				{
					codemode();
				}
				if(lget('aside'))
				{
					sidebar.setAttribute('class', lget('aside'));
				}
				if(lget('filesystemscroll') )
				{
					 $('filesystem').scrollTop = lget('filesystemscroll');
				}
			}
			else
			{
				lset('pagesaved', editor.value);
				lset('omnisave', $('omnibox').value);
				lset('openfilesave', $openfilename.value);
				lset('aside', sidebar.getAttribute('class'));
				lset("filesystemscroll", $('filesystem').scrollTop);
			}
		}
		var log;
		console.stdlog = log = console.log.bind(console);
		console.logs = [];
		console.log = function ()
		{
			console.logs.push(Array.from(arguments));
			try
			{
				console.stdlog.apply(console, arguments);
			}
			catch (error)
			{
				 $('myLog').innerHTML = error;
			}
			 $('myLog').innerHTML += console.logs.join(',');
		}
		var fetchedURI;
		async function myFetch(path)
		{
			let x = await fetch(path);
			let y = await x.text();
			return y;
		}
		async function fetchfolder(folder)
		{
			if ($q('.selected'))
			{
				 $q('.selected').classList.remove('selected');
			}
			folder.classList.add('selected');
			if (folder.classList.contains('open'))
			{
				folder.nextElementSibling.innerHTML = "";
				folder.classList.remove('open');
			}
			else
			{
				let full = folder.dataset.full;
				let y;
				y = await myFetch(myServer.php_self + "?" + "openfolder=" + full);
				folder.classList.add('open');
				folder.nextElementSibling.innerHTML = y;
			}
		}
		const lines = [];
		function addlinenumbers(int)
		{
			let rows = 1;
			document.normalize();
			if(/\n/.test(editor.value))
			{
				rows = editor.value.match(/\n/g).length + 2;
			}
			let ln = $('gutter');
			ln.value=" ";
			for (let i = 1;
			i <= rows;
			i++)
			{
				ln.value += i + "\n";
			}
			ln.scrollTop = editor.scrollTop;
		}
		function realign()
		{
			document.body.width = window.innerWidth + "px";
			document.body.height = window.innerHeight + "px";
			let over = $('container').hei(true)%18;
			if(window.innerWIdth > 600)
			{
				document.documentElement.style.setProperty('--main-bottom', (over+5) + 'px');
			}
		}
		function stylecheck(elm, stl, int)
		{
			let compStyles = window.getComputedStyle(elm);
			if (int === true)
			{
				return parseInt(compStyles.getPropertyValue(stl));
			}
			else
			{
				return compStyles.getPropertyValue(stl);
			}
		}
		function savefile(fname, contents)
		{
			savestate();
			if (fname === undefined)
			{
				fname = $openfilename.value;
			}
			let formdata = new FormData();
			formdata.append('savefile', fname);
			if (contents === undefined)
			{
				contents = editor.value;
			}
			formdata.append('contents', contents);
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function ()
			{
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
				{
					parseresult(this.responseText, fname);
				}
			}
			xmlhttp.open("POST", myServer.php_self, true);
			xmlhttp.send(formdata);
			if (fname === myServer.script_filename)
			{
				setTimeout(function()
				 {
				 $('reloadbtn').click();
				 }
				 , 3000);
			}
		}
		var stageList = ['myFrame', 'editor', 'poster', 'art', 'editor'];
		function stage(stg)
		{
			var bool;
			if (stg === "undefined" || stageList.indexOf(stg) === -1)
			{
				stageList.push(stageList.shift());
			}
			if (stg != "undefined" && stageList[0] != stg && stageList.indexOf(stg) != -1)
			{
				do 
				{
					stageList.push(stageList.shift());
				}
				while (stageList[0] != stg);
			}
			switch(stageList[0])
			{
				case "myFrame":
				mymodal = modal('on',true);
				if(mytypeof(myFrame) == 'Null')
				{
					let myFrame = make("iframe","id=myFrame&style=width:90%;height:90%;background-color:white;","myFrame");
					mymodal.appendChild(myFrame);
				}
				break;
				case "editor":
				modal("off");
				break;
				case "art":
				mymodal = modal('on',true);
				poster = make("iframe","id=art&style=width:90%;height:90%;background-color:white;","art");
				mymodal.appendChild(myFrame);
				break;
				case "poster": 
				mymodal = modal('on',true);
				poster = make("div","id=poster&style=width:90%;height:90%;background-color:lightblue;","poster");
				mymodal.appendChild(myFrame);
				document.body.setAttribute("class","modal");
				break;
				case "editor":
				break;
			}
		}
		var filebuffer = false;
		async function filehandle(action, data, type)
		{
			if(toolbar.classList.contains('show'))
			{
				 return;
			}
			if(type == undefined)
			{
				type = 'text';
			}
			let formdata = new FormData();
			formdata.append(action, data);
			if(type === "blob")
			{
				fetch(myServer.php_self,
				 {
				method: "POST",
				body: formdata
				 })
				 .then((res) => 
				 {
				return res.blob();
				 })
				 .then((data) => 
				 {
				var a = document.createElement("a");
				a.href = window.URL.createObjectURL(data);
				a.download = data;
				a.click();
				 });
			}
			else if(type == "text")
			{
				fetch(myServer.php_self,
				 {
				method: "POST",
				body: formdata
				 })
				  .then((response) => response.text())
				 .then((resultss) => parseresult(resultss));
			}
		}
		function minimize(elem)
		{
			if (elem.parentElement.tagName == "BODY")
			{
				let parentid = elem.dataset.parentid;
				 $(parentid).appendChild(elem);
			}
			else
			{
				 elem.removeAttribute('style');
				 document.body.appendChild(elem);
			}
		}
		function parseresult(resultss)
		{
			let result = resultss.split(/\n/);
			let rtext;
			 let filename;
			 let fname;
			 let full;
			let firstline = result.shift();
			if(/-/.test(firstline))
			{
				let docinfo = mysplit(firstline, "-");
				rtext = mysplit(docinfo[0], ":").concat(mysplit(docinfo[1], ":"));
			}
			else
			{
				rtext = mysplit(firstline,":");
			}
			let action = rtext[0];
			let fullname = full = rtext[1];
			filename = fname = fullname.split('/').last();
			let mtime = rtext[2];
			let ctime = rtext[3];
			switch(action.trim())
			{
				case "deleted":
				 $q('[data-full="'+rtext[1]+'"]').remove();
				break;
				case "saved":
				toast(rtext[1], "was saved to the server");
				break;
				case "copied":
				toast(rtext[1], "was copied to the clipboard");
				let filetext1 = result.join("\n");
				navigator.clipboard.writeText(filetext1);
				break;
				case "download":
				toast(rtext[1], "beginning download");
				let filetext = result.join("\n");
				text2file(filetext,rtext[1]);
				break;
				case "FAILURE":
				toast("Alert", "There was a Problem");
				break;
				case "opened":
				document.title = fname;
				populatefilename(fullname);
				var myJsonString = JSON.stringify(result);
				lset(fname, myJsonString);
				editor.value = result.join("\n");
				buffer(addlinenumbers);
				break;
				default: alert("the results"+rtext[0],result);
			}
		}
		window.addEventListener('pageshow', myFunction);
		function myFunction(event) 
		{
			if (event.persisted) 
			{
				console.log("The page was cached by the browser");
			}
			else 
			{
				console.log("The page was NOT cached by the browser");
			}
		}
		function insertat(element, character, preserve)
		{
			let len = 0;
			let len2 = 0;
			let el= element|event.target;
			let ch = character|event.key;
			let len1 = character.length|1;
			let pr = preserve|false;
			el.focus(
			 {
			preventScroll: true
			 });
			if(el.selectionStart)
			{
				var startPos = el.selectionStart;
				var endPos = el.selectionEnd;
				let starttext = el.value.substring(0, startPos);
				let endtext = el.value.substring(endPos);
				if(pr == true)
				{
					ch = el.value.substring(startPos, endPos)+ch;
					len2 = ch.length;
				}
				el.value = starttext + ch + endtext;
				len = len1-len2;
				el.selectionStart = el.selectionEnd = endPos +len;
			}
			else
			{
				 toast('no selection');
			}
		}
		function mytime()
		{
			let date = new Date();
			captiontext.innerHTML = date.toString().replace("Pacific Standard Time","PST");
			setTimeout(mytime,500);
		}
		function uploadFile()
		{
			var file = $("file1");
			var formdata = new FormData($('upload_form'));
			var ajax = new XMLHttpRequest();
			ajax.upload.addEventListener("progress", progressHandler, false);
			ajax.addEventListener("load", completeHandler, false);
			ajax.addEventListener("error", errorHandler, false);
			ajax.addEventListener("abort", abortHandler, false);
			ajax.open("POST", myServer.php_self);
			ajax.send(formdata);
		}
		function progressHandler(event)
		{
			 $("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
			var percent = (event.loaded / event.total) * 100;
			 $("progressBar").value = Math.round(percent);
			 $("status").innerHTML = Math.round(percent) + "% uploaded";
		}
		function completeHandler(event)
		{
			 $("status").innerHTML = event.target.responseText;
			 $("progressBar").value = 0;
		}
		function errorHandler(event)
		{
			 $("status").innerHTML = "Upload Failed";
		}
		function abortHandler(event)
		{
			 $("status").innerHTML = "Upload Aborted";
		}
		function codemode()
		{
			editor.classList.toggle('codemode');
			if (editor.classList.contains('codemode'))
			{
				lset('codemode', 'on');
				editor.style.backgroundColor = '#000000';
				editor.style.color = '#FFFFFF';
			}
			else
			{
				lset('codemode', 'off');
				editor.style.color = '#000000';
				editor.style.backgroundColor = '#FFFFFF';
			}
		}
		function framehandle(value)
		{
			stage('myFrame');
			let urlhistory;
			myFrame.src = value;
			if (!lget('urlhistory'))
			{
				lset('urlhistory', value + ",");
			}
			urlhistory = lget('urlhistory');
			urlhistory = mysplit(urlhistory);
			if (urlhistory.indexOf(value) === -1)
			{
				urlhistory.push(value);
				lset('urlhistory', urlhistory.join(','));
			}
		}
		function frboxdrag(event)
		{
			let fr = $('frbox');
			let totalleft = event.pageX;
			let totaltop = event.pageY;
			let sstring = "left:"+totalleft+"px !important;top: " +totaltop+ "px !important";
			 $('frbox').setAttribute("style", sstring);
		}
		function containerwidth(event)
		{
			let rect = myrect($('container'));
			let offset = rect[1];
			let totalwidth = event.clientX - offset;
			let sstring = "width:"+ totalwidth+"px !important;";
			 $('container').setAttribute("style",sstring);
			 $('toolbar').setAttribute("style",sstring);
		}
		function mainleft(event)
		{
			document.documentElement.style.setProperty('--main-left' , event.clientX +"px");
		}
		function dragboth(func)
		{
			hault(true);
			if(!document.body.classList.contains('modal'))
			{
				let mymodal = modal('on');
				mymodal.addEventListener("mousemove", func ,{passive: true });
				mymodal.addEventListener("mouseup", function()
				 {
				mymodal.removeEventListener('mousemove', func, 
				{
					passive: true 
				});
				mymodal.removeEventListener('mouseup', function()
				{
				}
				,
				{
					passive: true 
				});
				modal("off");
				 });
			}
		}
		function path2url(path)
		{
			let newurl = "https://" + myServer.http_host + path.replace(myServer.document_root, "");
			return newurl;
		}
		async function populatefilename(path)
		{
			toolbar.classList.add('show');
			let parts=path.split('/');
			let fname = parts.pop();
			let dir = encodeURIComponent(parts.join('/'));
			let y = await myFetch(path2url(myServer.php_self+"?isdir="+dir));
			if(y == "true")
			{
				 $openfilename.placeholder = path;
				 $openfilename.value = path;
				 $('omnibox').value = path2url(path);
			}
			else
			{
				 alert("There was a problem", y);
			}
			setTimeout(function(){ toolbar.classList.remove('show'); }, 1500);
		}
		let basictemplate = "&#60;&#47;&#66;&#79;&#68;&#89;&#62;&#10;&#60;&#47;&#72;&#84;&#77;&#76;&#62;&#60;&#33;&#100;&#111;&#99;&#116;&#121;&#112;&#101;&#32;&#72;&#84;&#77;&#76;&#62;&#10;&#60;&#72;&#84;&#77;&#76;&#32;&#108;&#97;&#110;&#103;&#61;&#39;&#101;&#110;&#45;&#85;&#83;&#39;&#62;&#10;&#60;&#72;&#69;&#65;&#68;&#62;&#10;&#60;&#77;&#69;&#84;&#65;&#32;&#99;&#104;&#97;&#114;&#115;&#101;&#116;&#61;&#39;&#117;&#116;&#102;&#45;&#56;&#39;&#62;&#10;&#60;&#84;&#73;&#84;&#76;&#69;&#62;&#117;&#110;&#116;&#105;&#116;&#108;&#101;&#100;&#60;&#47;&#84;&#73;&#84;&#76;&#69;&#62;&#10;&#60;&#83;&#84;&#89;&#76;&#69;&#62;&#60;&#47;&#83;&#84;&#89;&#76;&#69;&#62;&#10;&#60;&#47;&#72;&#69;&#65;&#68;&#62;&#10;&#60;&#66;&#79;&#68;&#89;&#62;&#10;&#60;&#83;&#67;&#82;&#73;&#80;&#84;&#62;&#60;&#47;&#83;&#67;&#82;&#73;&#80;&#84;&#62;&#10;&#60;&#47;&#66;&#79;&#68;&#89;&#62;&#10;&#60;&#47;&#72;&#84;&#77;&#76;&#62;";
		function keyboardshortcuts()
		{
		}
		window.addEventListener("keydown", function (event)
		{
		let curKey = event.key;
		nod(event.target);
		if (Nod.id === "commandline" || event.target.id === "findbar" || event.target.id === "console" || event.target === $('omnibox'))
		 {
		if (curKey == "ArrowUp" || curKey == "ArrowDown")
		 {
		var previous = Nod.dataset.command || lget('urlhistory');
		previous = mysplit(previous);
		if (curKey == "ArrowUp")
		 {
		previous.push(previous.shift());
		 }
		else
		 {
		previous.unshift(previous.pop());
		 }
		Nod.value = previous[0];
		var txt = previous.join(',');
		if (Nod.dataset.command)
		 {
		Nod.dataset.command = txt;
		 }
		else
		 {
		lset('urlhistory', txt);
		 }
		 }
		 }
		if(event.getModifierState("CapsLock") && event.key.length === 1) 
		 {
		hault();
		beep();
		insertat(event.target, event.key.toLowerCase(), false);
		 }
		if (curKey == "Escape")
		 {
		 $('runcmdline').click();
		 }
		if(event.ctrlKey || event.metaKey){
		switch(curKey){
		case 'a': 
		case 'A': hault(true); editor.focus(); editor.select();
		break;
		case 's': 
		case 'S': hault(true);savefile();
		break;
		case 'f':
		case 'F': hault(true); let text = window.getSelection().toString(); if(frbox.classList.contains('hidden')){ $('frboxbutton').click(); }findbar.value=text;findbar.focus(); findbar.select();
		break;
		default:
		  }
		 }
		if (Nod.id === "editor")
		 {
		if (curKey == "Tab")
		 {
		hault(true);
		const cursor = Nod.selectionStart;
		const cursend = Nod.selectionEnd;
		let selection = window.getSelection();
		selection = selection.toString();
		let len = selection.length;
		if(event.shiftKey)
		 {
		let newselect = selection.toString().split("\n");
		selection = [];
		newselect.forEach(function(element)
		{
			if(/\s/.test(element.charAt(0)))
			{
				selection.push(element.substring(1));
			}
			else
			{
				selection.push(element);
			}
		});
		selection = selection.join("\n");
		 }
		else
		 {
		if(/\n/ig.test(selection[len-1]))
		 {
		Nod.selectionEnd = cursend-1;
		selection = window.getSelection();
		selection = selection.toString();
		 }
		selection="\t"+selection.replace(/\n/ig,"\n\t");
		 }
		Nod.value = Nod.value.slice(0, cursor) + selection + Nod.value.slice(Nod.selectionEnd);
		if(cursor === cursend)
		 {
		Nod.selectionStart = Nod.selectionEnd = cursor+1;
		 }
		else
		 {
		Nod.selectionStart = cursor;
		Nod.selectionEnd = cursor+selection.length;
		 }
		 }
		else if (curKey == "Enter")
		 {
		hault();
		const cursor = Nod.selectionStart;
		const bfrval = Nod.value.slice(0, cursor);
		let lnum;
		 /\n/.test(bfrval)?lnum = bfrval.match(/\n/ig).length : lnum = 0;
		let lines=Nod.value.split("\n");
		let line = lines[lnum];
		let spacing = "";
		for(let i=0;
		i<line.length;
		i++)
		 {
		if(/\s/.test(line[i]))
		 {
		spacing+=line[i];
		 }
		else
		 {
		if(line[i] == spc[4])
		 {
		spacing+='\t';
		 }
		break;
		 }
		 }
		Nod.value = bfrval + '\n' + spacing + window.getSelection() + Nod.value.slice(Nod.selectionEnd);
		Nod.selectionStart = Nod.selectionEnd = cursor+spacing.length+1;
		buffer(addlinenumbers);
		 }
		else if (curKey == "Delete" || curKey == "Backspace")
		 {
		buffer(addlinenumbers);
		 }
		else if (curKey === "CapsLock")
		 {
		let str="";
		if (Nod.selectionStart != undefined) 
		 {
		var startPos = Nod.selectionstart;
		var endPos = Nod.selectionEnd;
		var selectedText = Nod.value.substring(startPos, endPos);
		if(selectedText == selectedText.toLowerCase())
		 {
		selectedText = selectedText.toUpperCase();
		 }
		else if(selectedText = selectedText.toUpperCase())
		 {
		 selectedText = selectedText.replace(/(\b\w)/gi,function($1)
		{
			 let C = '$1';
			 return C.toUpperCase();
		});
		 }
		else 
		 {
		selectedText = selectedText.toLowerCase();
		 }
		 }
		Nod.value = Nod.value.slice(0, startPos) + selectedText + Nod.value.slice(endPos);
		 }
		 }
		});
		window.onresize= realign();
		window.addEventListener("click", function (event)
		{
		if (event.target.tagName === "BUTTON")
		 {
		 }
		if(event.target.id === "gutter");
		 {
		 }
		if (event.target.classList.contains('sbbtn'))
		 {
		let selected = $('sidebar').className;
		let sides = $Q('.side');
		sides.forEach(function (element)
		{
			if (element.id === selected)
			{
				element.setAttribute("style", "display:block");
			}
			else
			{
				element.setAttribute("style", "display:none");
			}
		});
		 }
		});
		editor.addEventListener("scroll",function(e)
		{
		 $('gutter').scrollTop = editor.scrollTop;
		});
		 // Mousedown-------------------------------- 
		 $('gutter').addEventListener("mousedown",function(e)
		{
		myMouse="down";
		});
		 // mouseup----------------------------------
		 $('gutter').addEventListener("mouseup",function(e)
		{
		myMouse='up';
		});
		 // mousemove-------------------------------- 
		 $('gutter').addEventListener("mousemove",function(e)
		{
		});
		 // mouseover-------------------------------- 
		window.addEventListener("mouseover", function(event)
		{
		const tagz = Array("BUTTON","LI","OL","UL","INPUT");
		if (tagz.indexOf(event.target.tagName) >= 0)
		 {
		tooltip(event);
		 }
		});
		 // Mouseout-------------------------------- 
		let leavecheck;
		window.addEventListener("mouseout", function (e)
		{
		leavecheck = false;
		if (event.target.classList.contains('tooltip'))
		 {
		 $('tooltip').remove();
		event.target.classList.remove('tooltip');
		 }
		});
		//var intervalID = setInterval(function() { $('server').innerHTML = (document.lastModified); }, 1000);
		async function keepalive() 
		{
			let x = await fetch(myServer.php_self+"?loggedincheck=true");
			let y = await x.text();
			alert(y);
			setTimeout(function(){ keepalive(); }, 10000);
		}
		window.addEventListener("DOMContentLoaded", function (e)
		{
		 realign();
		if (window.history.replaceState)
		 {
		window.history.replaceState(null, null, location.href);
		 }
		savestate('open');
		keepalive();
		mytime();
		});
		window.addEventListener("contextmenu", function (event)
		{
		hault(true);
		nod(event.target);
		if( mytypeof($('contextmenu')) === 'Null')
		 {
		let mymodal = modal("on");
		let mymenu = make('div', "id=contextmenu&onmousedown=hault(true)&style=top:" + (event.clientY-10) + "px;left:" + (event.clientX-10) + "px;width:250px;", 'contextmenu');
		mymodal.appendChild(mymenu);
		if (Nod.classList.contains('file'))
		 {
		let file = event.target;
		let full = file.dataset.full;
		let filename = file.id;
		mymenu.innerHTML=`
		 <h3>${Nod.id}</h3>
		 <ol> 
		 <li onclick="filehandle('copyfile','${ full }')">Copy File</li> 
		 <li onclick="filehandle('deletefile','${ full }')">Delete File</li>
		 <li onclick="filehandle('downloadfile','${ full }')">Download File</li> 
		 <li>Change Name</li>
		 <li>Change Permissions</li> 
		 <li>File Details</li> 
		 <li>Publish</li> 
		 <li>File History</li> 
		 </ol>`;
		 }
		else if (Nod.classList.contains('folder'))
		 {
		let folder = event.target;
		let full = folder.dataset.full;
		let filename = folder.id;
		mymenu.innerHTML=`
		 <h3>${Nod.id}</h3>
		 <ol>
		 <li onclick="filehandle('deletefolder','${ full }')">Delete folder </li>
		 <li onclick="filehandle('downloadfolder','${ full }')">Download folder </li> 
		 <li>Change Name</li>
		 <li>Change Permissions</li> 
		 <li>File Details</li> 
		 <li>Publish</li> 
		 <li>File History</li> 
		 </ol>`;
		 }
		else if (Nod.id=="editor")
		 {
		mymenu.innerHTML = `
		 <h3>Menu </h3>
		 <ol> 
		 <li nmousedown="let txt = window.getSelection(); txt = txt.toString(); cset(txt)" > Copy </li> 
		 <li onmousedown="let txt = window.getSelection(); txt = txt.toString(); lset('copyspecial',txt);"> Copy Special </li> 
		 <li onclick="insertat(editor, "hi", false)"> Paste </li> 
		 <li onclick="insertat(editor, lget('copyspecial'), false)"> Paste Special </li> 
		 <li> Insert </li> 
		 <li onclick="event.target.select()"> Select All </li> 
		 <li> Go To </li> 
		 </ol>`;
		 }
		 }
		});
		</SCRIPT>
									 <SCRIPT ?>function prettyprint(lg)
									{
									 let htmlindent = 0;
									let cssindent = 0;
									let jsindent = 0;
									let phpindent = 0;
									function span()
									 {
									let num;
									let st = "";
									switch(lang())
									 {
									case "CSS": num = cssindent;
									break;
									case "JS": num = jsindent;
									break;
									case "PHP": num = phpindent;
									break;
									case "HTML": num = htmlindent;
									break;
									 }
									for(let d = 0;
									d<num;
									d++)
									 {
									st += "\t";
									 }
									return st;
									 }
									let language=["HTML"];
									if(lg != undefined){ lg=lg.toUpperCase(); if(lg=="PHP"){ lg = "HTML"; } language.push(lg); alert(lg); }
									let lang= function()
									 {
									return language.last();
									 }
									let prettycode ="";
									let Saved = "HTML";
									let comment = false;
									let mlcomment = false;
									let quotes = false;
									let dblquotes =false;
									let intag = false;
									let escaped = false;
									let inparen = false;
									let parendeep = 0;
									let str="";
									let N;
									let pre;
									let cur;
									let nex;
									let line;
									let i=0;
									const next = function(num)
									 {
									let m = 1;
									let mstr="";
									for(m=1;
									m<=num;
									m++)
									 {
									mstr += line[i+m];
									 }
									return mstr.toUpperCase();
									 }
									function parseHtml(c)
									 {
									switch(c)
									 {
									case quotes: if(c==spc[13] && pre()!= spc[10])
									 {
									quotes = false;
									 }
									else
									 {
									quotes=nex();
									 }
									prettycode += c;
									c="";
									break;
									case dblquotes: if(c==spc[14] && pre()!= spc[10])
									 {
									dblquotes = false;
									 }
									else
									 {
									dblquotes=nex();
									 }
									prettycode += c;
									c="";
									break;
									case mlcomment: if(c==spc[16] && nex() == spc[1])
									 {
									mlcomment= false;
									c = spc[16]+spc[1];
									 }
									else
									 {
									mlcomment = nex();
									 }
									prettycode += c;
									c="";
									break;
									case spc[0]: if(nex() == spc[20] && line[i+2] != 'd' && line[i+2] != "D")
									 {
									mlcomment = nex();
									prettycode += spc[0]+spc[20];
									c="";
									 }
									if(nex() !== spc[11])
									 {
									if(next(5).toLowerCase() != "input" && next(2).toLowerCase() != "hr" && next(2).toLowerCase() != "br" && next(4).toLowerCase() != "link" && next(4).toLowerCase() != "meta" && next(6).toLowerCase() != "source" && next(3).toLowerCase() != "wbr")
									 {
									htmlindent++;
									 }
									 }
									if(nex() === spc[11])
									 {
									htmlindent--;
									 }
									prettycode += "\n"+span()+c;
									c="";
									break;
									case spc[1]: prettycode+=c;
									c="";
									if(intag == true)
									 {
									htmlindent++;
									intag = false;
									 }
									if(intag == "close")
									 {
									htmlindent--;
									intag = false;
									if(parendeep == 0)
									 {
									prettycode+= "\n"+span();
									 }
									 }
									break;
									case spc[13]: if(escaped == false)
									 {
									if(dblquotes == false)
									 {
									quotes=nex();
									 }
									 }
									break;
									case spc[14]: if(escaped == false)
									 {
									if(quotes == false)
									 {
									dblquotes=nex();
									 }
									 }
									break;
									case spc[2]: inparen=true;
									parendeep++;
									break;
									case spc[3]: parendeep--;
									if(parendeep === 0)
									 {
									inparen = false;
									 }
									 }
									prettycode+= c;
									c="";
									 }
									function parseCss(c) 
									 {
									switch(c)
									 {
									case mlcomment: if(c == spc[18] && nex() == spc[11])
									 {
									mlcomment = false;
									c+=spc[11];
									i++;
									 }
									else
									 {
									mlcomment=nex();
									 }
									prettycode += c;
									c= "";
									break;
									case spc[4]: c="\n"+span()+ spc[4]+"\n";
									cssindent++;
									c+= span();
									break;
									case spc[5]: cssindent--;
									c="\n"+span()+spc[5]+"\n"+span();
									break;
									case spc[29]: c+="\n"+span();
									break;
									case spc[2]: inparen=true;
									parendeep++;
									break;
									case spc[3]:parendeep--;
									if(parendeep === 0)
									 {
									inparen = false;
									 }
									break;
									case spc[11]: if(escaped == false && nex() == spc[18])
									 {
									mlcomment=nex();
									 }
									break;
									 }
									prettycode+=c;
									c="";
									 }
									function parseJs(c)
									 {
									switch(c)
									 {
									case quotes: if(c==spc[13] && pre() != spc[10])
									 {
									quotes = false;
									 }
									else
									 {
									quotes=nex();
									 }
									prettycode += c;
									c="";
									break;
									case dblquotes: if(c==spc[14] && pre() != spc[10])
									 {
									dblquotes = false;
									 }
									else
									 {
									dblquotes=nex();
									 }
									prettycode += c;
									c="";
									break;
									case comment: if(c == "\n")
									 {
									comment = false;
									 }
									else
									 {
									comment=nex();
									 }
									prettycode += c;
									c= "";
									break;
									case mlcomment: if(c == spc[18] && nex() == spc[11])
									 {
									mlcomment = false;
									c+=spc[11];
									i++;
									 }
									else
									 {
									mlcomment=nex();
									 }
									prettycode += c;
									c= "";
									break;
									case spc[4]: if(inparen == false || parendeep&1 == 1)
									 {
									c= N+span()+spc[4]+N;
									jsindent++;
									c+= span();
									 }
									break;
									case spc[5]: if(inparen == false || parendeep&1 == 1)
									 {
									jsindent--;
									c= N+span()+spc[5]+N+span();
									 }
									break;
									case spc[29]:if(inparen == false || parendeep&1 == 1)
									 {
									c= c+N+span();
									 }
									break;
									case "\n": c+= span();
									prettycode += c;
									c="";
									break;
									case spc[2]: inparen = true;
									parendeep++;
									if(nex() == spc[11] && pre() == "p")
									 {
									comment = true;
									 }
									prettycode += c;
									c="";
									break;
									case spc[3]: parendeep--;
									if (parendeep == 0)
									 {
									inparen = false;
									 }
									break;
									case spc[13]: if(escaped == false)
									 {
									if(dblquotes == false)
									 {
									quotes=nex();
									prettycode += c;
									c="";
									 }
									 }
									break;
									case spc[14]: if(escaped == false)
									 {
									if(quotes == false)
									 {
									dblquotes=nex();
									prettycode += c;
									c="";
									 }
									 }
									break;
									case spc[11]: if(escaped == false && nex() == spc[11])
									 {
									comment=nex();
									prettycode += c;
									c="";
									 }
									break;
									case spc[11]: if(escaped == false && nex() == spc[18])
									 {
									mlcomment=nex();
									prettycode += c;
									c="";
									 }
									break;
									 }
									prettycode+= c;
									c="";
									 }
									function parsePhp(c)
									 {
									switch(c)
									 {
									case quotes: if(c==spc[13] && pre()!= spc[10])
									 {
									quotes = false;
									 }
									else
									 {
									quotes=nex();
									 }
									prettycode += c;
									c="";
									break;
									case dblquotes: if(c==spc[14] && pre()!= spc[10])
									 {
									dblquotes = false;
									 }
									else
									 {
									dblquotes=nex();
									 }
									prettycode += c;
									c="";
									break;
									case comment: if(c == "\n")
									 {
									comment = false;
									 }
									prettycode += c;
									c= "";
									break;
									case mlcomment: if(c == spc[18] && nex() == spc[11])
									 {
									mlcomment = false;
									c+=spc[11];
									i++;
									 }
									prettycode += c;
									c= "";
									break;
									case spc[4]: c= N+span()+spc[4]+N;
									phpindent++;
									c+=span();
									break;
									case spc[5]: phpindent--;
									c= N+span()+spc[5]+N+span();
									break;
									case spc[29]:if(inparen == false && quotes == false && dblquotes == false && nex() != spc[12])
									 {
									c= c+"\n"+span();
									 }
									break;
									case "\n": c+= span();
									prettycode += c;
									c="";
									break;
									case spc[2]: inparen=true;
									parendeep++;
									prettycode += c;
									c="";
									break;
									case spc[3]: parendeep--;
									if(parendeep === 0)
									 {
									inparen = false;
									 }
									prettycode += c;
									c="";
									break;
									case spc[13]: if(escaped == false)
									 {
									if(dblquotes == false)
									 {
									quotes=nex();
									prettycode += c;
									c="";
									 }
									 }
									break;
									case spc[14]: if(escaped == false)
									 {
									if(quotes == false)
									 {
									dblquotes=nex();
									prettycode += c;
									c="";
									 }
									 }
									break;
									case spc[11]: if(escaped == false && nex() == spc[11])
									 {
									comment=true;
									prettycode += c;
									c="";
									 }
									break;
									case spc[11]: if(escaped == false && nex() == spc[18])
									 {
									mlcomment=true;
									prettycode += c;
									c="";
									 }
									break;
									 }
									prettycode+= c;
									c="";
									 }
									function seperate(str)
									 {
									if(str=="\n")
									 {
									str += span();
									prettycode+= str;
									str="";
									 }
									if(SAVED == spc[1])
									 {
									if(str == spc[1])
									 {
									SAVED=false;
									 }
									prettycode+= str;
									str="";
									 }
									if(lang() != Tmp )
									 {
									Tmp = lang();
									 }
									switch(lang())
									 {
									case "HTML": parseHtml(str);
									 //prettycode+=lang();
									break;
									case "PHP": parsePhp(str);
									 //prettycode+=lang();
									break;
									case "CSS": parseCss(str);
									 //prettycode+=lang();
									break;
									case "JS": parseJs(str);
									 //prettycode+=lang();
									break;
									 }
									 }
									const code = editor.value;
									const lines = code.split("\n");
									lines.forEach(function(element)
									 {
									line= element;
									line = line.replace(/[^\S\n]{1,}/g," ");
									if(/\s/.test(line[0]))
									 {
									line=line.replace(/^\s{1,}\b/,"");
									 }
									if(/\S/.test(line))
									 {
									line+="\n";
									 }
									for(i = 0; i<line.length; i++)
									 {
									pre = function()
									 {
									return line[i-1];
									 }
									cur = function()
									 {
									return line[i];
									 }
									nex = function()
									 {
									return line[i+1];
									 }
									if(pre() == "\n")
									 {
									N = ""
									 }
									else
									 {
									N = "\n";
									 }
									if(escaped == true)
									 {
									escaped = false;
									seperate(cur());
									continue;
									 }
									if(cur() == spc[10])
									 {
									escaped = true;
									seperate(cur());
									continue;
									 }
									if(comment == true || mlcomment == true || quotes== true|| dblquotes == true || SAVED == spc[1])
									 {
									seperate(cur());
									 }
									else
									 {
									switch(cur())
									 {
									case spc[0]:
									if(next(1) == spc[12])
									 {
									language.push("PHP");
									i+=2;
									prettycode += spc[0]+"?";
									 }
									if(next(5) == "STYLE" && lang() != "PHP")
									 {
									language.push("CSS");
									prettycode+= spc[0]+"STYLE";
									i+=6;
									SAVED = spc[1];
									 }
									if(next(6) == "/STYLE" && lang() != "PHP")
									 {
									language.pop();
									prettycode+= spc[0]+"/STYLE";
									i+=7;
									SAVED = spc[1];
									 }
									if(next(6) == "SCRIPT" && lang() != "PHP")
									 {
									language.push("JS");
									prettycode+= spc[0]+"SCRIPT ";
									i+=7;
									SAVED = spc[1];
									 }
									if(next(7) == "/SCRIPT" && lang() != "PHP")
									 {
									language.pop();
									prettycode+= spc[0]+"/SCRIPT";
									i+=8;
									SAVED = spc[1];
									 }
									case spc[12]: if(next(1) == spc[1])
									 {
									language.pop();
									prettycode += spc[12]+spc[1];
									i+=2;
									 }
									break;
									 }
									seperate(cur());
									 }
									 }
									 });
									prettycode = prettycode.replace(/\n\s*\n/ig,"\n");
									prettycode = prettycode.replace(/\}\s*\)/ig,"})");
									prettycode = prettycode.replace(/\n;/ig,";");
									prettycode = prettycode.replace(/;\s*\n\s*\?/gm,"; ?");
									prettycode = prettycode.replace(/\}\s*\,\s*\{}/m,"; ?");
									editor.value = prettycode;
									}
									</SCRIPT>
								</body>
							</html>
							 