<?php
//functions for the summary page of the pfl survey

//////////////////////////////////////////////////////////////////
//generate survey summary html
function buildoutSummary($questionsURL)
{
  $qAry= explode("\n", loadUrl_get_contents($questionsURL));//questions page url and array

 echo '<span style="color:red;font-size:13pt;">Possibilities for Learning Summary Sheet</span><br>';
 echo '<div id="rootSummaryDiv">';

 echo '  <div id="summaryInfoDiv">';//MY info part
 $introInfoAry=buildIntroInfoArray();
//print_r($introInfoAry);
 echo  '   <table>';
 echo  '    <tr><td width="350px"><b>Name:</b> '.getValFromArray('pflName', $introInfoAry).'</td><td width="350px"><b>Date:</b> '.getValFromArray('pflDate', $introInfoAry).'</td></tr>';   
 echo  '    <tr><td colspan="2" ><b>Favorite school subject:</b> '.getValFromArray('fullFavString', $introInfoAry).'</td></tr>';   
 echo  '   </table>';
 echo '  </div>';

 for($pIndex=1;$pIndex<=4;$pIndex++)//likes - survey parts 1 to 4
 {
  echo '<br>'; 
  echo '  <div id="summaryInfoLikesDiv">';
  echo '    Two <span style="font-weight:bold;">MOST FAVORITE</span> statements from the items in part '.$pIndex.'<br><br>';
  $likesDisloikesAry=getLikeStatements($pIndex,$qAry);
  $likesAry=$likesDisloikesAry[0];
  echo '<ul><li>'.$likesAry[0].'</li>';  
  echo '<li>'.$likesAry[1].'</li></ul>';  
  echo '   </div>';
 }


 echo '<br>';
 $listsArray=getTopicOptionsArray(); //topics drop downs
 //print_r($listsArray);
 //echo '---<br>***'; 

  $selectedArray=parseSavedSummaryInput();
   //print_r($selectedArray);
  
  for($topicIndex=0;$topicIndex<3;$topicIndex++)
  {
   //$topicSelStr="";
   $curTopicList=$listsArray[$topicIndex];
   //print_r($curTopicList);
   echo '<div id="summaryInfoTopicsDiv">';
   echo $curTopicList[1].'<br>';

   $selTopic01="";
   $selTopic02="";

   $topicDDL01='<select id="'.$curTopicList[0].'_1" onchange="saveSelections(7)">';
   $topicDDL02='<select id="'.$curTopicList[0].'_2" onchange="saveSelections(7)">';

   $curTopicToCheck=array();
   foreach($selectedArray as $curSelTopicInfo)
   {
     if($curSelTopicInfo[0]==$curTopicList[0])
     {
       $topicsSelAry=$curSelTopicInfo[1];
       $selTopic01=$topicsSelAry[0];
       $selTopic02=$topicsSelAry[1];
       //print_r($selectedArray);
       //echo '<br>'; 
       //print_r($topicsSelAry);
     }
   }
   //print_r($topicsSelAry);
   for($tIndex=2;$tIndex<sizeof($curTopicList);$tIndex++)
   {
    $selected01="";
    $selected02="";

    if($curTopicList[$tIndex]==$selTopic01){$selected01='selected="yes"';}
    if($curTopicList[$tIndex]==$selTopic02){$selected02='selected="yes"';}

    $topicDDL01=$topicDDL01.'<option value="'.$curTopicList[$tIndex].'" '.$selected01.'>'.$curTopicList[$tIndex].'</option>';
    $topicDDL02=$topicDDL02.'<option value="'.$curTopicList[$tIndex].'" '.$selected02.'>'.$curTopicList[$tIndex].'</option>';
   }


   $topicDDL01=$topicDDL01.'</select>';  
   $topicDDL02=$topicDDL02.'</select>';  

 
   echo '<table><tr>';
   echo '<td>'.$topicDDL01.'</td>';
   echo '<td>'.$topicDDL02.'</td>';
   echo '</tr></table>';
   echo '</div><br>';
  }



  for($pIndex=1;$pIndex<=4;$pIndex++)//dislikes - survey parts 1 to 4
 {
  echo '<br>'; 
  echo '  <div id="summaryInfoDislikesDiv">';
  echo '    Two <span style="font-weight:bold;">LEAST FAVORITE</span> statements from the items in part '.$pIndex.'<br><br>';
  $likesDisloikesAry=getLikeStatements($pIndex,$qAry);
  $dislikesAry=$likesDisloikesAry[1];
  echo '<ul><li>'.$dislikesAry[0].'</li>';  
  echo '<li>'.$dislikesAry[1].'</li></ul>';  
  echo '   </div>';
 }



 echo '<br><br></div">';
}

function parseSavedSummaryInput()
{
 $savedArray=array();
 if(isset($_POST['summarySavedData']))
 {
  $infoLineAry=explode(";",$_POST['summarySavedData']);
  //print_r($infoLineAry);
  //echo '<br>';
  for($sIndex=1;$sIndex<count($infoLineAry);$sIndex++)
  {
    $curTopicArray=explode(":",$infoLineAry[$sIndex]);
    //print_r($curTopicArray);
    //echo '<br>';    
    $curSelTopic=array();
    $curSelTopic[]=$curTopicArray[0];
    $curSelTopic[]=explode(",",$curTopicArray[1]);

    $savedArray[]=$curSelTopic;
    //infoLineAry=explode(";",$_POST['summarySavedData']);
  }
 }
 //print_r($savedArray);   
 return $savedArray;
}



?>
