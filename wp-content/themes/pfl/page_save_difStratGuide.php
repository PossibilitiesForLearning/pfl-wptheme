<?php /* Template name: Save Page*/ ?>
<?php
/**
 * The template for displaying the save page for the download of pfl data
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

<style>
</style>

<div id="savePage" style="position:relative;top:-50px;">
 <?php
 //echo 'here';
  $dlsInfoRaw=loadUrl_get_contents("./wp.static/pfl.survey.saveInstructions.txt");
  echo $dlsInfoRaw;
 ?>

 <div style="text-align:center;font-size:16px;font-weight:bold;">
<?php
  //echo 'here'; 
 //var_dump($_GET);
 $savedFileLink="";
 if(isset($_POST['pflSurveyPage'])){$savedFileLink=saveSurveyToFile();}
 else{$savedFileLink=saveDiffGuideToFile();}

 echo '<a href="'.$savedFileLink.'" target="_blank"><b>Download</b></a>';
 echo '<div id="delDate" style="display:none;">'.date("d-m-Y H:i:s", time()+3600).'</div>'; 
// echo '<input type="hidden" id="pflFileToDel" name="pflFileToDel" value="'.$tmpfname.'">';

 ?>
 </div>
</div>

<script>
 document.getElementById("delDateSpan1").innerHTML=document.getElementById("delDate").innerHTML;
 document.getElementById("delDateSpan2").innerHTML=document.getElementById("delDate").innerHTML;
</script>

<!-- END OF HTML PAGE -->
<?php
 function saveDiffGuideToFile()
 {
  $selDiffValues=$_POST["saveSelBehav"];
  $curDemogs=$_POST["saveDemog"];
 
  $tmpfname="./ext.save/tmp/".uniqid('diffGuide_').".pfl";

  $handle = fopen($tmpfname, "w");
  //echo $handle;
  fwrite($handle,"[pflDG_start]\n");
  fwrite($handle,  $selDiffValues);
  fwrite($handle,  "\n".$curDemogs);
  fwrite($handle,"\n[pflDG_end]");
  fclose($handle);
 // echo 'diff guide:'.$tmpfname;
  return $tmpfname;
 }

 function saveSurveyToFile()
 {
  $saveInfo='';
 
//parts 1 to 4
 for ($i = 1; $i <= 4; $i++) 
 {
   if(isset($_POST['part'.$i.'SavedData']))
   {
     $saveInfo=$saveInfo."\n".'{part'.$i.'SavedData}{'.$_POST['part'.$i.'SavedData'].'}';
   }
   if(isset($_POST['part'.$i.'StratCodes']))
   {
     $saveInfo=$saveInfo."\n".'{part'.$i.'StratCodes}{'.$_POST['part'.$i.'StratCodes'].'}';
   } 
   if(isset($_POST['pflSurveyLikesDislikesPart'.$i]))
   {
     $saveInfo=$saveInfo."\n".'{pflSurveyLikesDislikesPart'.$i.'}{'.$_POST['pflSurveyLikesDislikesPart'.$i].'}';
   } 
 }

 //part 0 - intro
 if(isset($_POST['part0SavedData']))
 {
  $saveInfo=$saveInfo."\n".'{part0SavedData}{'.$_POST['part0SavedData'].'}';
 }

 //part 5 - topics
 if(isset($_POST['part5SavedData']))
 {
  $saveInfo=$saveInfo."\n".'{part5SavedData}{'.$_POST['part5SavedData'].'}';
 }
 
 //part 7 - summary page selections
 if(isset($_POST['summarySavedData']))
 {
  $saveInfo=$saveInfo."\n".'{summarySavedData}{'.$_POST['summarySavedData'].'}';
 }
 
 //part 8 - dream page selections
 if(isset($_POST['dreamSavedData']))
 {
  $saveInfo=$saveInfo."\n".'{dreamSavedData}{'.$_POST['dreamSavedData'].'}';
 }


//survey progress information
 for($progIndex=0;$progIndex<6;$progIndex++)
 {
  $curId='p'.$progIndex.'stat';
  if(isset($_POST[$curId])){$saveInfo=$saveInfo."\n".'{'.$curId.'}{'.$_POST[$curId].'}';}
 }
 if(isset($_POST['lastViewedPart']))
 {
  $saveInfo=$saveInfo."\n".'{lastViewedPart}{'.$_POST['lastViewedPart'].'}';
 }


 $tmpfname="./ext.save/tmp/".uniqid('pflSurvey_').".pfl";

 $handle = fopen($tmpfname, "w");
 //echo $handle;
 fwrite($handle,"[pflSurvey_start]\n");
 fwrite($handle,  $saveInfo);
 fwrite($handle,"\n[pflSurvey_end]");
 fclose($handle);

// echo 'survey:'.$tmpfname;
  return $tmpfname;
 }

?>



