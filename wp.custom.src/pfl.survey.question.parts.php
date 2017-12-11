<?php
//functions required to generate and work with the survey questions - parts 1 to 4


//unused constant
$lineCleanupAry=array("\n", "\r", "\r\n");


//////////////////////////////////////////////////////////////////
//generate the html from the survey questions
function buildoutQuestions($partId, $qPageUrl)
{
 //echo $partId.'-'.'./?page_id='.$qPageId.'<br>';
 //echo loadUrl_get_contents('http://possibilitiesforlearning.com/?page_id=1321');
 
 $qAry= explode("\n", loadUrl_get_contents($qPageUrl));//questions page url
 //print_r($qAry);
 $partInit=0;
 $firstNum=0;


 //look for saved data from this section 
 if(isset($_POST['part'.$partId.'SavedData'])){$curSelVals=explode(',',$_POST['part'.$partId.'SavedData']);}
 else{$curSelVals=array();}
 //print_r($curSelVals);


 foreach( $qAry as $curQ )
 {
   $workingStr=str_replace(array("\r\n", "\r"), "\n", $curQ);
   $cleanLine=str_replace($lineCleanupAry , "", $workingStr);
   $curQLine=trim(str_replace("\r\n","",$cleanLine)," ");
   //echo "got here: -->". $curQLine;

   if(strlen($curQLine)>0)
   {

	if(substr_count($curQLine,"[PARTSTART:")>0)
	{		
		$curPart=getInfo('[PARTSTART:',']',$curQLine);//substr($curQLine, $initpos, $finpos-$initpos);
		if(intval($curPart)==$partId){$partInit=1;}
	}
	elseif(substr_count($curQLine,"[PARTEND]")>0){$partInit=0;}
	else
	{
		if($partInit==1)
		{
	         $curQInfo=explode("[",$curQLine);	
		 $qNum=str_replace("]" , "", $curQInfo[1]);
		 $qCode=str_replace("]" , "", $curQInfo[2]);
		 $qText=str_replace("]" , "", $curQInfo[3]);
                 $partID='PART0'.$curPart.'_'.$qNum;

		if($firstNum==0){$firstNum=$qNum;}
		$lastNum=$qNum;

                   
      //load previous survey question selections
      $currentVal=$curSelVals[$qNum+1-$firstNum];

      //echo "<br>".$qNum.":".$firstNum.":".$currentVal."<br>";

      $checkedAry=array(array('SA',''),array('A',''),array('N',''),array('D',''),array('SD',''));
      if($currentVal!="")
      { 
       for($i=0;$i<sizeof($checkedAry);$i++)
       {
         if($checkedAry[$i][0]==$currentVal){$checkedAry[$i][1]='checked';}
       }        
      }
      
      //print_r($checkedAry);
echo '<table id="'.$partID.'" qnum="'.$qNum.'" qtext="'.$qText.'">';
echo '<tr>';
echo '<td width="50px" align="justify">'.$qNum.'</td>';
echo '<td width="200px" align="justify">';
echo '   <table class="survQTable">';
echo '     <tr>';
echo '      <td><input type="radio" name="'.$partID.'" value="SA" stratids="'.$qCode.'" id="'.$partID.'" ';
echo  '      onclick="saveSelections('.$curPart.')" '.$checkedAry[0][1].'></td>';
echo '      <td><input type="radio" name="'.$partID.'" value="A"  '.$checkedAry[1][1].'></td>';
echo '      <td><input type="radio" name="'.$partID.'" value="N"  '.$checkedAry[2][1].'></td>';
echo '      <td><input type="radio" name="'.$partID.'" value="D"  '.$checkedAry[3][1].'></td>';
echo '      <td><input type="radio" name="'.$partID.'" value="SD"  '.$checkedAry[4][1].'></td>';	
echo '    </tr>';	
echo '    <tr><td>SA</td><td>A</td><td>N</td><td>D</td><td>SD</td></tr>';
echo '   </table>';
echo '</td>';
echo '<td width="500px">'.$qText.'</td>';
echo '</tr>';
echo '</table><br><br>';
		}
	}

   }

 }

$part=$partId;
$ldAry=array();
//echo 'debug:'.$part.':'. $_POST['pflSurveyLikesDislikesPart1'].'<br>';
if(isset($_POST['pflSurveyLikesDislikesPart'.$part]))
{
 //,,pflP02LikeBest01:42,pflP02LikeLeast01:44,pflP02LikeBest02:43,pflP02LikeLeast02:45
 
 $ldRootAry=explode(',',$_POST['pflSurveyLikesDislikesPart'.$part]);
 foreach($ldRootAry as $curld)
 {
  if(strlen($curld)>0){$ldAry[]=explode(':',$curld);}
 }
}

echo 'Which two things in this section do you like best? Choose from the sentences numbered from '.$firstNum.' - '.$lastNum.'<br>';
echo '<input id="pflP0'.$part.'LikeBest01" type="text" maxlength="3" value="'.getValFromArray('pflP0'.$part.'LikeBest01', $ldAry).'" onchange="isNumeric(this.value,'.$firstNum.','.$lastNum.',this.id)">';
echo '<input id="pflP0'.$part.'LikeBest02" type="text" maxlength="3" value="'.getValFromArray('pflP0'.$part.'LikeBest02', $ldAry).'" onchange="isNumeric(this.value,'.$firstNum.','.$lastNum.',this.id)">';

echo '<br>Which two things in this section do you like least?<br>';
echo '<input id="pflP0'.$part.'LikeLeast01" type="text" maxlength="3" value="'.getValFromArray('pflP0'.$part.'LikeLeast01', $ldAry).'" onchange="isNumeric(this.value,'.$firstNum.','.$lastNum.',this.id)">';
echo '<input id="pflP0'.$part.'LikeLeast02" type="text" maxlength="3" value="'.getValFromArray('pflP0'.$part.'LikeLeast02', $ldAry).'" onchange="isNumeric(this.value,'.$firstNum.','.$lastNum.',this.id)">';

}

//////////////////////////////////////////////////////////////////
//retun the like and dislike text values for use in survey analysis
function getLikeStatements($part,$qAry)
{
   $likesAry=array();
   $dislikesAry=array();
   if(isset($_POST['pflSurveyLikesDislikesPart'.$part]))
   {
  //pflP02LikeBest01:42,pflP02LikeLeast01:44,pflP02LikeBest02:43,pflP02LikeLeast02:45
    $likesDislikesAry=explode(',',$_POST['pflSurveyLikesDislikesPart'.$part]);
    foreach($likesDislikesAry as $line)
    { 
      if(substr_count($line,'LikeBest')>0)
      {
       $curLike=explode(':',$line);
       $likesAry[]=getQuestionText($curLike[1],$qAry);
      }
      if(substr_count($line,'LikeLeast')>0)
      {
       $curDislike=explode(':',$line);
       $dislikesAry[]=getQuestionText($curDislike[1],$qAry);
      }
    }
   }
  return array($likesAry,$dislikesAry);
}

//////////////////////////////////////////////////////////////////
//retun the text from a specific question number
function getQuestionText($qNum,$qAry)
{
  //[1][pflVarGrp][I like doing projects in a group when I get to choose my group.]
  foreach($qAry as $qLine)
  {
   if(substr_count($qLine,'['.$qNum.']')>0)
   {
     $qInfo=explode('[',$qLine);
     $qText=str_replace(']','',$qInfo[3]);
     //echo '<br>'.$qText.'<br>';
     return $qText;
   }
  }
  return '';
}

?>
