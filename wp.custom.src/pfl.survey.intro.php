<?php
//functions to populate the intro (part 0)

//////////////////////////////////////////////////////////////////
//generate intro part of survey
function buildoutIntro()
{
 //#pflName:n##pflDate:d##pflAge:1##pflGrade:g##FavSubj:(cbpflIntroMath-true)(cbpflIntroRead-false)(cbpflIntroWrite-true)(cbpflIntroScience-false)(cbpflIntroSS-true)(cbpflIntroOth-true)##inptPFLSubjFavOther:other#

 $infoArray=array();
 if(isset($_POST['part0SavedData']))
 {
  $infoLineAry=explode("#",$_POST['part0SavedData']);
  foreach($infoLineAry as $infoLine)
  {
   if(strlen($infoLine)>0)
   {
     if(substr_count($infoLine,"FavSubj:")>0)
     {
       $favCBLine=explode(':',$infoLine);
       $curFavCBLine=$favCBLine[1];
       $favCBAry=explode('(',str_replace(')','',$curFavCBLine));
       foreach($favCBAry as $curCB)
       {
         $curCBAry=explode('-',$curCB);
         if($curCBAry[1]=='true'){$curCBAry[1]='checked';}
         else{$curCBAry[1]='';}
  
         $infoArray[]=$curCBAry;
       } 
         
     }
     else{ $infoArray[]=explode(':',$infoLine);}
   }
  }

  //print_r($infoArray);
 }

$curPart=0;
echo '<table width="500px">';
echo ' <tr>';
echo '  <td>Name:</td><td width="200px"><input id="pflName" name="pflName" type="text" maxlength="50" onchange="saveSelections('.$curPart.')" value="'.getValFromArray('pflName', $infoArray).'"/></td>';
echo '  <td >Date:</td><td width="200px"><input id="pflDate" name="pflDate" type="date" onchange="saveSelections('.$curPart.')" value="'.getValFromArray('pflDate', $infoArray).'"/></td>';
echo ' </tr>';
echo ' <tr>';
echo '  <td >Age:</td><td width="200px"><input id="pflAge" name="pflAge" type="text" maxlength="3" onchange="isNumeric(this.value,1,199,this.id);saveSelections('.$curPart.');" value="'.getValFromArray('pflAge', $infoArray).'"/></td>';
echo '  <td >Grade:</td><td width="200px" ><input id="pflGrade" name="pflGrade" type="text" maxlength="50" onchange="saveSelections('.$curPart.')" value="'.getValFromArray('pflGrade', $infoArray).'"/></td>';
echo ' </tr>';
echo '</table>';
echo '<hr>';
echo 'Please select your favorite school subject or write in the one you like best.<br>';
echo '<table id="introTable">';
echo '<tr>';
echo ' <td><input id="cbpflIntroMath" value="Math" type="checkbox" group="pflFavSubj" onchange="saveSelections('.$curPart.')" '.getValFromArray('cbpflIntroMath', $infoArray).'>Math</td>';
echo ' <td ><input id="cbpflIntroRead" value="Reading" type="checkbox" group="pflFavSubj" onchange="saveSelections('.$curPart.')" '.getValFromArray('cbpflIntroRead', $infoArray).'>Reading</td>';
echo ' <td ><input id="cbpflIntroWrite" value="Writing" type="checkbox" group="pflFavSubj" onchange="saveSelections('.$curPart.')" '.getValFromArray('cbpflIntroWrite', $infoArray).'>Writing</td>';
echo '</tr>';
echo '<tr>';
echo ' <td><input id="cbpflIntroScience" value="Science" type="checkbox" group="pflFavSubj" onchange="saveSelections('.$curPart.')" '.getValFromArray('cbpflIntroScience', $infoArray).'>Science</td>';
echo ' <td><input id="cbpflIntroSS" value="Social Studies" type="checkbox" group="pflFavSubj" onchange="saveSelections('.$curPart.')" '.getValFromArray('cbpflIntroSS', $infoArray).'>Social Studies</td>';
echo ' <td><input id="cbpflIntroOth" value="other" type="checkbox" onclick="toogleDiv(\'inptPFLSubjFavOther\')" group="pflFavSubj" '.getValFromArray('cbpflIntroOth', $infoArray).'>Other</td>';
echo '</tr>';
echo '<tr>';
echo ' <td>&nbsp;</td>';
echo ' <td>&nbsp;</td>';
echo ' <td>';
echo '   <input id="inptPFLSubjFavOther" name="inptPFLSubjFavOther"';
    if(getValFromArray('cbpflIntroOth', $infoArray)!="checked"){echo '   style="display:none;"';}  
echo '   type="text" maxlength="50" onchange="saveSelections('.$curPart.')" value="'.getValFromArray('inptPFLSubjFavOther', $infoArray).'">';
echo ' </td>';
echo '</tr>';
echo '</table>';
}


//////////////////////////////////////////////////////////////////
//return an array that has the introductory information from the intro part of the survey
//should be integrated into intro array decoding in other parts!!!!!!
function buildIntroInfoArray()
{
 $infoArray=array();
 if(isset($_POST['part0SavedData']))
 {
  $infoLineAry=explode("#",$_POST['part0SavedData']);

  foreach($infoLineAry as $infoLine)
  {
   if(strlen($infoLine)>0)
   {
     if(substr_count($infoLine,"FavSubj:")>0)
     {
       $fullFavString="";
       $favCBLine=explode(':',$infoLine);
       $curFavCBLine=$favCBLine[1];
       $favCBAry=explode('(',str_replace(')','',$curFavCBLine));
       foreach($favCBAry as $curCB)
       {
         $curCBAry=explode('-',$curCB);
         //print_r($curCBAry).'<br>';
         if($curCBAry[1]=='true')
         {
           $curCBAry[1]='checked';
           $fullFavString=$curCBAry[2].",".$fullFavString;
         }//if
         else{$curCBAry[1]='';}
  
         $infoArray[]=array($curCBAry[0],$curCBAry[1]);
       }//forach 
         
     }//if fav
     else{ $infoArray[]=explode(':',$infoLine);}
   }//if not empty
  }//foreach
 }//if isset
 $infoArray[]=array('fullFavString',$fullFavString); 
 //print_r($infoArry infoArray); 
 return $infoArray;
}//fxn


?>
