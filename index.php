<?php require('head.php'); ?>
	<!DOCTYPE html>
		<html lang="en-US">
			<head>
			<meta name = "viewport" content = "width=device-width, initial-scale=1.0">
			<?=$favicon; ?>
				<title>My Editor
			</title>
			 <SCRIPT  type="text/javascript" src="boilerplate.js?version=<?=rand(1000,9999); ?>"></SCRIPT>
			<link rel="stylesheet" href="myStylesheet.css?version=<?=rand(1000,9999); ?>" type="text/css">
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
						<label for="wordwrap">Wwrap </label>
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
									<caption id="captiontext" style="color:white">Alert: You are signed in</caption>
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
															<button onclick='codemode();'>code mode </button>
													</th>
														<th>
															<button id ='frboxbutton' onclick="frbox.classList.toggle('hidden'); frbox.classList.contains('hidden')?this.innerHTML ='Find Replace':this.innerHTML = 'FR OFF';" > Find Replace </button>
													</th>
														<th>
															<button onclick="gettokens()">get tokens </button>
													</th>
														<th>
													<button onclick="filehandle('openfile',myServer.document_root+'/boilerplate.js');if(!sidebar.classList.contains('filesystem')){$('filesystembutton').click();}setTimeout(function(){ if(nod($('boilerplate.js'))){ Nod.classList.add('selected'); } },3000); ">Boiler
													</button>
												</th>
											</tr>
												<tr>
													<th>
													<button onclick="navigator.clipboard.writeText(editor.value);toast('Copied To Clipboard',omnibox.vale)">Copy <wbr>Text</button>
							
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
														<button onclick="editor.value=editor.value.replace(/\s{1,}/ig,' ')">Minify</button>
												</th>
													<th>
														<button onclick="filehandle('openfile',myServer.document_root+'/myStylesheet.css');if(!sidebar.classList.contains('filesystem')){$('filesystembutton').click();}setTimeout(function(){ if(nod($('myStylesheet.css'))){ Nod.classList.add('selected'); } },3000); ">Style</button> 
			
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
														<button style="" onclick="codepoints()">cpoint</button>
												</th>
													<th>
							<button onclick="filehandle('openfile',myServer.document_root+'/head.php');if(!sidebar.classList.contains('filesystem')){$('filesystembutton').click();}setTimeout(function(){ if(nod($('head.php'))){ Nod.classList.add('selected'); } },3000); ">head</button>	
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
								<input id="openfilename" autocomplete="off" spellcheck="false" type="text" onfocus="this.value=this.value.replace(myServer.document_root+'/','')" oninput="omnibox.value =path2url(this.value);"  onblur="this.value=myServer.document_root='/'+this.value.replace(myServer.document_root,""); $('omnibox').value =path2url(this.value);" placeholder="/home3/johnnzh5/public_html/"> 
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
													<label for="caseinsensitive">i</label>
														<input type=checkbox id="caseinsensitive" value="i">
															<label for="up">up</label>
																<input type=checkbox id='up' value="up">
																	<label for="regex">RegExp</label>
																		<input type=checkbox id='regex' value="regex">
																	</td>
																</tr>
															</tbody>
														</table> 
													</div>
													 <SCRIPT ?> const myServer = <?=json_encode($Server); ?>;
													SAVED = `<?php print_r($Server); ?>`;
													 </SCRIPT> 
													 <SCRIPT  type="text/javascript" src="myScript.js?version=<?=rand(1000,9999); ?>"></SCRIPT>
													 <SCRIPT  src="prettycode.js" ></SCRIPT>
												</body>
											</html>
											 