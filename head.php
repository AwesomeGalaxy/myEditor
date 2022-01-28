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
	exit();	 die();
}
if (isset($_GET['loggedincheck']) || isset($_GET['isdir'])) 
{
	ob_flush();
	if($_SESSION['USERNAME'] == "WEBMASTER" && $_SESSION['PASSWORD'] == "ADMIN6626" && $_SESSION['LOGGED_IN'] == 1)
	{
		if(isset($_GET['isdir'])){ if(is_dir(urldecode($_GET['isdir']))){ echo 'true'; exit(); die(); }else{echo "false ".$_GET['isdir']." is not a folder"; exit(); die(); } }
		echo 'true'; session_regenerate_id(); $_SESSION['COUNT']>=0?$_SESSION['COUNT']=$_SESSION['COUNT']+1:$_SESSION['COUNT']=0;
		echo ",".$_SESSION['COUNT'];
	}
	else
	{
		echo 'false';
		echo "USERNAME: ".$_SESSION['USERNAME']." PASSWORD: ".$_SESSION['PASSWORD']." LOGGED_IN: ".$_SESSION['LOGGED_IN'];
	}
	exit();	 die();
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
{ob_flush();
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

if (!isset($_SESSION['LOGGED_IN']) OR $_SESSION['LOGGED_IN'] != true){ 	exit();	 die();  }
function rrmdir($src)
{
	ob_flush();
   rmdir($src);
}
function mkfolder($thisfolder)
{ob_flush();
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
		
	ob_flush();	exit();
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
	 );

?>