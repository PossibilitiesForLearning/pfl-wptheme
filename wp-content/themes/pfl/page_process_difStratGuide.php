<?php /* Template name: Processing  Page*/ ?>
<?php
/**
 * The template for display the processing page for the upload of saved pfl data
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>


<?php 
	include_once('./wp.custom.src/pfl.php');
?>
<link rel="stylesheet" href="./wp.custom.css/pfl.css" type="text/css">

<script type="text/javascript" src="./wp.custom.src/cmn.fxns.js"></script>

<div id="processPage" style="padding:15px;">

 <div id="divProcessing" style="text-align:center;display:block;">
  <img src="./wp.images/page.diffStratGuide/processing.gif" /> 
 </div>
 <div id="divProcessingError" style="display:none;">
The file you attempted to upload is either too large(must be less than 0.5Mb), does not have the correct file extension(.pfl or .txt), or is of the incorrect format.
<br><br>

<table>
<?php
if(isset($_GET['loadsurvey']))
{
echo '<tr><td><a href="http://possibilitiesforlearning.com/?page_id=1359">Select Another File</a></td><tr>';
echo '<tr><td><a href="./?page_id=1337">Return To PFL Survey</a></td></tr>';
}
else
{
echo '<tr><td><a href="http://possibilitiesforlearning.com/?page_id=1279">Select Another File</a></td><tr>';
echo '<tr><td><a href="./?page_id=191">Return To Learning Strategies Guide</a></td></tr>';
}
?>
</table>
<br><br>
 
</div>

<!--form action='./?page_id=191' method='post' name='frm' id='frm'-->
<?php 
if(isset($_GET['loadsurvey']))
{
 //echo "<form action='./?page_id=421' method='post' name='frm' id='frm'>";
 echo "<form action='./?page_id=1337' method='post' name='frm' id='frm'>";
// echo 'pflSurvey';
 loadPFLSurveyFromFile();
}
else
{
 echo "<form action='./?page_id=191' method='post' name='frm' id='frm'>";
 loadPFLDiffGuideFromFile();
}
 ?>
</form>
<script language="JavaScript">
  document.frm.submit();
</script>



</div> 

<!-- END OF HTML PAGE -->
<?php
function validateLoadedFile($tmpFilePrefix)
{
  // Configuration - Your Options
 $allowed_filetypes = array('.pfl','.txt','.pfl.txt'); 
 $max_filesize = 5000; // Maximum filesize in BYTES.
 $tmpfpath="./ext.save/tmp/".uniqid($tmpFilePrefix).".pfl";

 // Working with file
 $filename = $_FILES['userfile']['name'];
 $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);
 //echo ":here i am!!: ".$filename." !!ext:".$ext."_size:".filesize($_FILES['userfile']['tmp_name']);

 if((!in_array($ext,$allowed_filetypes))||(filesize($_FILES['userfile']['tmp_name']) > $max_filesize))
 {
  //echo 'here';
   die('<script>toogleDiv("divProcessing");toogleDiv("divProcessingError");</script>');
 }
 return $tmpfpath;
}

function returnFileContents($origFile,$tmpFile)
{
  //copy
 $check=move_uploaded_file($origFile,$tmpFile);
 //echo 'check Move:'.$check.'-'.$origFile.'-'.$tmpFile; 
 //get file contents & delete
 $fileContent=file($tmpFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
 unlink($tmpFile);
 //print_r($fileContent);
 return $fileContent;
}

function validateDiffGuideFileContent($fileContent)
{
 //echo 'here';
 //validate content
 $foundStart=false;
 $foundEnd=false;
 $startLine=-1;
 $endLine=-1;
 foreach ($fileContent as $line_num => $line) 
 {           			
  $workline=rtrim($line);
  //echo $line_num.":".$workline."<br>";
  if($foundStart)
  {
   if($workline=="[pflDG_end]")
   {	
    $foundEnd=true;
    $endLine=$line_num;  
   }    						  
  }
  else //look for starting line
  {
   if($workline=="[pflDG_start]")
   {	
    $foundStart=true;
    $startLine=$line_num;  
   }
  }
 }
 if(!($foundStart&$foundEnd&($endLine-$startLine)==3))
 {
  //echo "debug:".$endLine.",".$startLine."<br>";
 die('<script>toogleDiv("divProcessing");toogleDiv("divProcessingError");</script>');
 }
 return array($startLine+1,$startLine+2);
}

function writeSavePFLFile($contentAry,$filePrefix)
{ 
    //write safe file
    $safefname="./ext.save/tmp/".uniqid($filePrefix);
    $handle = fopen($safefname, "w");
    foreach($contentAry as $curContent){fwrite($handle,  $curContent."\n");}
    fclose($handle);    
    return $safefname;
}

function loadPFLDiffGuideFromFile()
{
 $tmpfpath=validateLoadedFile('dgul_');
 $fileContent=returnFileContents($_FILES['userfile']['tmp_name'],$tmpfpath);
 $startEndLineAry=validateDiffGuideFileContent($fileContent);
 
 $validSelectionsContent=htmlspecialchars(rtrim($fileContent[$startEndLineAry[0]]));
 $validDemogContent=htmlspecialchars(rtrim($fileContent[$startEndLineAry[1]]));
 
 $contentAry=array($validSelectionsContent,$validDemogContent);

 $safefname=writeSavePFLFile($contentAry,'safeDG_');
 //echo 'upload was successful:'.$handle.':'.$safefname;
 echo '<input type="hidden" id="loadedDGFile" name="loadedDGFile" value="'.$safefname.'">';
}

function generatePostInput($fileContent)
{
 //print_r($fileContent);
 foreach($fileContent as $curHiddenInput)
 {
  $strAry=explode('{',$curHiddenInput);
  //print_r($strAry);
  //echo '<br>';
  if(sizeof($strAry)>0)
  {
    $name="";
    $info="";

    $nameAry=explode('}',$strAry[1]);
    if(sizeof($nameAry)>0){$name=$nameAry[0];}

    $infoAry=explode('}',$strAry[2]);
    if(sizeof($infoAry)>0){$info=$infoAry[0];}

    //echo $name.":".$info."<br>";
    echo '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$info.'">';
  }
 }
}

function loadPFLSurveyFromFile()
{
 $tmpfpath=validateLoadedFile('surul_');
 //echo 'here';
 $fileContent=returnFileContents($_FILES['userfile']['tmp_name'],$tmpfpath);
 generatePostInput($fileContent);
}

?>



