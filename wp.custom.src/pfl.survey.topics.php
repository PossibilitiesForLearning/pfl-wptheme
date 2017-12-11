<?php
//functions requited to build out and populate survey topic lists
//ENTIRE SECTIONS NEEDS REFACTORING!!!

//////////////////////////////////////////////////////////////////
//build the html for the topics lists
function buildoutTopics($topicsListURL)
{

   $inTopic=0;
   $topicLists=explode("\n", loadUrl_get_contents($topicsListURL));//lists for part 5
   $listType="";
   $listCode=""; 
   $listInst="";
   $yourCornerAry=array();
   $topicsAry=array();
   $learningTopicsAry=array();

   foreach( $topicLists as $curLine )
   {
     $line=str_replace(array("\r\n", "\r", "\n", "\n\r"), "", $curLine);
     if(strlen($line)>0)
     { 
      if((substr_count($line,"[LISTTYPE:")>0)&&($inTopic==0))
      {
       $listType=getInfo("[LISTTYPE:","]",$line);
       $inTopic=1;
      }
      elseif((substr_count($line,"[INSTRUCTIONS:")>0)&&($inTopic==1)){$listInst=getInfo("[INSTRUCTIONS:","]",$line);}
      elseif((substr_count($line,"[CODE:")>0)&&($inTopic==1)){$listCode=getInfo("[CODE:","]",$line);}
      elseif((substr_count($line,"[YOURCORNER:")>0)&&($inTopic==1))
      {
       $yourCornerAry[]=getInfo("[YOURCORNER:","]",$line);
      }
      elseif((substr_count($line,"[LISTTYPEEND]")>0)&&($inTopic==1))
      {
        $learningTopicsAry[]=array($listCode,$listType,$listInst,$topicsAry,$yourCornerAry);
        $inTopic=0;
        $listType="";
        $listInst="";
        $listCode=""; 
        $yourCornerAry=array();
        $topicsAry=array();
      }
      elseif((substr_count($line,"[opt:")>0)&&($inTopic==1)){$topicsAry[]=getInfo("[opt:","]",$line);}
      else{}//do nothing
     }
    }

    buildTopicsCBs($learningTopicsAry);
}

//////////////////////////////////////////////////////////////////
//get a current topic from saved array, and check if it is checked
function getCurTopic($curGroupTopic,$searchTopic,$topicArrays)
{
 foreach($topicArrays as $curTopicAry)
 {
  if($curTopicAry[0]==$curGroupTopic)
  {
   for($i=1;$i<sizeof($curTopicAry);$i++)
   {
    if($curTopicAry[$i]==$searchTopic){return "checked";}
   }
  }
 }
 return "";
}


//////////////////////////////////////////////////////////////////
//generate topics lists THIS FUNCTION NEEDS REFACTORING!!!!
function buildTopicsCBs($learningTopicsAry)
{
  //loading the data
  $topicsListStr='';
  $infoAry=array();
  if(isset($_POST['part5SavedData']))
  {
    $topicsListStr=$_POST['part5SavedData'];
    $topicsListAry=explode('[',$_POST['part5SavedData']);
    // START:whattolearn],animals,architecture,art,a,b
    foreach($topicsListAry as $line)
    {
      $line=str_replace(array("\r\n", "\r", "\n", "\n\r"), "", $line);
      if((strlen($line)>0)&&(substr_count($line,',')>0))
      {
       //echo "-".$line."-";
       $curTopicGroup=getInfo("START:","]",$line);
       $curTopicListAry=explode(',',$line);
       $curTopicListAry[0]=$curTopicGroup;
       //print_r($curTopicListAry);
       //echo "<br>";
       $infoAry[]=$curTopicListAry;
      }
    }
  }

  $curPart=5;
  echo '<div id="topicsLists">';
   
  foreach($learningTopicsAry as $curLearn)
  {
    echo '<div id="div_'.$curLearn[0].'">';
    echo '<span id="topicTitle">'.$curLearn[1].'</span><br>';
    echo '<span id="topicInstr">'.$curLearn[2].'</span><br><br>';
    echo '<table>';
    
    $cellCount=0; 
    //print_r($curLearn[3]);
    foreach($curLearn[3] as $curTopic)
    {
      $cellCount=$cellCount+1;
      if($cellCount==1){echo '<tr>';}
      echo '<td><input group="'.$curLearn[0].'" type="checkbox" value="'.$curTopic.'" onclick="saveSelections('.$curPart.');"';
      echo getCurTopic($curLearn[0],$curTopic,$infoAry);
      echo '>'.$curTopic.'</td>';
      if($cellCount==5)
      {
       echo '</tr>';
       $cellCount=0;
      }
    }
    //if not complete table
    if($cellCount!=0)
    {
     for($fixIndex=$cellCount;$fixIndex<=5;$fixIndex++){echo '<td>&nbsp;</td>';} 
     echo '</tr>';
    }
    echo '</table>';

    echo '<br><span id="topicYC">Your Corner</span><br>';
    $YCIndex=0;
    foreach($curLearn[4] as $curCorner)
    {
      $YCIndex=$YCIndex+1;
      echo '<span id="topicYCQ">'.$curCorner.'</span><br>';
      echo '<textarea  group="'.$curLearn[0].'" name="YC_'.$YCIndex.'_'.$curLearn[0].'" id="YC_'.$YCIndex.'_'.$curLearn[0].'" onchange="saveSelections('.$curPart.');">';
      echo getInfo('YC_'.$YCIndex.'_'.$curLearn[0].'#(',')',$topicsListStr);
      echo '</textarea><br><br>';
    }

    echo '</div>';
  }

  echo '</div>';
}

//////////////////////////////////////////////////////////////////
//return the topics from the selected topics as an array per group
function getTopicOptionsArray()
{
   $splitTopicsAry=array();

   $splitTopicsAry[]=getTopicListFromData('whattolearn','Select two favorite topics, one from each dropdown list');   
   $splitTopicsAry[]=getTopicListFromData('waystolearn','Select two favorite ways to learn from the dropdown list');   
   $splitTopicsAry[]=getTopicListFromData('showlearn','Select two favorite ways to show your learning from the dropdown list');   
 
   return $splitTopicsAry;
}//fxn


//////////////////////////////////////////////////////////////////
//get selected topics from a specific group
function getTopicListFromData($groupStr,$groupStrLine)
{
 $savedTopics=$_POST['part5SavedData'];
 $curTopicsStr=getInfo('[START:'.$groupStr.']','[END:'.$groupStr.']',$savedTopics);

 //[START:whattolearn],animals,architecture,YC_1_whattolearn#(a,b,c),YC_2_whattolearn#(d,e,f)[END:whattolearn]
     
 $YCcurTopicsAry=explode(',YC_',$curTopicsStr);
 //print_r($YCWhatToLearnAry);
 //echo '<br>';
 $topicsListAry=array();
 $topicsListAry[]=$groupStr; 
 $topicsListAry[]=$groupStrLine; 
 foreach($YCcurTopicsAry as $curTopicPart)
 {
  if(substr_count($curTopicPart,'#(')){$curTopicPart=getInfo('#(',')',$curTopicPart);}
  $topicsListAry=array_merge($topicsListAry,explode(',',$curTopicPart));
  for($ind=0;$ind<sizeof($topicsListAry);$ind++)
  {
    if(strlen($topicsListAry[$ind])<=0){unset($topicsListAry[$ind]);}
  } 
 }
 //print_r($topicsListAry);
 //echo '<br>';
 return $topicsListAry;
}


//////////////////////////////////////////////////////////////////
//build out topics drop down list
function buildTopicsDropDown($topicPart,$listsArray)
{
 $topicSelStr="";
 $curTopicArray=$listsArray[$topicPart];
 for($tIndex=2;$tIndex<sizeof($curTopicArray);$tIndex++)
 {
  $topicSelStr=$topicSelStr.'<option value="'.$curTopicArray[$tIndex].'">'.$curTopicArray[$tIndex].'</option>';
 }
 return $topicSelStr;
}

?>
