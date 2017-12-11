

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

    function firstLoad()
    {
      document.getElementById("pageLoadingDiv").style.display="none";
      document.getElementById("divPFLSurvey").style.display="block";
    }	

	function surveyInit(partsAry)
	{	
	  			  
			  for(i=1;i<partsAry.length;i++)
			  {
			  			 alert(partsAry[i]);
			  			document.getElementById(partsAry[i]).style.display="none";
			  }
			  document.getElementById("cmpl_"+partsAry[0]).style.backgroundColor="#FAFDF0";
			  document.getElementById("cmpl_"+partsAry[0]).style.borderStyle="inset";
			  document.getElementById("curSumNav").value=partsAry[0];
			  
			  document.getElementById("pflSurveyAnalysis").style.display="none";
			  document.getElementById("pflSurveySummary").style.display="none";
			  document.getElementById("pflSurveyDream").style.display="none";
			  clearAllInputs();
			  prepPFLPrintValues();
	}

	function clearAllInputs()
	{
			  var inputElems = document.getElementsByTagName("input");
			  
			  for(i=0;i<inputElems.length;i++)
			  {
			  			 if((inputElems[i].type=="radio")||inputElems[i].type=="checkbox")
			  			 {
			  			 	inputElems[i].checked=false;		
			  			 }
			  			 
			  }
	}
	function nextNav(curNav,inc)
	{
	
		  viewOutputTabs(false,'pflSurveySummary');
		  viewOutputTabs(false,'pflSurveyDream');
		  viewOutputTabs(false,'pflSurveyAnalysis');
			  for(i=0;i<partsAry.length;i++)
			  {
			  			//alert(partsAry[i]+","+partsAry[i+1]);
			  			if(curNav==partsAry[i])
			  			{
			  					  //alert(partsAry[i]+","+partsAry[i+1]);
			  					  
			  					  document.getElementById(partsAry[i]).style.display="none";
			  					  document.getElementById(partsAry[i+inc]).style.display="block";
			  					  if(inc==1)
			  					  {
			  					  			 document.getElementById("cmpl_"+partsAry[i+inc]).style.backgroundColor="#FAFDF0";
			  					  			 document.getElementById("cmpl_"+partsAry[i+inc]).style.borderStyle="inset";
			  					  			 document.getElementById("cmpl_"+partsAry[i]).style.backgroundColor="#66CCFF";
			  					  			 document.getElementById("cmpl_"+partsAry[i]).style.borderStyle="outset";
			  					  			 //document.getElementById("cmpl_"+partsAry[i]).style.borderStyle="inset";			  					  			 
			  					  }
			  					  if(inc==-1)
			  					  {
			  					  			 //document.getElementById("cmpl_"+partsAry[i+inc]).style.backgroundColor="#33FF99";
			  					  			 document.getElementById("cmpl_"+partsAry[i+inc]).style.borderStyle="inset";
			  					  			 document.getElementById("cmpl_"+partsAry[i]).style.borderStyle="outset";
			  					  }
			  					  //document.getElementById("cmpl_"+partsAry[i+inc]).style.borderStyle="inset";
			  					  document.getElementById("curSumNav").value=partsAry[i+inc];		  					  
			  					  scrollTo(0,0);
			  			}
			  			
			  }			  
			  
	}
	
	
	function viewOutputTabs(isShow,outputDivId)
	{

			  if(isShow)
			  {
			  			 curVisNav=document.getElementById("curSumNav").value;//current survey page	
			  			 
			  			 document.getElementById(curVisNav).style.display="none";
			  			 document.getElementById(outputDivId).style.display="block";
			  			 
			  			 document.getElementById("cmpl_"+outputDivId).style.borderStyle="inset";
			  			 document.getElementById("cmpl_"+curVisNav).style.borderStyle="outset";
			  }
			  else
			  {
						 
			  			 document.getElementById(outputDivId).style.display="none";			  			 
			  			 document.getElementById("cmpl_"+outputDivId).style.borderStyle="outset";
			  }			  
			  
	}
	
	


function showAnalysis()
{
		  viewOutputTabs(false,'pflSurveySummary');
		  viewOutputTabs(false,'pflSurveyDream');
		  viewOutputTabs(true,'pflSurveyAnalysis');
}
function showSummary()
{
		  viewOutputTabs(true,'pflSurveySummary');
		  viewOutputTabs(false,'pflSurveyDream');
		  viewOutputTabs(false,'pflSurveyAnalysis');		  
}
function showDream()
{
		  viewOutputTabs(false,'pflSurveySummary');
		  viewOutputTabs(true,'pflSurveyDream');
		  viewOutputTabs(false,'pflSurveyAnalysis');		  
}
	function retToSurveyView(nonSurvDiv)
	{
			  curVisNav=document.getElementById("curSumNav").value;
			  
			  document.getElementById(nonSurvDiv).style.display="none";
			  document.getElementById("cmpl_"+nonSurvDiv).style.borderStyle="outset";
			  
			  document.getElementById(curVisNav).style.display="block";
			  document.getElementById("cmpl_"+curVisNav).style.borderStyle="inset";
	}