<?php
//survey analysis functions

//////////////////////////////////////////////////////////////////
//build out the analysis of the survey codes
function buildoutAnalysis($codesLookupURL,$questionsURL)
{
   $group="empty";
   $inGroup=0;
   $stratCodesAry=array();
   $analysisArray=array();

  // build the array of all the groups (currently 4) (based on:survey codes lookup page)
   $codesStr=loadUrl_get_contents($codesLookupURL);
   //echo "here: <br>";
   //echo $codesLookupURL
   //echo $codesStr;
   $aryCodes= explode("\n", loadUrl_get_contents($codesLookupURL));//survey codes lookup page
   $codeSearchAry= explode("\n", loadUrl_get_contents($questionsURL)); //questions page url
   //print_r( $codeSearchAry);
   foreach( $aryCodes as $curGroup )
   {
     //print_r($curGroup);
	 //echo "<br>";
     $line=str_replace(array("\r\n", "\r", "\n", "\n\r"), "", $curGroup);
     if(strlen($line)>0)
     { 
      if((substr_count($line,"[GROUPING:")>0)&&($inGroup==0))
      {
       $group=getInfo("[GROUPING:","]",$line);
       $inGroup=1;
      }
      elseif((substr_count($line,"[GROUPEND]")>0)&&($inGroup==1))
      {
       $inGroup=0;
       $analysisArray=updateAnalysisArray($analysisArray,$group,$stratCodesAry); 
       $inGroup=0;
       $group="empty";
       $stratCodesAry=array(); 
      }
      else
      {
       if($inGroup==1)
       {
        // under each group build the array of each strategy, including the code (survey codes lookup page)
          $codesInfo=explode("[",$line);
        //print_r($codesInfo);
          $stratCode=getInfo("c:","]",$codesInfo[1]);
          $stratName=getInfo("n:","]",$codesInfo[2]);

         // with each strategy, you also need the total number of occurances of each (based on: questions page url)
         // add the number of occurences that have been selected during the survey based on the $_POST parameters
          $stratMax=getSurveyCount($stratCode,$codeSearchAry);
          $stratSelect=getSurveySelectedCount($stratCode);

          $percProp=round(100*($stratSelect/$stratMax));
 
        //echo '<br>'.$stratCode.''.$stratName;       
          $stratCodesAry[]=array($stratCode,$stratName,$stratMax,$stratSelect,$percProp);
       }
      }
     }
    }
  
  
  // build a table based on this information
  buildSurveyAnalysisTable($analysisArray);
  //print_r($analysisArray);

}

//////////////////////////////////////////////////////////////////
//build the analysis table in html 
function buildSurveyAnalysisTable($analysisArray)
{
 echo '<table>';
 echo '<tr>';

 echo '<td>';
 echo '<table id="summaryAnalysisTable">';
 $cellCount=0;

 $numOfTables=sizeof($analysisArray);
 if(($numOfTables%2)!=0){$numOfTables=$numOfTables+1;}
 for($curIndex=0;$curIndex<$numOfTables;$curIndex++)
 {
  $cellCount=$cellCount+1;
  if ($cellCount==1){echo '<tr>';}

  echo '<td>';
  $curGroupAry=$analysisArray[$curIndex];
  echo '<table id="survAnalysisTable" >';
  echo '<tr><th colspan="4">'.$curGroupAry[0].'</th></tr>';
  echo '<tr><td>Strategy</td><td>Selected</td><td>Max</td><td>%</td></tr>';

  foreach( $curGroupAry[1] as $curStrat )
  {
    echo '<tr>'; 
    echo '<td width="150px" >'.$curStrat[1].'</td>'; //name
    echo '<td width="50px" style="text-align:center">'.$curStrat[3].'</td>'; //times selected
    echo '<td width="40px" style="text-align:center">'.$curStrat[2].'</td>'; //times appears in survey
    echo '<td width="25px" >'.$curStrat[4].'</td>'; //percent
    echo '</tr>'; 
  } 

  echo '</table>';
  echo '</td>';

  if ($cellCount==1){ echo '<td>&nbsp;</td>';}

  if ($cellCount==2)
  {
   echo '</tr>';
   echo '<tr><td colspan="2"> &nbsp;</td></tr>';
   $cellCount=0;
  }
 }

 echo '</table>';
 echo '</td>';

 echo '<td>&nbsp;&nbsp;&nbsp;</td>';

 echo '<td valign="top" width="200px">';
 echo '<b>Most Recomended (by %):</b>';
 echo '<ul>';
  $stratsByPerc=sortStratsByPerc($analysisArray);
  for($stratOrder=sizeof($stratsByPerc)-1;$stratOrder>=sizeof($stratsByPerc)-3;$stratOrder--) //print top 3
  {
   echo '<li>'.$stratsByPerc[$stratOrder].'</li>';
  }
  
 echo '</ul>';
 echo '</td>';

 echo '</tr>';
 echo '</table>';
}

//////////////////////////////////////////////////////////////////
//return 1 array ordering the strats by selected perc from lowest to highest
function  sortStratsByPerc($analysisArray)
{
 $stratCodesArray=array();
 $percAry=array();
 $stratAry=array();

 foreach($analysisArray as $curGroup)
 {
  $stratCodesArray=array_merge($stratCodesArray, $curGroup[1]);
 }

 foreach($stratCodesArray as $curStrat)
 {
  $percAry[]=$curStrat[4];
  $stratAry[]=$curStrat[1];
 }

 array_multisort($percAry, $stratAry); //both arrays are sorted against eachother, from from lowest to highest perc
 //return $percAry;
 return $stratAry;
}

//////////////////////////////////////////////////////////////////
//get the count of all the selected strategies
function getSurveySelectedCount($code) 
{
 $count=0;
 for ($i = 1; $i <= 4; $i++) 
 {
   if(isset($_POST['part'.$i.'StratCodes']))
   {
    $count=$count+substr_count($_POST['part'.$i.'StratCodes'],$code);
   }
 }
 return $count; 
}

//////////////////////////////////////////////////////////////////
//get the number of times a code appears in the survey
function getSurveyCount($code,$searchLines)
{
  
  $count=0;

  foreach( $searchLines as $line )
  {
      if(substr_count($line,$code)>0){ $count=$count+1;}
  }
  return $count;
}

//////////////////////////////////////////////////////////////////
//add a code to the analysis array
function updateAnalysisArray($analysisArray,$group,$stratCodesAry)
{
   $analysisArray[]=array($group,$stratCodesAry);
   //print_r($analysisArray);
   return $analysisArray;
}

?>
