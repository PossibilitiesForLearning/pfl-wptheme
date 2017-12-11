<?php
//common and repeated functions required for each portion of the pfl survey

//////////////////////////////////////////////////////////////////
//get the current survey part
function setCurPart()
{
 $curPart="0";

 if(isset($_GET['part'])){$curPart=$_GET['part'];}
 else
 {
   if(isset($_POST['prevPart'])){if($_POST['selAct']=='back'){$curPart=$_POST['prevPart'];} }
   if(isset($_POST['nextPart'])){if($_POST['selAct']=='next'){$curPart=$_POST['nextPart'];} }
 }

 if (intval($curPart)<0){$curPart=0;}
 return $curPart;
}


//////////////////////////////////////////////////////////////////
//get information from a delimitted line
function getInfo($firstDelim,$secondDelim,$origString)
{
 try
 {
  $initpos=strpos($origString, $firstDelim)+strlen($firstDelim);
  $finpos=strpos($origString, $secondDelim,$initpos);
  return substr($origString, $initpos, $finpos-$initpos);
 }
 catch(Exception $e){return "";}
}


//////////////////////////////////////////////////////////////////
//search a 2d array and return a value based on a search criteria
function getValFromArray($searchVal, $ary)
{
  for($i=0;$i<sizeof($ary);$i++)
  {
   if($ary[$i][0]==$searchVal){return $ary[$i][1];}
  }
  return '';
}


//////////////////////////////////////////////////////////////////
//generate the navigation buttons
function buildNavButtons($stageStart,$stageEnd)
{
 $curPart=setCurPart();

 echo ' <table id="pflSurveyNavTbl" ><tr>';
 if($curPart!=$stageStart){echo '<td id="pflSurveyNavLeft" >'.generateNavButton('back',$curPart).'</td>';}
 if($curPart!=$stageEnd){echo '<td id="pflSurveyNavRight" >'.generateNavButton('next',$curPart).'</td>';}
 echo '</tr></table>';
}


function generateNavButton($direction,$curPart)
{
  $buStr='<button type="button" style="border: 0; background: transparent" onclick="pflNav('.$curPart.',\''.$direction.'\');">';
  $buStr=$buStr.'  <img src="/wp.images/icons/'.$direction.'.png" width="20" alt="'.$direction.'" /><br>'.$direction;
  $buStr=$buStr.'</button>';
  return $buStr;
}


//////////////////////////////////////////////////////////////////
//get the instructions page for each part
function buildSurveyInstructions($instructionsURL)
{
 $curPart=setCurPart();
 $curInstr=""; 
 if($curPart!="0")
 {
   $partInst=explode("\n", loadUrl_get_contents($instructionsURL));//instructions page
   $inPart=0; 
   foreach( $partInst as $curLine )
   {
     $line=str_replace(array("\r\n", "\r", "\n", "\n\r"), "", $curLine);
     if(strlen($line)>0)
     { 
      if((substr_count($line,"[INSTRUCTIONS:PART")>0)&&($inPart==0))
      {
       $partNum=getInfo("[INSTRUCTIONS:PART","]",$line);
       if($partNum==$curPart){$inPart=1;}
      }
      elseif((substr_count($line,"[INSTRUCTIONSEND]")>0)&&($inPart==1)){ return $curInstr;}
      else
      {
        if($inPart==1){$curInstr=$curInstr.' '.$line;} 
      }
     }
    }  
  }
  return $curInstr;
}

function buildSurveyInstructionsForPrint($instructionsURL,$surveyPart)
{
 //echo "here";
 $curInstr=""; 
 if($curPart!="0")
 {
   $partInst=explode("\n", loadUrl_get_contents($instructionsURL));//instructions page
   $inPart=0; 
   foreach( $partInst as $curLine )
   {
     $line=str_replace(array("\r\n", "\r", "\n", "\n\r"), "", $curLine);
     if(strlen($line)>0)
     { 
      if((substr_count($line,"[INSTRUCTIONS:PART")>0)&&($inPart==0))
      {
       $partNum=getInfo("[INSTRUCTIONS:PART","]",$line);
       if($partNum==$surveyPart){$inPart=1;}
      }
      elseif((substr_count($line,"[INSTRUCTIONSEND]")>0)&&($inPart==1)){ return $curInstr;}
      else
      {
        if($inPart==1){$curInstr=$curInstr.' '.$line;} 
      }
     }
    }  
  }
  return $curInstr;
}

//////////////////////////////////////////////////////////////////
//build and fill if already posted hiddedn fields with collected data
function buildHiddenSaveElements()
{
 //parts 1 to 4
 for ($i = 1; $i <= 4; $i++) 
 {
   $dataVal="";
   $stratVal="";
   $likesDislikesVal="";
   if(isset($_POST['part'.$i.'SavedData'])){$dataVal=$_POST['part'.$i.'SavedData'];}
   if(isset($_POST['part'.$i.'StratCodes'])){$stratVal=$_POST['part'.$i.'StratCodes'];} 
  if(isset($_POST['pflSurveyLikesDislikesPart'.$i])){$likesDislikesVal=$_POST['pflSurveyLikesDislikesPart'.$i];} 

 // Survey Likes and Dislikes
   echo '<input type="hidden" id="part'.$i.'SavedData" name="part'.$i.'SavedData" value="'.$dataVal.'"/>';
   echo '<input type="hidden" id="part'.$i.'StratCodes" name="part'.$i.'StratCodes" value="'.$stratVal.'"/>';
   echo '<input type="hidden" id="pflSurveyLikesDislikesPart'.$i.'" name="pflSurveyLikesDislikesPart'.$i.'" value="'.$likesDislikesVal.'"/>';
 }

 //part 0 - intro
 if(isset($_POST['part0SavedData'])){$dataVal=$_POST['part0SavedData'];}
 else{$dataVal="";}
 echo '<input type="hidden" id="part0SavedData" name="part0SavedData" value="'.$dataVal.'"/>';

 //part 5 - topics
 if(isset($_POST['part5SavedData'])){$dataVal=$_POST['part5SavedData'];}
 else{$dataVal="";}
 echo '<input type="hidden" id="part5SavedData" name="part5SavedData" value="'.$dataVal.'"/>';



 //part 7 - summary page
 if(isset($_POST['summarySavedData'])){$dataVal=$_POST['summarySavedData'];}
 else{$dataVal="";}
 echo '<input type="hidden" id="summarySavedData" name="summarySavedData" value="'.$dataVal.'"/>';


 //part 8 - dream page
 if(isset($_POST['dreamSavedData'])){$dataVal=$_POST['dreamSavedData'];}
 else{$dataVal="";}
 echo '<input type="hidden" id="dreamSavedData" name="dreamSavedData" value="'.$dataVal.'"/>';

//completed sections
 for($progIndex=0;$progIndex<6;$progIndex++)
 {
  $curId='p'.$progIndex.'stat';
  if(isset($_POST[$curId])){$dataVal=$_POST[$curId];}
  else{$dataVal="0";}
  echo '<input type="hidden" id="'.$curId.'" name="'.$curId.'" value="'.$dataVal.'"/>';
 }
  if(isset($_POST['lastViewedPart'])){$dataVal=$_POST['lastViewedPart'];}
  else{$dataVal="";}
  echo '<input type="hidden" id="lastViewedPart" name="lastViewedPart" value="'.$dataVal.'"/>';

}
?>
