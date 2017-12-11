<?php /* Template name: PFL Survey */ ?>
<?php
/**
 * The template for the main pfl surevy questions.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); 
?>


<?php 
	include_once('./wp.custom.src/pfl.php');
	include_once('./wp.custom.src/pfl.survey.cmn.php');
	include_once('./wp.custom.src/pfl.survey.intro.php');
	include_once('./wp.custom.src/pfl.survey.question.parts.php');
	include_once('./wp.custom.src/pfl.survey.topics.php');
	include_once('./wp.custom.src/pfl.survey.analysis.php');
	include_once('./wp.custom.src/pfl.survey.summary.php');
	include_once('./wp.custom.src/pfl.survey.dreamsheet.php');
?>
<link rel="stylesheet" href="/wp.custom.css/pfl.css" type="text/css">

<style>
#introTable td{width:150px;}

#pflSurveyNavTbl{width:500px;}
#pflSurveyNavLeft{text-align:left;width:100px;}
#pflSurveyNavRight{text-align:right;width:100px;}

#survAnalysisTable{width:300px; border-collapse: collapse; border: 1px solid black;}
#survAnalysisTable th{ border: 2px solid black; text-align: center; padding: 5px; vertical-align:middle;}
#survAnalysisTable td{ border: 2px solid black;  padding: 0px; font-size:10px;}

#topicsLists div{width:800px; border-collapse: collapse; border: 0px solid black;}
#topicsLists #topicTitle{font-weight:bold;font-size:14pt;}
#topicsLists #topicInstr{font-style:italic;font-size:12pt;color:blue;}
#topicsLists #topicYC{font-style:underline;font-weight:bold;font-size:13pt; color:green;} 
#topicsLists #topicYCQ{font-style:italic;font-size:12pt;}


#summaryInfoDiv{ width:700px; border-collapse: collapse; border: 1px solid black; padding:10px;}
#summaryInfoDiv th{text-align: left;font-weight:bold; padding:5px;}

#summaryInfoLikesDiv{ width:700px; border-collapse: collapse; border: 1px solid black; padding:10px;}
#summaryInfoLikesDiv th{text-align: left;font-weight:bold; padding:5px;}

#summaryInfoTopicsDiv{ width:700px; border-collapse: collapse; border: 1px solid black; padding:10px;}
#summaryInfoTopicsDiv th{text-align: left;font-weight:bold; padding:5px;}

#summaryInfoDislikesDiv{ width:700px; border-collapse: collapse; border: 1px solid black; padding:10px;}
#summaryInfoDislikesDiv th{text-align: left;font-weight:bold; padding:5px;}


#survProg td{color:grey;font-style:oblique;font-size:8pt;}
</style>


<script type="text/javascript" src="/wp.custom.src/cmn.fxns.js"></script>


<script type="text/javascript">
//submit form for print
function printPFLSurvey()
{
 toogleDiv('printSelBox');
 
 curSelector=document.getElementById("surveyPrintSelect");
 //alert(curSelector.selectedIndex); 
 //(0 - full)(1-analysis)(2-summary)(3-dream)
 targetAction="";
 
 if(curSelector.selectedIndex==0){ targetAction="/ext.print/survey.print.php?printSel=quest";}
 //if(curSelector.selectedIndex==1){ targetAction="/ext.print/survey.print.php?printSel=strats";} 
 if(curSelector.selectedIndex==1){ targetAction="/ext.print/survey.print.php?printSel=sum";}
 if(curSelector.selectedIndex==2){ targetAction="/ext.print/survey.print.php?printSel=dream";}
 
 if(targetAction=="")
 {
  alert("The option that you have selected is unavailable.");
 }
 else
 {
  document.surveyNavForm.target="_blank";
  document.surveyNavForm.action=targetAction;
  document.getElementById("surveyNavForm").submit();
 }
}
//submit form to save data
function savePFLSurveyData()
{
 document.surveyNavForm.target="_blank";

 //document.surveyNavForm.action="./?page_id=407";
 document.surveyNavForm.action="./?page_id=1287";
 document.getElementById("surveyNavForm").submit();
}

function loadPFLSurveyData()
{
 //document.surveyNavForm.action="./?page_id=464";
 document.surveyNavForm.action="./?page_id=1359"; 
 document.getElementById("surveyNavForm").submit();
}


//run navigation procedures
function pflAnalysisNav(analysisPart,curPart)
{
 //document.surveyNavForm.action="./?page_id=421&part="+analysisPart+"&prevPart="+curPart;
 document.surveyNavForm.action="./?page_id=1337&part="+analysisPart+"&prevPart="+curPart;
 saveSelections(curPart);
 document.getElementById("surveyNavForm").submit();
}

//TO BE REMOVED: function toogleAnalysisButtons()
//{
// survButtState=document.getElementById("summaryButton").disabled;
// dreamButtState=document.getElementById("dreamButton").disabled;
//  //alert(survButtState);
//  if(survButtState){document.getElementById("summaryButton").disabled=false;}
//  else{document.getElementById("summaryButton").disabled=true;}
//
//  if(dreamButtState){document.getElementById("dreamButton").disabled=false;}
//  else{document.getElementById("dreamButton").disabled=true;}
//
//  
//}

function returnToSurvey(prevPart)
{
 //document.surveyNavForm.action="./?page_id=421&part="+prevPart;
 //document.surveyNavForm.action="./?page_id=1337&part="+prevPart;
 document.surveyNavForm.action=document.URL+"&part="+selPart;
 document.getElementById("surveyNavForm").submit();
}

function jumpToSurvey(selPart,curPart)
{
 //alert(document.URL+"&part="+selPart);
 document.surveyNavForm.action=document.URL+"&part="+selPart;
 saveSelections(curPart);
 document.getElementById("surveyNavForm").submit();
}

function pflNav(curPart,direction)
{
 document.getElementById("selAct").value=direction; 
 saveSelections(curPart);
 //progress info

 isFormComplete=checkFormCompletion(curPart,direction); 
 if((isFormComplete==false)&&(curPart!=5))
 {
  alert('Please fill in the 4 "Like Best" & "Like Least" before continuing to the next stage of the survey.')
 }
 if((isFormComplete==true) && (direction=="next"))
 {
  document.getElementById("p"+curPart+"stat").value="1";
  //set next view 
  lastView=parseInt(document.getElementById("lastViewedPart").value);
  nextView=curPart+1;

  if(nextView>lastView){document.getElementById("lastViewedPart").value=nextView;}
 }

 if(isFormComplete)
 {
  document.getElementById("surveyNavForm").submit();
 }
}

//check that the form is complete
function checkFormCompletion(curPart,direction)
{
//verify that the like/dislike forms are filled
 if((curPart!=0)&&(curPart!=5)&&(curPart!=6)&&(curPart!=7)&&(direction!="back"))
 {
   for(qIndex=1;qIndex<=2;qIndex++)
   {
    //alert("pflP0"+curPart+"LikeBest0"+qIndex);
    if(document.getElementById("pflP0"+curPart+"LikeBest0"+qIndex).value.length==0){return false;}
    if(document.getElementById("pflP0"+curPart+"LikeLeast0"+qIndex).value.length==0){return false;}
   }
  return true;
 }

 if(curPart==5){ return checkPart5();}

 return true; //everything else
}

function checkPart5()
{
   allInpts = document.getElementsByTagName('input');
   for(i=0;i<allInpts.length;i++)
   {
    if((allInpts[i].type=="checkbox")&&(allInpts[i].checked))
    {
   //alert('here');
     return true;
    }
   }
   return false	 
}

//verify numeric input based on criteria
function isNumeric(value,minRange,maxRange,id) 
{

  if (value != null && !value.toString().match(/^[-]?\d*\.?\d*$/)) 
  {
  	alert("You must enter a number between " + minRange + " and " + maxRange);
  	document.getElementById(id).value="";
  	return false;
  }
  if((value>=minRange)&&(value<=maxRange))
  {
  		return true;
  }
  else
  {
  	alert("You must enter a number between " + minRange + " and " + maxRange);
  	document.getElementById(id).value="";
  	return false;
  	}
  
}

//save sepecific potions of the site to hidden 
function saveSelections(curPart)
{
 if((curPart!=0)&&(curPart!=5)&&(curPart!=6)&&(curPart!=7)&&(curPart!=8)) //refactor, this shoulkd be the fxn in the else.
 {
  //alert("p1t4:"+curPart); 

  saveSelResult=setPartSel(curPart);
  document.getElementById("part"+curPart+"SavedData").value=saveSelResult[0];
 //alert(saveSelResult[0]);
  document.getElementById("part"+curPart+"StratCodes").value=saveSelResult[1];
  document.getElementById("pflSurveyLikesDislikesPart"+curPart).value=saveSelResult[2];

 }
 else if(curPart==0)
 {
  //alert("p0:"+curPart); 
  document.getElementById("part0SavedData").value=saveIntroResults(); 
   //alert(document.getElementById("part0SavedData").value);
 }
 else if(curPart==5)
 {
  //alert("p5:"+curPart); 
  document.getElementById("part5SavedData").value=saveTopicsResults();
  if(checkPart5())
  {
   document.getElementById("surveyAnalysisLink").style.pointerEvents="auto";
   document.getElementById("surveyAnalysisLink").style.opacity=1;

   document.getElementById("surveySummaryLink").style.pointerEvents="auto";
   document.getElementById("surveySummaryLink").style.opacity=1;

   document.getElementById("surveyDreamLink").style.pointerEvents="auto";
   document.getElementById("surveyDreamLink").style.opacity=1;
   
   document.getElementById("p5stat").value=1;
   document.getElementById("p5status").checked=true;

	
  } 
 }
 else if(curPart==7)
 {
  //alert("p7:"+curPart); 
  document.getElementById("summarySavedData").value=saveSummaryInfo(); 
 }
 else if(curPart==8)
 {
  //alert("p8:"+curPart); 
  document.getElementById("dreamSavedData").value=saveDreamInfo(); 
 }
 else{}//do nothing
}

//get summary page results
function saveSummaryInfo()
{
 summaryInfo="";
 var topicOps=new Array("whattolearn","waystolearn","showlearn");
 for(tIndex=0;tIndex<topicOps.length;tIndex++)
 {
  //alert(topicOps[tIndex]);
  summaryInfo=summaryInfo+";"+topicOps[tIndex]+":";
  summaryInfo=summaryInfo+document.getElementById(topicOps[tIndex]+"_1").value;
  summaryInfo=summaryInfo+","+document.getElementById(topicOps[tIndex]+"_2").value;
 }
 //alert(summaryInfo);
 return summaryInfo;
}

//get dream page results
function saveDreamInfo()
{
//alert('here');
 dreamInfo="";
 
 dreamInfo=dreamInfo+"::topicWhat>>"+document.getElementById("pflTopicWhatToLearn").value;
 dreamInfo=dreamInfo+"::topicWay>>"+ document.getElementById("pflTopicWayToLearn").value;
 dreamInfo=dreamInfo+"::topicShow>>"+ document.getElementById("pflTopicShowLearn").value;
 dreamInfo=dreamInfo+"::dreamActivity>>"+ document.getElementById("pflDreamActivity").value;

 
 for(dIndex=1;dIndex<=4;dIndex++)
 { 
   curDivRoot="pflP"+dIndex+"0";
   if(document.getElementById(curDivRoot+"1").display=="block"){curDiv=curDivRoot+"1";}
   else{curDiv=curDivRoot+"2";}

    //dreamInfo=dreamInfo+"::"+curDiv+">>"+ document.getElementById(curDiv).innerHTML;
    dreamInfo=dreamInfo+"::seldiv>>"+ curDiv;
  }
 //alert(dreamInfo); 
 return dreamInfo;
}

//get the topics from the checkboxes(part5)
function saveTopicsResults()
{
  topicsString="";
  debug="";
  curGroup="";

  //itterate through all checkboxes in each group

  var allCBs = document.getElementsByTagName("input");
  for(j=0;j<allCBs.length;j++)
  {
   //debug=debug+"-here."+j
   if (allCBs[j].getAttribute("type")=="checkbox")
   {
     if(allCBs[j].checked==true)
     {

      nextGroup=allCBs[j].getAttribute("group");

      if(nextGroup!=curGroup)
      {
        if((curGroup!=null)&&(curGroup.length!=0))
        {
          var allTAs = document.getElementsByTagName("textarea");         
          for(i=0;i<allTAs.length;i++)
          {
           //alert(allTAs[i].getAttribute("group"));
           if(allTAs[i].getAttribute("group")==curGroup)
           {
            //alert(allTAs[i].id);
            topicsString=topicsString+","+allTAs[i].id+"#("+allTAs[i].value+")";
           }
          }
          topicsString=topicsString+"[END:"+curGroup+"]";
        }
        curGroup=nextGroup;
        topicsString=topicsString+"[START:"+curGroup+"]";
      }
      topicsString=topicsString+","+allCBs[j].value;
     }
    }
   }





 //redundant code, needs to be cleaned up... used to get last "yourcorner" text box values
          var allTAs = document.getElementsByTagName("textarea");         
          for(i=0;i<allTAs.length;i++)
          {
           //alert(allTAs[i].getAttribute("group"));
           if(allTAs[i].getAttribute("group")==curGroup)
           {
            //alert(allTAs[i].id);
            topicsString=topicsString+","+allTAs[i].id+"#("+allTAs[i].value+")";
           }
          }

   topicsString=topicsString+"[END:"+curGroup+"]";

  //create a comma separated list of checked values for each group
  //add the "your corner" info into the lists
  //alert(topicsString+"__debug:"+debug);
  //alert(topicsString);
  return topicsString;
}

function saveIntroResults()
{
  introString="#pflName:"+document.getElementById("pflName").value+"#";
  introString=introString+"#pflDate:"+document.getElementById("pflDate").value+"#";
  introString=introString+"#pflAge:"+document.getElementById("pflAge").value+"#";
  introString=introString+"#pflGrade:"+document.getElementById("pflGrade").value+"#";

//favourite section
 cbpflIntroMath=document.getElementById("cbpflIntroMath").checked;
 cbpflIntroRead=document.getElementById("cbpflIntroRead").checked;
 cbpflIntroWrite=document.getElementById("cbpflIntroWrite").checked;
 cbpflIntroScience=document.getElementById("cbpflIntroScience").checked;
 cbpflIntroSS=document.getElementById("cbpflIntroSS").checked;
 cbpflIntroOth=document.getElementById("cbpflIntroOth").checked;

 
   introString=introString+"#FavSubj:(cbpflIntroMath-"+cbpflIntroMath+"-Math)(cbpflIntroRead-"+cbpflIntroRead+"-Reading)(cbpflIntroWrite-"+cbpflIntroWrite+"-Writing)(cbpflIntroScience-"+cbpflIntroScience+"-Science)(cbpflIntroSS-"+cbpflIntroSS+"-Social Studies)(cbpflIntroOth-"+cbpflIntroOth+")#";
 
  introString=introString+"#inptPFLSubjFavOther:"+document.getElementById("inptPFLSubjFavOther").value+"#";

 return introString;
}


//pfl selection counts
function setPartSel(sectionID)
{
  curRBGroup="";
  qResults="";
  qStrats="";
  qLikeDislike="";


  var allInputs = document.getElementsByTagName("input");
  var allRBs = new Array();
  //build radio buttons only
  for(r=0;r<allInputs.length;r++)
  {
   if (allInputs[r].getAttribute("type")=="radio")
   {
    allRBs.push(allInputs[r]);
   }
  }

  //get info from group
  for(j=0;j<allRBs.length;j++)
  {
    nextRBGroup=allRBs[j].getAttribute("name");
    if (curRBGroup!=nextRBGroup){curRBGroup=nextRBGroup;}
    questResult=checkRBValue(curRBGroup);

    qResults=qResults+","+questResult[0]; //startrs with a ',' so index will start at one when split by a ','
    qStrats=qStrats+","+questResult[2];
    j=j+questResult[1]-1;
  }



  qLikeDislike=qLikeDislike+",";
  //get likes and dislikes
  for(qIndex=1;qIndex<=2;qIndex++)
  {
   likeID="pflP0"+sectionID+"LikeBest0"+qIndex;
   dislikeID="pflP0"+sectionID+"LikeLeast0"+qIndex;

   qLikeDislike=qLikeDislike+","+likeID+":"+document.getElementById(likeID).value;
   qLikeDislike=qLikeDislike+","+dislikeID+":"+document.getElementById(dislikeID).value;
  }
  //alert(qLikeDislike);
 return [qResults,qStrats,qLikeDislike];
}

function checkRBValue(rbGroup)
{
  qVal="";
  rbObjLen=0;
  stratids="";
  
  curRBGroupObj=document.getElementsByName(rbGroup);
  rbObjLen=curRBGroupObj.length; 
  for (i = 0; i < curRBGroupObj.length; i++) 
  {
   if(curRBGroupObj[i].checked)
   {
    qVal=curRBGroupObj[i].value;
    if(qVal=="SA"){stratids=curRBGroupObj[i].getAttribute("stratids");}
    break;
   }
  }
  return  [qVal,rbObjLen,stratids];
}



function toogleBetweenDivs(divID1,divID2)
{
 toogleDiv(divID1);
 toogleDiv(divID2);
}

</script>




<script >
	//window.onload=function(){testRef();}
   
</script>

<div id="surveyRoot" style="position:relative; left:30px;top:-2px;align:center;">

<style>
   #surveyNav td{padding:3px;vertical-align:middle;border-width:2px;border-style:outset;width:70px;text-align:center;background-color: #E8E9EA;font-size:10pt;}
</style>

<?php 
 $curPart=setCurPart();
 if($curPart==6){$curPart='An';}
 if($curPart==7){$curPart='Sum';}
 if($curPart==8){$curPart='DrS';}
 //echo $curPart;
 echo '<style>';
 echo '#surveyNav #navP'.$curPart.' {background-color: rgb(250, 253, 240); border-style: inset;}'; 
 echo '</style>';
?> 	

<span style="color:red;font-size:14pt;">POSSIBILITIES FOR LEARNING</span><br>
<table width="700px;">
 <tr>
  <td>
   <span style="font-size:10pt;">Lannie Kanevsky, Ph.D.<br>&copy; 2011 - Version 3</span>	
   <br><br>
  </td>
  <td style="text-align:right;">
   <div style="text-align:right;">
    <!--button>Print</button-->            
    <button onclick="savePFLSurveyData();">Save</button>            
    <button onclick="loadPFLSurveyData();">Load</button>   
    <button onclick="toogleDiv('printSelBox');">Print</button>

   </div>
  </td>
 </tr>
</table>
<div id="printSelBox" style="display:none; position:absolute; z-index:1;top:30px;left:375px;width:300px; border:2px solid black; background-color:white;padding:20px;">
 Please select the part of the survey that you would like to print.<br><br>
    <select id="surveyPrintSelect">
      <option>Full Survey</option>
      <!--option>Analysis by Strategy</option-->
      <option>Summary Sheet</option>
      <option>Dream Sheet</option>
    </select><br><br>         
    <div style="text-align:right;">
     <button onclick="printPFLSurvey()">Print</button>
     <button  onclick="toogleDiv('printSelBox');">Cancel</button>
    </div>
</div>
<form id="surveyNavForm" name="surveyNavForm" method="post" action="">
<!--form id="surveyNavForm" name="surveyNavForm" method="post" action="./?page_id=421"-->
<input type="hidden" name="pflSurveyPage" id="pflSurveyPage" value="set">

<?php 
 $curPart=setCurPart();
 //echo $curPart;
 $prevPart=intval($curPart)-1;
 $nextPart=intval($curPart)+1;
 echo '<input type="hidden" name="prevPart" id="prevPart" value="'.$prevPart.'">';
 echo '<input type="hidden" name="nextPart" id="nextPart" value="'.$nextPart.'">';
 echo '<input type="hidden" name="selAct" id="selAct" value="">';
?>

 <div id="pflSurveyAnalysisDiv" style="padding:10px;border-collapse: collapse; border: 0px solid black; position:absolute; top:65px; left: 525px; width:350px">
<table>
  <tr><th colspan=2> <u><b>Survey Progress</b></u></th></tr>
  <tr>
   <td><table id="survProg">
<?php
  $partsAry=array("Introduction","Part 1: Settings for Learning", "Part 2: Ideas to Learn", "Part 3: Ways to Learn","Part 4: Showing Your Learning","Part 5: Lists of Possibilities" );
  for($pIndex=0;$pIndex<count($partsAry);$pIndex++)
  {
   echo '<tr><td>';

   $isChecked="";
   if(isset($_POST['p'.$pIndex.'stat'])&&($_POST['p'.$pIndex.'stat']=="1")){$isChecked="checked";}
   echo '<input type="checkbox" id="p'.$pIndex.'status" name="p'.$pIndex.'status" disabled="true" '.$isChecked.'>';

    $setLastViewed="";
    $lastViewStyle="";
    if(isset($_POST['lastViewedPart'])&&($_POST['lastViewedPart']==$pIndex)&&($isChecked==""))
    {
	$setLastViewed = '<img height="15px" src="/wp.images/page.pflSurvey/last.page.png">';
	$lastViewStyle = 'style="color:red;"';
    }

   $curPart=setCurPart();
   if(($isChecked!="")||($setLastViewed!=""))
   {
	echo $setLastViewed.'<a href="javascript:jumpToSurvey('.$pIndex.','.$curPart.');" '.$lastViewStyle.'>'.$partsAry[$pIndex].'</a>';
   }
   else{echo $partsAry[$pIndex];}
   

   echo '</input>';
   echo '</td></tr>';
  }

?>
</table></td>
<td>
  <table style="border: 1px solid blue; font-size:10pt;padding:5px;">	
 <?php
 $curPart=setCurPart();
 $linkStyle="";
 if(!surveyComplete()){$linkStyle='style="pointer-events: none;opacity: 0.5;"';}

 //echo '<tr><td><a href="javascript:jumpToSurvey(6,'.$curPart.');" id="surveyAnalysisLink" '.$linkStyle.'>Analysis by Strategy</a></td></tr>';	
 echo '<tr><td><a href="javascript:jumpToSurvey(7,'.$curPart.');" id="surveySummaryLink"  '.$linkStyle.'>Summary Page</a></td></tr>';	
 echo '<tr><td><a href="javascript:jumpToSurvey(8,'.$curPart.');" id="surveyDreamLink"  '.$linkStyle.'>Dream Sheet</a></td></tr>';	
?>

</table></td>
 </tr></table>

 </div>

<table>
<tr><td>
 <table id="surveyNav"><tr>
  <tr>
<?php
   $curPart=setCurPart(); 
   $navAry=array("My Info","Part #1","Part #2","Part #3","Part #4","Part #5");
   for($n=0;$n<count($navAry);$n++)
   {
     $extraStyle="";
     if(isset($_POST['lastViewedPart'])&&($_POST['lastViewedPart']==$n)){$extraStyle="color:red;";}

     if(isset($_POST['p'.$n.'stat'])&&($_POST['p'.$n.'stat']=="1"))
     {
      echo '<td id="navP'.$n.'" style="font-size:10px;"><a href="javascript:jumpToSurvey('.$n.','.$curPart.');" style="display:block;">'.$navAry[$n].'</a></td>';
     }
     else{echo '<td id="navP'.$n.'" style="font-size:10px;'.$extraStyle.'">'.$navAry[$n].'</td>';}
   }
?>

   <!--td id="navPAn">Analysis</td>
   <td id="navPSum">Summary</td>
   <td id="navPDrS">Dream Sheet</td-->
  </tr>
 </table>
</td>
<!--td width="15px">
</td-->
<!--td align="right"-->

<!--/td-->
</tr>
</table>
 <div id="mainSurveyInfo">
 <br>
<?php
  //buildNavButtons(0,8);
  //buildNavButtons(0,5);
  $curPart=setCurPart(); 
  if(($curPart=='6')||($curPart=='7')||($curPart=='8'))
  {
   $prevSurvPart=0; 
   if(isset($_GET['prevPart'])){$prevSurvPart=$_GET['prevPart'];}
   //echo '<button onclick="returnToSurvey('.$prevSurvPart.');">Return to Survey</button>';
  }
  else{buildNavButtons(0,5);}

  $curPart=setCurPart();
  //if($curPart){}
?>
<br> 
<div id="surveyPartInstructions" style="width:800px;">
<?php
  echo buildSurveyInstructions('./wp.static/pfl.survey.partsInstructions.txt');
?>
</div>
<br>
  <div id="surveyPartQuestions">
    <?php
     $curPart=setCurPart(); 
     if($curPart==0){buildoutIntro();}
     elseif($curPart==5){buildoutTopics('./wp.static/pfl.lists.txt');}
     elseif($curPart==6){buildoutAnalysis('./wp.static/pfl.survey.codes.txt','./wp.static/pfl.questions.txt');}
     elseif($curPart==7){buildoutSummary('./wp.static/pfl.questions.txt');}
     elseif($curPart==8){buildoutDreamSheet('./wp.static/pfl.questions.txt','./wp.images');}
     else{buildoutQuestions($curPart,'./wp.static/pfl.questions.txt');}

    ?>
  </div>
  </div>
<?php
  $curPart=setCurPart(); 
  if(($curPart!='6')&&($curPart!='7')&&($curPart!='8')){ buildNavButtons(0,5);}
  buildHiddenSaveElements();
?>
</form> 


</div>




<!-- END OF HTML PAGE -->
<?php
function surveyComplete()
{
  $partsComplete=0;
  for($i=0;$i<6;$i++)
  {
   if(isset($_POST['p'.$i.'stat'])&&($_POST['p'.$i.'stat']=="1")){$partsComplete=$partsComplete+1;}
  }
  if($partsComplete>=6){return true;}
  return false;
}

?>