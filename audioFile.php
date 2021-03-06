<?php
/**
* @file
*
* All Callblaster code is released under the GNU General Public License.
* See COPYRIGHT.txt and LICENSE.txt.
*
*....................
* www.nethram.com
*/
require_once('config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


function displayAudio()
{
	global $basepath;
	 exec("ls -t audio/",$files);
	 echo("<table>");
  	foreach($files as $file)
  	{		
    		//$size     = filesize($basepath."/files/$file")/1024;
      		//$filedate = date ("m/d/Y H:i:s", filemtime($basepath."/files/$file"));
        	$link="audio/$file";
      		echo "<tr><td>$file</td> <td> <a target='_blank' href='$link'>Download</a> </td> <td>
      		
      		<form method='post' action='demoCall.php'>
      		
      		<input type='hidden' name='file' value='$file' />
      		<input type='submit' name='action' value='Get Demo Call' />
      		
      		</form>
      		
      		 </td> ";
    	}
  
  	echo("</table>");


}

if(isset($_POST['action'])):
if($_POST['action']=="Upload Audio")
{

	if(isset($_FILES['audioFile']))
	{
	
		$tmpDest = $basepath."tmp/".str_replace(' ', '',$_FILES['audioFile']['name']);
		$exten = pathinfo($_FILES['audioFile']['name']);
		$exten = '.'.$exten['extension'];
		
		$fileName=str_replace(' ', '',basename($_FILES['audioFile']['name'], $exten));
		
		$dest = $basepath."/audio/$fileName.wav";
		move_uploaded_file($_FILES['audioFile']['tmp_name'],$tmpDest);
		
		$out=shell_exec('asterisk -rx "file convert '. $tmpDest.' '.$dest.'"');
		var_dump($out);
		echo "<script type='text/javascript'>alert('Audio Added Successfully');</script>";
	
	}

}
endif;

?>
<html>

<body>
<center>
<h2>Audio File Management</h2>

<h4>Note : welcome.mp3 is the default audio file. In the csv file you only need to specify the file name(Eg: 'welcome' for 'welcome.mp3')</h4>

<h4><a href="index.php">Back to Home</a></h4></center>

<div style="borser-style:double"></div>

<h3>Upload Audio</h3>

<form method="post" action="audioFile.php" enctype="multipart/form-data">
Audio File : <input type="file" name="audioFile" />
<input type="submit" name="action" value="Upload Audio" />

</form>

<div style="borser-style:double"></div>


<?php displayAudio(); ?>


</body>



</html>
