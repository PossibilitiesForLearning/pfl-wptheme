<?php

/*Simple Test Function*/
function testPFL()
{
		  echo 'hello PFL';
}


/* Supporting Functions */
function loadURLFromCurl($Url)
{
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


function loadUrl_get_contents($url) {
	//return $url;
    /*$ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;*/
	return file_get_contents($url);
	//return "";
}


/* Materials Div Formatting Functions */
function loadMaterials($materialsIdPath)
{
	$doc = new DOMDocument();
	$doc->load($materialsIdPath);  
	$matNodes=$doc->getElementsByTagName( "MAT" );
	foreach( $matNodes as $curMat )
	{
			$isBold=false;  
			if	($curMat->getAttributeNode("bold")->value=="true")
			{
				$isBold=true;  		  
			}  
		$curMatStr=$curMat->getAttributeNode("info")->value;
		$apaChunks=splitStringForAPA($curMatStr, 85);
		buildHTMLAPARef($apaChunks, $isBold );
		
	}
}

function splitStringForAPA($inptStr, $maxLen)
{
	if(strlen($inptStr)<=$maxLen)
	{
		 return array($inptStr, '&nbsp;');	  
	}
	$wordSplit=explode(" ", $inptStr);
	$firstLineDone=false;
	$line01="";
	$line02="";
	
	for($i = 0; $i < sizeof($wordSplit); ++$i)
	{
			  if(!$firstLineDone)
			  {
			  			 if(strlen($line01)<=$maxLen)
			  			 {
			  			 			$line01=$line01." ".$wordSplit[$i];
			  			 }
			  			 else
			  			 {
			  			 	$firstLineDone=true;
			  			 }
			  }
			  else
			  {
			  		$line02=$line02." ".$wordSplit[$i];	 
			  }
	}
	if(!$firstLineDone){$line02="&nbsp;";}
	
   return array($line01, $line02);
}

function buildHTMLAPARef($apaRef, $isBold)
{
	echo '<br>';
	echo '<table>';
	
	echo '<tr>';
	echo '<td colspan="2">';
	if($isBold){echo '<b>';}
	echo 	$apaRef[0];
	if($isBold){echo '</b>';}
	echo '</td>';
	echo '</tr>';
		
	echo '<tr>';
	echo '<td width="30px">&nbsp;</td>';
	echo '<td>';
	if($isBold){echo '<b>';}
	echo $apaRef[1];
	if($isBold){echo '</b>';}
	echo '</td>';
	echo '</tr>';
	echo '</table>';	
}


/* Reference Notes Functions  for chapter text (not for the print page)*/
function loadReference($refId,$isPrint)
{
		  if($isPrint=="print")
		  {
		  		echo '<sup><b>'.$refId.'</b></sup>';
		  		buildPrintRefs($refId);
		  }
		  else
		  {
		  			 buildInLineRefs($refId);
		  }
}

function buildPrintRefs($refId)
{
	$doc = new DOMDocument();
	$doc->load('./static/endnotes.xml');
	$enNodes=$doc->getElementsByTagName( "endnote" );
	$refContent=getRefContent($enNodes,$refId);
		  
		  echo '<span id="refsPrintHidden" class="refsPrintHidden">'.$refId.'. ';
		  echo $refContent;
		  echo '<br></span>';	
}

function buildInLineRefs($refId)
{
	$doc = new DOMDocument();
	$doc->load('../../static/endnotes.xml');
	
	$enNodes=$doc->getElementsByTagName( "endnote" );
	$refContent=getRefContent($enNodes,$refId);
	buildHTMLEndNote($refContent, $refId);		  
}

function getRefContent($enNodeList,$enId)
{
		  	foreach( $enNodeList as $curEN )
		  	{  
		  			  if	($curEN->getAttributeNode("id")->value==$enId)
		  			  {
		  			  			 return $curEN->getAttributeNode("content")->value;
		  			  }  		
		  	}
		  	return "unknown reference ID";
}

function buildHTMLEndNote($refContent, $refId)
{
		  echo '<span class="endnoteparent" id="span_en_'.$refId.'"';
		  echo ' onmouseover="showEndNote(this.id);"';
		  echo ' onmouseout="hideEndNote(this.id);">';
		  
		  echo '<sup><b>'.$refId.'</b></sup>';
		  
		  echo '<span id="child_span_en_'.$refId.'" class="endnotes">';
		  echo $refContent;
		  echo '</span>';
		  
		  echo '</span>';
		  
}




/*Link Spans for tab generation and preservation*/
function buildTabLink($linkId, $linkText)
{
		  $jsonInputFile="../../static/sections.json";
		  if($_GET["isPrint"]=="print")
		  {
		  			 $jsonInputFile="./static/sections.json";
		  }


						/*{id: '3.0.obsrv.sngl', 
						name:'Single Student Checklist',
						type:'header', chap:'3'}*/
						
		  
	 $jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode(file_get_contents($jsonInputFile), TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);
    
	 $idKey="-1";
	 $nameKey="-1";
	 $chapKey="-1";
    
    
    foreach ($jsonIterator as $key => $val) {
    if(!is_array($val)) 
    {

    			
    			if($key=="id"){$idKey=$val;}
    			if($key=="name"){$nameKey=$val;}
    			if($key=="chap"){$chapKey=$val;}

				if(($idKey!="-1")&&($nameKey!="-1")&&($chapKey!="-1"))
    			{
    					  if($idKey==$linkId)
    					  {
    					  			 //echo '<br>'.$idKey.','.$nameKey.','.$chapKey.'<br>';
    					  			 echo '<span><a href=\'javascript:launchLinkTab( "'.$idKey.'", "'.$nameKey.'", "'.$chapKey.'" )\' >'.$linkText.'</a></span>';
						  }
    					  $idKey="-1";
						  $nameKey="-1";
						  $chapKey="-1";
    					  
    			}
    }
}		  
		  
}


//PFL Survey functions

function loadPFLQuestions($partNum,$countOffset)
{
	$qListStr="";
	$pflDOC=loadXMLDoc("../wp.static/pfl.questions.xml");
	$pflPartNode=$pflDOC->getElementsByTagName( $partNum )->item(0);
	$pflQNode=$pflPartNode->getElementsByTagName("QUESTION");

	$qCount=0;
	foreach( $pflQNode  as $curPFLQ )
	{
		$qCount=$qCount+1;
		$curCbId=$partNum.'_'.$qCount;	
		$qText=getXMLAttrib($curPFLQ,"text");
		$stratids=getXMLAttrib($curPFLQ,"stratids");
		
		$qNum=$qCount+$countOffset;
		//echo '<li style="margin: 10px 0px;">';		
		$qListStr=$qListStr.'<table qnum="'.$qNum.'" qtext="'.$qText.'" ><tr>';
		$qListStr=$qListStr.'<td  width="50px" align="justify">'.$qNum.'</td>';
		$qListStr=$qListStr.'<td  width="200px" align="justify">';
		
		
		$qListStr=$qListStr.'<table class="survQTable">';
		$qListStr=$qListStr.'	<tr>';
		$qListStr=$qListStr.'<td><input type="radio" name="'.$curCbId.'" value="SA"  stratids="'.$stratids.'" id="'.$curCbId.'" onclick="analyzePFL(\''.$curCbId.'\',\''.$partNum.'\');" ></td>';
		$qListStr=$qListStr.'<td><input type="radio" name="'.$curCbId.'" value="A"></td>';
		$qListStr=$qListStr.'<td><input type="radio" name="'.$curCbId.'" value="N"></td>';
		$qListStr=$qListStr.'<td><input type="radio" name="'.$curCbId.'" value="D"></td>';
		$qListStr=$qListStr.'<td><input type="radio" name="'.$curCbId.'" value="SD"></td>';
		$qListStr=$qListStr.'	</tr>';
		$qListStr=$qListStr.'	<tr>';				
		$qListStr=$qListStr.'<td>SA</td>';
		$qListStr=$qListStr.'<td>A</td>';
		$qListStr=$qListStr.'<td>N</td>';
		$qListStr=$qListStr.'<td>D</td>';
		$qListStr=$qListStr.'<td>SD</td>';				
		$qListStr=$qListStr.'	</tr>';			
		$qListStr=$qListStr.'</table>';	
		
		$qListStr=$qListStr.'</td>';
		$qListStr=$qListStr.'<td width="300px">'.$qText.'</td>';
		$qListStr=$qListStr.'</tr></table>'; 
		$qListStr=$qListStr.'</br>';
	}		
	
	return $qListStr;
		
}

function loadPFLOptions($partNum, $secId, $clmnMax)
{
	
	$pflDOC=loadXMLDoc("../wp.static/pfl.questions.xml");
	$pflPartNode=$pflDOC->getElementsByTagName( $partNum )->item(0);
	$pflONode=$pflPartNode->getElementsByTagName("OPTION");
	
	$oCount=0;
	$cellOpen=0;
	$cellClosed=0;
	foreach( $pflONode  as $curPFLO )
	{
		$OText=getXMLAttrib($curPFLO,"value");
		$OSecId=getXMLAttrib($curPFLO,"sid");
		$OId=getXMLAttrib($curPFLO,"id");
		$curCbId=$OSecId.'_'.$OId;	
		
		if($OSecId==$secId)
		{
				  if(($oCount % $clmnMax)==0)
				  {
				  			 echo '<td valign="top" style="padding:10px;">';
				  			 $cellOpen=1;
				  			 $cellClosed=0;				  			 
				  }
				  
				  	echo '<input id="'.$OSecId.'_'.$OId.'" type="checkbox" value="'.$OText.'">'.$OText.'</br>';
				  
				  if(($oCount % $clmnMax)==($clmnMax-1))
				  {
				  			 echo '</td>';
				  			 $cellOpen=0;
				  			 $cellClosed=1;				  			 				  			 
				  }
				  $oCount=$oCount+1;				  
		}
		
	}		
	if(($cellClosed!=1)&&($cellOpen==1)){echo '</td>';}		
}

?>
