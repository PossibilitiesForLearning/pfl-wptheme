<?php /* Template name: Differentiation Strategy Guide */ ?>
<?php
/**
 * The template for displaying all pages.
 * This is a template specifically to work with the pfl differentation strategy guide
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>


<?php 
	include_once('./wp.custom.src/xmlfuncs.php');
	include_once('./wp.custom.src/pfl.php');





?>
<link rel="stylesheet" href="./wp.custom.css/brDefaults.css" type="text/css">
<link rel="stylesheet" href="./wp.custom.css/defaulten.css" type="text/css">

<link rel="stylesheet" href="./wp.custom.css/nifty.corners.css" type="text/css">
<link rel="stylesheet" href="./wp.custom.css/nifty.corners.print.css" type="text/css" media="print">
<link rel="stylesheet" href="./wp.custom.css/pfl.css" type="text/css">

<script type="text/javascript" src="./wp.custom.src/nifty.corners.js"></script>	
<script type="text/javascript" src="./wp.custom.src/diffStratGuide.js"></script>

<style>
.diffStratsTitles{position:relative;left:0;top:0;}
.diffStratsDesc
                  {
                  z-index:1;
                  padding:20px;
                  background-color:#666666;
                  color:white;
                  width:200px;
                  position:absolute;
                  left:10;
                  top:100;
                  display:none;
                  }

#indicHeaders{padding:5px;color:white;background-color:#666666;}
#diffMatrixTable{border-width: 0px; border-style: solid; border-collapse: collapse;}
#diffMatrixTable td{border-width: 1px; border-style: solid; text-align: center; }

</style>


<script >
	window.onload=function(){
		//if(!NiftyCheck()) return;

		//RoundedTop("div#diffActInstrTitle","#FFF","#91A7E3");
		//RoundedBottom("div#diffActInstrText","#FFF","#E0D6DF");

		fakeMouseOver("div", "class","diffStratsTitles");
		
		checkForLoadedValues();
		guideEngine();
	}
</script>

<div id="fullpage" style="position:relative; left:10px;top:-30px;">
  <div id="audType" style="position:absolute;top:20px;">
	<?php
		if($_GET['aud']!="stud")
		{
		 echo '<form name="frmSaveDiffGuide" method="post" action="./?page_id=191&aud=stud" >';
		 echo '  <input type="submit" value="Switch to Student Version">';
		 echo '</form>';
		}
		else
		{
		 echo '<form name="frmSaveDiffGuide" method="post" action="./?page_id=191" >';
		 echo '  <input type="submit" value="Switch to Teacher/Parent Version">';
		 echo '</form>';
		}

	?>
  </div>
  <div id="saveInfo" style="position:absolute; left:770px;top:20px;">
	
	<!--form name="frmSaveDiffGuide" method="post" action="http://localhost/pflwp/?page_id=407" target="_blank" -->
	<form name="frmSaveDiffGuide" method="post" action="http://possibilitiesforlearning.com/?page_id=1287" target="_blank">
	<input type="submit" value="Save">
	<input type="hidden" id="saveSelBehav" name="saveSelBehav" value="">
	<input type="hidden" id="saveDemog" name="saveDemog" value="">
	</form>
	
 </div>
 <div id="loadInfo" style="position:absolute; left:830px;top:20px;">
	
	<!--form name="frmLoadDiffGuide" method="post" action="http://localhost/pflwp/?page_id=394"-->
	<form name="frmLoadDiffGuide" method="post" action="http://possibilitiesforlearning.com/?page_id=1279">
	<input type="submit" value="Load">
	</form>
	<?php
	$loadedFile=$_POST["loadedDGFile"];
	$loadedSelections="";
	$loadedDemographics="";
	//echo "here!!!!".$loadedFile;

	if(isset($loadedFile))
	{
	//echo "here2!!!";		  
	 $loadedData = file($loadedFile);		  
	 $loadedSelections=rtrim($loadedData[0]);
	 $loadedDemographics=rtrim($loadedData[1]);
	 unlink($loadedFile);
         //echo "<br>here3!!!:".$loadedFile."<br>".$loadedData[0];
	}
	echo '<input type="hidden" id="loadedSelBehav" name="loadedSelBehav" value="'.$loadedSelections.'">';
	echo '<input type="hidden" id="loadedDemog" name="loadedDemog" value="'.$loadedDemographics.'">';
	?>
 </div>
<form name="frmDiffGuide" method="post" action="./ext.print/diffActGuide.print.php"  target="_blank" > 
<br><br><br>
<font style="font-size:13pt;"><b>Guide for Selecting Differentiation Strategies for High Ability Learners</b></font>

<div id="printInfo" style="position:absolute; left:710px;top:20px;">
<input type="submit" value="Print">
</div>

<div style="position:relative; left:-0px; top: -50px;" z-index="0">
<?php
//$directions=file_get_contents('http://possibilitiesforlearning.com/?page_id=1270');
//echo $directions;

		if($_GET['aud']!="stud")
		{
                  echo loadUrl_get_contents("./wp.static/pfl.diffGuideAdult.Instructions.txt"); 
                }
		else
		{
                  echo loadUrl_get_contents("./wp.static/pfl.diffGuideStud.Instructions.txt"); 
                }
   
//echo $fcontents;  
?>
</div>

<?php
 if($_GET['aud']!="stud")
 { 
  echo '<div style="position:absolute; left:750px; top: 570px;" z-index="0"><img width="170px" src="./wp.images/page.diffStratGuide/schoolsupplies.jpg"  ></div>';
 }
 else
 { 
  echo '<div style="position:absolute; left:750px; top: 420px;" z-index="0"><img width="170px" src="./wp.images/page.diffStratGuide/schoolsupplies.jpg"  ></div>';
 }
?>

<div id="divIndicatorGuide">
<table width="725px">
<tr>
	<td>Name: <input type="text" name="curname" id="curname" maxlength="50" onchange="saveDemographics()"/></td>	
	<td>Grade: <input type="text" name="curgrade" id="curgrade" maxlength="50" onchange="saveDemographics()"/>
	<td>Date: <input type="date" name="curdate" maxlength="50" onchange="saveDemographics()"/></td>
	<input type="hidden" name="topRankList" id="topRankList" value="'.$hiddenResList.'"></td>		
</tr>
<tr>
	<td colspan="3"><br>
<?php
 if($_GET['aud']!="stud"){ echo 'Strengths:';}
 else{ echo 'Things you LOVE to learn about:';}
?>
        <br><textarea rows="4" cols="75" name="curinterests" id="curinterests" onchange="saveDemographics()"></textarea></td>
</tr>
<?php
		if($_GET['aud']!="stud")
		{
                  echo'<tr><td colspan="3"><br>Dates and descriptions of activities observed:<br><textarea rows="4" cols="75" name="curactivities" id="curactivities" onchange="saveDemographics()"></textarea></td></tr>';
		}
                else
                {
                  echo'<tr><td colspan="3"><input type="hidden" name="curactivities" id="curactivities" value="studIgnore"></td></tr>';
                }
?>
</table>


<table id="diffMatrixTable" width="900px"  border="1px" >
<tr>
	<td valign="bottom" align="center" rowspan="3" width="20px">  </td>
	<td valign="bottom" align="center" rowspan="3" ><b>Behaviors</b><br><br></td>
	<td align="center" colspan="22"><b>Differentiation Strategies</b></td>
</tr>
<tr>
	<td colspan="7" align="center">Content</td>
	<td colspan="10" align="center">Process</td>
	<td colspan="5" align="center">Product</td>
</tr>
<tr>

<?php loadDiffStrats("bottom",$_GET['aud']); ?>
								
</tr>


<?php 
$matrixInfoAry=loadDiffChars($_GET['aud']);
$indListCBs=$matrixInfoAry[0];
$indCellList=$matrixInfoAry[1]; 
echo '<tr><td></td><td style="text-align:right;" valign="top">';
echo '<b>Rank:</b> </td>';
$hiddenResList=buildResultsBar($_GET['aud']); 					
echo '</tr>';
echo '<tr><td colspan="24"><input type="hidden" name="hiddenCBlist" id="hiddenCBlist" value="'.$indListCBs.'">';
echo '<input type="hidden" name="hiddenIndInfolist" id="hiddenIndInfolist" value="'.$indCellList.'">';
echo '<input type="hidden" name="hiddenResList" id="hiddenResList" value="'.$hiddenResList.'"></td></tr>';
?>


</table>
<br><br><br><br>
</div>
<textarea id="diffGuideTableString" name="diffGuideTableString" style="display:none;">&nbsp;</textarea>
</form>
</div>

<!-- END OF HTML PAGE -->


<?php

	function buildResultsBar($audType) 
	{
		if($audType=="stud"){$diffIndDOC=loadXMLDoc("./wp.static/indicator.matrix.kids.xml");}
		else{$diffIndDOC=loadXMLDoc("./wp.static/indicator.matrix.xml");}
		
		$diffRootNode=$diffIndDOC->getElementsByTagName( "DIFFERENTIATION" )->item(0);
		$diffNode=$diffRootNode->getElementsByTagName( "DIFFOPT" );

		$hiddenResList=buildResultsBarPerType("content",$diffNode);		
		$hiddenResList=$hiddenResList.buildResultsBarPerType("process",$diffNode);
		$hiddenResList=$hiddenResList.buildResultsBarPerType("product",$diffNode);	
		return $hiddenResList;
		
	}

	function buildResultsBarPerType($diffType,$diffNode)
	{
		$list="";	
		foreach( $diffNode  as $curDiff )
		{
			
			$type=getXMLAttrib($curDiff,"type");
			if($type==$diffType)
			{		
				$id='result'.getXMLAttrib($curDiff,"id");
				$indicators=getXMLAttrib($curDiff,"indicators");	
				$title=padText(getXMLAttrib($curDiff,"title"),"<br>");
				$img=getXMLAttrib($curDiff,"img");										
				echo '<td valign="top" id="resCell'.$id.'" align="center" width="5px" style="font-size:8pt;">';				
				echo '<span indicators="'.$indicators.'" id="'.$id.'" >&nbsp;</span>';				
				echo '<span id="resTitle'.$id.'" style="display:none;" ></span>';
				echo '</td>';								
				$list=$list.','.$id;		
			}	
				
		}
		return $list;		
	} 


	function loadDiffStrats($align,$audType) 
	{
		
		if($audType=="stud"){$diffIndDOC=loadXMLDoc("./wp.static/indicator.matrix.kids.xml");}
		else{$diffIndDOC=loadXMLDoc("./wp.static/indicator.matrix.xml");}		
		
		
		$diffRootNode=$diffIndDOC->getElementsByTagName( "DIFFERENTIATION" )->item(0);
		$diffNode=$diffRootNode->getElementsByTagName( "DIFFOPT" );
		
		//echo '<td>test</td>'	;
		diffStratsList("content",$diffNode,$align);
		diffStratsList("process",$diffNode,$align);
		diffStratsList("product",$diffNode,$align);				

	}

	function diffStratsList($diffType, $diffNode, $align)
	{
		
		foreach( $diffNode  as $curDiff )
		{

			$type=getXMLAttrib($curDiff,"type");
			if($type==$diffType)
			{		

				$rootWPURL="http://possibilitiesforlearning.com/?page_id=";
				$id='result'.getXMLAttrib($curDiff,"id");				
				$title=getXMLAttrib($curDiff,"title");
				$img=getXMLAttrib($curDiff,"img");
				$desc=getXMLAttrib($curDiff,"description");
				$txtRefPageId=getXMLAttrib($curDiff,"refid");

				echo '<td width="25px" id="stratTitle'.$id.'">';
				echo '<div class="diffStratsTitles"';
				//echo 'onmouseover="showStratDesc(\'divStratDesc'.$id.'\');"';
				//echo 'onmouseout="toogleDiv(\'divStratDesc'.$id.'\')"';
				echo '>';
				echo '<a href="'.$rootWPURL.$txtRefPageId.'" target="_blank">';
				echo '<img width="25px" height="100"src="'.$img.'" ';
				echo 'onmouseover="showStratDesc(\'divStratDesc'.$id.'\');"';
				echo 'onmouseout="toogleDiv(\'divStratDesc'.$id.'\')"';
				//echo 'onclick="toogleDiv(\'divStratDesc'.$id.'\')"';
				echo '>';
				echo '</a>';
				echo '<div class="diffStratsDesc" id="divStratDesc'.$id.'">'.$desc.'</div>';				
				echo '</div>';
				echo '</div>';
				echo '</td>';

			}	
				
		}
	}

	function padText($text, $padVal)
	{
		$strAry=str_split($text);
		$paddedResult="";
		foreach($strAry as $char)
		{
			$paddedResult=$paddedResult.$char.$padVal;
		}
		return $paddedResult;
	}

	function loadDiffChars($audType)
	{
		
		if($audType=="stud"){$diffIndDOC=loadXMLDoc("./wp.static/indicator.matrix.kids.xml");}
		else{$diffIndDOC=loadXMLDoc("./wp.static/indicator.matrix.xml");}				
		
		//$diffIndDOC=loadXMLDoc("./wp.custom.src/indicator.matrix.xml");
		$indRootNode=$diffIndDOC->getElementsByTagName( "INDICATORS" )->item(0);
		$indNode=$indRootNode->getElementsByTagName( "INDICATOR" );		

		$diffRootNode=$diffIndDOC->getElementsByTagName( "DIFFERENTIATION" )->item(0);
		$diffNode=$diffRootNode->getElementsByTagName( "DIFFOPT" );

		$indListCBs="";
		$indCellList="";
		foreach( $indNode  as $curInd )
		{

			$id=getXMLAttrib($curInd,"id");
			$title=getXMLAttrib($curInd,"title");
			$desc=getXMLAttrib($curInd,"description");
			echo '<tr>';
			echo '<td align="center"><input  type="checkbox" onclick="guideEngine();" name="cbInd'.$id.'" id="cbInd'.$id.'"  value="'.$id.'" /></td>';
			echo '<td width="125px" style="padding:3px;text-align:left;"><div onmouseover="toogleDiv(\'divIndDesc'.$id.'\')" onmouseout="toogleDiv(\'divIndDesc'.$id.'\')"  style="position:relative;left:0;top:0;"><b><span ><font style="font-size:9pt;">'. $title.'</font></span></b>';
			echo '<div id="divIndDesc'.$id.'" style="z-index:1;padding:5px; background-color:#666666; color:white; width:700px; position:absolute; left:0;top:0;display:none;">'.$desc.'</div>';
			echo '</div></td>';
						
			
			$indListCBs=$indListCBs.',cbInd'.$id;
			
			foreach( $diffNode as $curDiff)
			{
				$inds=getXMLAttrib($curDiff,"indicators");
				$diffsId=getXMLAttrib($curDiff,"id");
				$bgcolor="white";
				$cellInfo="&nbsp;";
				if(inStr ($id, $inds))
				{
					$bgcolor="#ffffcc";
					$insertID=true;
					$cellInfo="x";
				}
				echo '<td width="2px" height="25px" align="center" style="background-color:'.$bgcolor.';" id="cell'.$diffsId.$id.'id">';
								
				if($insertID)
				{
					echo '<input type="hidden" id="cell'.$diffsId.$id.'" name="cell'.$diffsId.$id.'" value="cbInd'.$id.'">';
					$indCellList=$indCellList.',cell'.$diffsId.$id;
					
				}					
				echo $cellInfo.'</td>';
			}

			echo '</tr>';		
		}
		return array($indListCBs,$indCellList) ;	
	}

function inStr ($needle, $haystack) 
{ 
  $needlechars = strlen($needle); //gets the number of characters in our needle 
  $i = 0; 
  for($i=0; $i < strlen($haystack); $i++) //creates a loop for the number of characters in our haystack 
  { 
    if(substr($haystack, $i, $needlechars) == $needle) //checks to see if the needle is in this segment of the haystack 
    { 
      return TRUE; //if it is return true 
    } 
  } 
  return FALSE; //if not, return false 
}  

////////////////////////



?>
