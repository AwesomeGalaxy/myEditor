function prettyprint(lg)
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