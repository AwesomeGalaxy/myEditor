"use strict"
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
		if(mytypeof(myFrame) == 'Null'){
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
	if(toolbar.classList.contains('show')){ return; }
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
	if (elem.parentElement.tagName == "BODY"){
	let parentid = elem.dataset.parentid;
	$(parentid).appendChild(elem);
	}else{ elem.removeAttribute('style'); document.body.appendChild(elem); }
}
function parseresult(resultss)
{
	let result = resultss.split(/\n/);
	let rtext; let filename; let fname; let full;
	let firstline = result.shift();
	if(/-/.test(firstline))
	{
		let docinfo = mysplit(firstline, "-"); 
		rtext = mysplit(docinfo[0], ":").concat(mysplit(docinfo[1], ":")); 
	}else{
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
	if(el.selectionStart){
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
	}else{ toast('no selection'); }
}
function mytime(){
let date = new Date();
captiontext.innerHTML =  date.toString().replace("Pacific Standard Time","PST");
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
			},{
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
	if(y == "true"){
 	$openfilename.placeholder = path;
	$openfilename.value = path;
	$('omnibox').value = path2url(path);
	 }else{ alert("There was a problem", y); }
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
					
					selectedText = selectedText.replace(/(\b\w)/gi,function($1){ let C = '$1'; return C.toUpperCase(); });
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

async function keepalive() {
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
