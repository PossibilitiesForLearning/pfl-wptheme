<?php
//functions required to generate the dream sheet

//////////////////////////////////////////////////////////////////
//build out the dreamsheet
function buildoutDreamSheet($questionsURL, $imageRoot)
{

 $dreamSheetArray=parseSavedDreamInput();

 //print_r($dreamSheetArray); 
//
 echo '<span style="color:red;font-size:13pt;">Possibilities for Learning Dream Sheet</span><br>';
 echo '<div id="rootDreamDiv" width="1000"  style="height:1000px" bgcolor="white">';

$qAry= explode("\n", loadUrl_get_contents($questionsURL));//questions page url and array

//<!-- setting for learning: part 1 of survey-->
 echo ' <div style="position:absolute;left:0px;top:350px; ">';
 echo '	<img src="'.$imageRoot.'/page.pflSurvey/cloud.left.top.png" width="300px"/>';
 echo ' </div>';
 echo ' <div style="position:absolute;left:75px;top:400px; "><center><span style="font-weight:bold;">Setting for learning</span><br>';
 echo '   <div style="text-align:right;width:175px;cursor:pointer;" onclick="toogleBetweenDivs(\'pflP101\',\'pflP102\');saveSelections(8);">';
 echo '     <img src="'.$imageRoot.'/icons/next.png" width="15"/>';  
 echo '   <div>';
  $likesDisloikesAry=getLikeStatements(1,$qAry);
  $likesAry=$likesDisloikesAry[0];
  //echo 'DEBUG:';
  //print_r($dreamSheetArray);
  $pflP101Display=getDreamValue($dreamSheetArray,"pflP101","seldiv");
  $pflP102Display=getDreamValue($dreamSheetArray,"pflP102","seldiv");
  if(($pflP101Display=='none')&&($pflP102Display=='none')){$pflP101Display='block';}
  //echo 'DEBUG:'.$pflP101Display.','.$pflP102Display;
  
 echo '   <div  id="pflP101" style="width:170px;text-align:left;display:'.$pflP101Display.';font-size:10pt;">'.$likesAry[0].'</div>';
 echo '   <div id="pflP102" style="width:170px;text-align:left;display:'.$pflP102Display.';font-size:10pt;">'.$likesAry[1].'</div>';
 echo '</center></div>';



//<!-- ideas to learn: part 2 of survey-->
 echo ' <div style="position:absolute;left:550px;top:350px; ">';
 echo '	<img src="'.$imageRoot.'/page.pflSurvey/cloud.right.top.png" width="300px"/>';
 echo ' </div>';
 echo ' <div style="position:absolute;left:625px;top:400px; "><center><span style="font-weight:bold;">Big ideas to learn</span><br>';
 echo '   <div style="text-align:right;width:175px;cursor:pointer;" onclick="toogleBetweenDivs(\'pflP201\',\'pflP202\');saveSelections(8);">';
 echo '     <img src="'.$imageRoot.'/icons/next.png" width="15"/>';  
 echo '   <div>';
  $likesDisloikesAry=getLikeStatements(2,$qAry);
  $likesAry=$likesDisloikesAry[0];
  
  $pflP201Display=getDreamValue($dreamSheetArray,"pflP201","seldiv");   
  $pflP202Display=getDreamValue($dreamSheetArray,"pflP202","seldiv");
  if(($pflP201Display=='none')&&($pflP202Display=='none')){$pflP201Display='block';} 
  
 echo '   <div  id="pflP201" style="width:170px;text-align:left;display:'.$pflP201Display.';font-size:10pt;">'.$likesAry[0].'</div>';
 echo '   <div id="pflP202" style="width:170px;text-align:left;display:'.$pflP202Display.';font-size:10pt;">'.$likesAry[1].'</div>';
 echo '</center></div>';


//<!-- Ways to learn: part 3 of survey-->
 echo ' <div style="position:absolute;left:0px;top:950px; ">';
 echo '        <img src="'.$imageRoot.'/page.pflSurvey/cloud.left.bot.png" width="300px"/>';
 echo ' </div>';
echo ' <div style="position:absolute;left:70px;top:1010px; "><center><span style="font-weight:bold;">Way to learn</span><br>';
 echo '   <div style="text-align:right;width:175px;cursor:pointer;" onclick="toogleBetweenDivs(\'pflP301\',\'pflP302\');saveSelections(8);">';
 echo '     <img src="'.$imageRoot.'/icons/next.png" width="15"/>';  
 echo '   <div>';
  $likesDisloikesAry=getLikeStatements(3,$qAry);
  $likesAry=$likesDisloikesAry[0];
  
  $pflP301Display=getDreamValue($dreamSheetArray,"pflP301","seldiv");   
  $pflP302Display=getDreamValue($dreamSheetArray,"pflP302","seldiv");
  if(($pflP301Display=='none')&&($pflP302Display=='none')){$pflP301Display='block';}     
  
 echo '   <div  id="pflP301" style="width:170px;text-align:left;display:'.$pflP301Display.';font-size:10pt;">'.$likesAry[0].'</div>';
 echo '   <div id="pflP302" style="width:170px;text-align:left;display:'.$pflP302Display.';font-size:10pt;">'.$likesAry[1].'</div>';
 echo '</center></div>';



//<!-- Way to show learning: part 4 of survey-->
 echo ' <div style="position:absolute;left:550px;top:900px; ">';
 echo '        <img src="'.$imageRoot.'/page.pflSurvey/cloud.right.bot.png" width="300px"/>';
 echo ' </div>';
echo ' <div style="position:absolute;left:610px;top:980px; "><center><span style="font-weight:bold;">Way to show my learning</span><br>';
 echo '   <div style="text-align:right;width:175px;cursor:pointer;" onclick="toogleBetweenDivs(\'pflP401\',\'pflP402\');saveSelections(8);">';
 echo '     <img src="'.$imageRoot.'/icons/next.png" width="15" />';  
 echo '   <div>';
  $likesDisloikesAry=getLikeStatements(4,$qAry);
  $likesAry=$likesDisloikesAry[0];
  
  $pflP401Display=getDreamValue($dreamSheetArray,"pflP401","seldiv");   
  $pflP402Display=getDreamValue($dreamSheetArray,"pflP402","seldiv");
  if(($pflP401Display=='none')&&($pflP402Display=='none')){$pflP401Display='block';}   
  
 echo '   <div  id="pflP401" style="width:170px;text-align:left;display:'.$pflP401Display.';font-size:10pt;">'.$likesAry[0].'</div>';
 echo '   <div id="pflP402" style="width:170px;text-align:left;display:'.$pflP402Display.';font-size:10pt;">'.$likesAry[1].'</div>';
 echo '</center></div>';


//part 5 lists:
$listsArray=getTopicOptionsArray();

//<!-- Topic: part 5 sec 1-->
 echo ' <div style="position:absolute;left:525px;top:575px; ">';
 echo '        <img src="'.$imageRoot.'/page.pflSurvey/cloud.small.png" width="200px" height="75px"/>';
 echo ' </div>';
 echo ' <div style="position:absolute;left:565px;top:580px; ">';
 echo '   <center><b>Topic</b><br><select id="pflTopicWhatToLearn" onchange="saveSelections(8);">';
 echo  setTopicList(0,$listsArray,$dreamSheetArray,"topicWhat","selddl");
 echo '   </select></center>';
 echo ' </div>';					


//<!-- Topic: part 5 sec 2-->
 echo ' <div style="position:absolute;left:150px;top:850px; ">';
 echo '	<img src="'.$imageRoot.'/page.pflSurvey/cloud.small.png" width="200px"/>';
 echo ' </div>';		
 echo ' <div style="position:absolute;left:210px;top:870px; ">';
 echo '   <center><b>Action</b><br><select id="pflTopicWayToLearn"  onchange="saveSelections(8);">';
 echo     setTopicList(1,$listsArray,$dreamSheetArray,"topicWay","selddl");
 echo '   </select></center>';
 echo ' </div>';				


				
//<!-- Topic: part 5 sec 3-->
 echo ' <div style="position:absolute;left:500px;top:800px; ">';
 echo '        <img src="'.$imageRoot.'/page.pflSurvey/cloud.small.png" width="200px"/>';
 echo ' </div>';
 echo ' <div style="position:absolute;left:540px;top:820px; ">';
 echo '   <center><b>Product</b><br><select id="pflTopicShowLearn"  onchange="saveSelections(8);">';
 echo     setTopicList(2,$listsArray,$dreamSheetArray,"topicShow","selddl");
 echo '   </select></center>';
 echo ' </div>';



//<!-- Activity Div--> - INSIDE THE STAR 
 echo ' <div style="position:absolute;left:225px;top:550px; ">';
 echo '	<img src="'.$imageRoot.'/page.pflSurvey/star.png" width="350px"/>';
 echo ' </div>';
 echo ' <div style="position:absolute;left:295px;top:610px;">';
 echo '  <center>';
 echo '   <b>ACTIVITY</b><br>';
 echo '   <div id="pflDreamActivityDiv">';
 echo '    <textarea id="pflDreamActivity" name="pflDreamActivity" rows="6" cols="22"  onchange="saveSelections(8);">'.getDreamValue($dreamSheetArray,"dreamActivity","textarea").'</textarea>';
 echo '   </div>';
 echo '  </center>';
 echo ' </div>';

 echo '</div>';
}

function parseSavedDreamInput()
{
 $savedArray=array();
 if(isset($_POST['dreamSavedData']))
 {
  $infoLineAry=explode("::",$_POST['dreamSavedData']);

  for($dIndex=1;$dIndex<count($infoLineAry);$dIndex++)
  {
    $savedArray[]=explode(">>",$infoLineAry[$dIndex]);

  }
 }
 //print_r($savedArray);   
 return $savedArray;
}

function getDreamValue($infoAry,$objId,$type)
{
 $valStr="";
 if($type=='seldiv'){$valStr='none';}
 for($iIndex=0;$iIndex<count($infoAry);$iIndex++)
 {
   $curAry=$infoAry[$iIndex];
   //echo 'DEBUG:'.$type.':'.$curAry.':'.$objId;
   if(($type=='seldiv')&&($curAry[0]=='seldiv')&&($curAry[1]==$objId)){$valStr='block';}
   elseif($curAry[0]==$objId){$valStr=$curAry[1];}
   else{}
 }
 return $valStr;
}

function setTopicList($ddlId,$tListAry,$dreamTAry,$topicDescrip,$objType)
{
  $curTopicList='';
  $curTopicVal=getDreamValue($dreamTAry,$topicDescrip,$objType);
  $curTopicList=buildTopicsDropDown($ddlId,$tListAry);
  if($curTopicVal!="")
  {
    $search='value="'.$curTopicVal.'"';
    $replace='value="'.$curTopicVal.'" selected="yes"';  
    $curTopicList=str_replace($search, $replace, $curTopicList);
  }
  return $curTopicList;
}



?>

