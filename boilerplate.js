"use strict"
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
.then(text => {
    myclipboard.push(text);
  })
  .catch(err => {
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
		
	
		$('poster').innerHTML += "	"+cp+":"+String.fromCharCode(cp)+"	";		

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
	ease = setInterval(function(el,step,end){
	el.scrollTop += step;
	if(end - el.scrollTop <2){ clearInterval(ease); }
	 }, 300);
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
	if(re.test(selec)){
	let selstart = editor.selectionStart;
	let selend = editor.selectionEnd;
	let stext = editor.value;
	if(selend === stext.length){ return; }
	let starttxt = stext.substring(0, selstart);
	let endtxt = stext.substring(selend, stext.length);
	let rep = $('replacementbar').value;
	selec = selec.replace(re, rep);
	editor.value = starttxt + selec + endtxt;
	selend = parseInt(selstart + selec.length);
	editor.selectionStart = selstart;
	editor.selectionEnd = selend;
	}else{ searcher(); }
}

function searcher()
{
	editor.focus(
	{
		preventScroll: true
	});
	let selstart = function(){ return editor.selectionStart; }
    let selend = function(){ return editor.selectionEnd; }
    let stext = function(){ return editor.value; }
	if(selend() === stext().length)
	{
		editor.selectionStart = editor.selectionEnd = 0;
	}
	let pat = $('findbar').value;
	let re;
	if($('caseinsensitive').checked && $('regex').checked) {re = new RegExp(pat,"ig"); }
	if($('caseinsensitive').checked && !$('regex').checked) {pat = pat.replaceAll(/([\\\/\?\(\)\<\>\+\.\"\'\:\[\}\{\]\"\'\$\^\&\*])/g,"\\$1");  re= new RegExp(pat,"ig");  }
	if(!$('caseinsensitive').checked && $('regex').checked) {re = new RegExp(pat,"g"); }
	if(!$('caseinsensitive').checked && !$('regex').checked) {pat = pat.replaceAll(/([\\\/\?\(\)\<\>\+\.\"\'\:\[\}\{\]\"\'\$\^\&\*])/g,"\\$1"); re=pat; }

		let maches = function(){ return stext().matchAll(re); }
		let mach = function() { return Array.from(maches()); }
		if(mach().length > 0){
		for(let i = 0; i <= mach().length; i++)
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

line = line.replace(/\t/ig,"    ");
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