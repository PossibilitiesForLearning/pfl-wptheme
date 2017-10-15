<?php /* Template name: Downloads */ ?>
<?php
/**
 * The template for displaying available pfl download files.
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
#dlTable{width:720px; border-collapse: collapse; border: 1px solid black;}
#dlTable th{ border: 1px solid black; text-align: center; padding: 10px; vertical-align:middle;}
#dlTable td{ border: 1px solid black;  padding: 10px;}
#dlQuickLinks{position: fixed;  z-index: 9999; width:100%; float:right; top:0px; background-color:#ff9900; font-size:12px;}
#dlQuickLinks li{ width:auto;}
</style>


<script >
	window.onload=function(){}
</script>


<div style="position: relative; left:-100px; top: -50px;">
   <?php
   //echo loadUrl_get_contents("http://possibilitiesforlearning.com/?page_id=1304"); 
   ?>
</div>

<div id="downloadsRoot" style="position:relative; left:30px;top:-2px;align:center;">

<table id="dlTable">

<?php


$lineCleanupAry=array("\n", "\r", "\r\n");

 $dlsInfoRaw="";//loadUrl_get_contents("http://possibilitiesforlearning.com/?page_id=1274");
 $mainRootURL="http://www.sfu.ca/~kanevsky/PFL2/";
 $dlAry = explode("\n", $dlsInfoRaw);
 $titleLinks="<u><b>Quick Links:</b></u><br>";
 $groupInit=0;
 
 foreach( $dlAry as $curDL )
 {
   $workingStr=str_replace(array("\r\n", "\r"), "\n", $curDL);
   $cleanLine=str_replace($lineCleanupAry , "", $workingStr);
   $curDLLine=trim(str_replace("\r\n","",$cleanLine)," ");
   if(strlen($curDLLine)>0)
   {
	if(substr_count($curDLLine,"[TITLE:")>0)
	{
		$initpos=strpos($curDLLine, "[TITLE:")+7;
		$finpos=strpos($curDLLine, "]");
		$grpTitle=substr($curDLLine, $initpos, $finpos-$initpos);
		$grpTitleTagName=str_replace(" " , "", $grpTitle);
		echo "<tr><th colspan='2'><a name='".$grpTitleTagName."'></a>".$grpTitle."</th></tr>";
		$titleLinks=$titleLinks."<li><a href='#".$grpTitleTagName."'>".$grpTitle."</a></li>";
		$groupInit=1;
	}
	elseif(substr_count($curDLLine,"[GRPEND]")>0)
	{
 		$groupInit=0;
	}
	else
	{
		if($groupInit==1)
		{
	         $curDLFileInfo=explode("[",$curDLLine);	
		 $fileName=str_replace("]" , "", $curDLFileInfo[1]);
		 $fileUrl=trim($mainRootURL.$fileName," ");
		 $fileDesc=str_replace("]" , "", $curDLFileInfo[2]);

		 echo "<tr><td><a href='".$fileUrl."' target='_blank'>".$fileName."</a></td><td>".$fileDesc."</td></tr>";
		}
	}

   }

 }

//echo '<div id="dlQuickLinks"><ul>'.$titleLinks.'</ul></div>';


?>
</table>
</div>

<!-- END OF HTML PAGE -->



