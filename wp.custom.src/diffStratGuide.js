//Javascript for the differentiation matrix 
function fakeMouseOver(tagType, identAttr,identVal){}

function toogleDiv(curDiv)
{
   //alert(document.getElementById(curDiv).style.display);
	if(document.getElementById(curDiv).style.display=="block")
	{
		document.getElementById(curDiv).style.display="none";
	}
	else
	{
		document.getElementById(curDiv).style.display="block";
	} 
	
}

function guideEngine()
{	   
		curSelIndsAry=calibrate().split(","); //selected indicators
		//
		//alert(document.getElementById("hiddenResList").value);
		resultsListAry=document.getElementById("hiddenResList").value.split(","); //results row ids
		rankedAry=document.getElementById("hiddenResList").value.split(",");
		
		//alert(resultsListAry.length);
		for(i = 1; i < resultsListAry.length; i++)
		{
			
			curResId=resultsListAry[i];
			curIndList=document.getElementById(curResId).getAttribute("indicators");
			//alert(curIndList);
			totalInds=curIndList.split(';').length;

			totalIndsFound=0;
			//alert(curSelIndsAry.length);
			for(j= 1; j < curSelIndsAry.length; j++)
			{
				
				if(curIndList.indexOf(curSelIndsAry[j]) >=0)//the indicators contain curResId add to total
				{
					totalIndsFound=totalIndsFound+1;
				}					
			}
			
			
			curPerc=Math.round((100*totalIndsFound)/totalInds);
			rankedAry[i]=curPerc;	
		}
		
		rankedAry=rankStrat(rankedAry);
		curRankMax=setRankDisplay(rankedAry,5);
		//alert(curRankMax);
		ranksum=0;
		topRankList="";
		for(k=1;k<rankedAry.length;k++)
		{
			//alert(resultsListAry[k]);
			curRankId=resultsListAry[k];
			document.getElementById(curRankId).innerHTML=rankedAry[k];
			ranksum=ranksum+rankedAry[k];
			if(rankedAry[k] <= curRankMax)
			{
				document.getElementById("resCell"+curRankId).style.backgroundColor="#CCFFCC";
				document.getElementById("resTitle"+curRankId).style.display="block";
				document.getElementById("stratTitle"+curRankId).style.backgroundColor="#CCFFCC";				
				topRankList=topRankList+","+curRankId.replace("result","");
			}
			else
			{
				document.getElementById("resCell"+curRankId).style.backgroundColor="white";
				document.getElementById("resTitle"+curRankId).style.display="none";
				document.getElementById("stratTitle"+curRankId).style.backgroundColor="white";				
			}			
			
		}
		document.getElementById("topRankList").value=topRankList;
		//alert(topRankList);			

		for(k=1;k<rankedAry.length;k++)
		{
			curRankId=resultsListAry[k];			
			if(ranksum==rankedAry.length-1)
			{
				document.getElementById("resCell"+curRankId).style.backgroundColor="white";
				document.getElementById("resTitle"+curRankId).style.display="none";
				document.getElementById("stratTitle"+curRankId).style.backgroundColor="white";
			}				
		}
		
		//alert(document.getElementById("diffMatrixTable").innerHTML);
		
		document.getElementById("diffGuideTableString").innerHTML=document.getElementById("diffMatrixTable").innerHTML;
}


function setRankDisplay(rankedAry,maxDisplay)
{
	
	rankStatsAry=[];


	for (j=1;j<rankedAry.length;j++)
	{
		curRankSum=0;
		for (k=1;k<rankedAry.length;k++)
		{
			if(rankedAry[k]==j){curRankSum=curRankSum+1;}
		}
		rankStatsAry[j]=curRankSum;		
	}	   
	
	/*rankMetrixStr="";
	for (i=1;i<rankStatsAry.length;i++)
	{
		rankMetrixStr= rankMetrixStr + i +":" +rankStatsAry[i] + "\n";
	}
	alert(rankMetrixStr);*/	
	
	defaultRankToDisplay=3; //default to 3
	curRankSum=0;
	for (i=1;i<rankStatsAry.length;i++)
	{
		curRankSum=curRankSum+rankStatsAry[i];
		if(curRankSum==maxDisplay){return i;}		
		if(curRankSum>maxDisplay){return i-1;}						
	}
	return defaultRankToDisplay;
			
}



function rankStrat(stratPercAry)
{
	//alert(stratPercAry.length);
	rankAry=new Array();
	for(i= 1; i < stratPercAry.length ; i++)
	{
		curRank=stratPercAry.length - 1;
		curStartPerc=stratPercAry[i];
		for(j=1;j<stratPercAry.length; j++)
		{
			if(j!=i)
			{
				if(curStartPerc >= stratPercAry[j]){curRank=curRank-1;}
			}	
		}
		rankAry[i]=curRank;
	}
	return rankAry;
	
}
function clearCheckboxes()
{
		  matrixInfoListAry=document.getElementById("hiddenIndInfolist").value.split(",");
		  for(curCBind=1; curCBind < matrixInfoListAry.length; curCBind++)
		  {
					  curCB=document.getElementById(matrixInfoListAry[curCBind]).value;
					  document.getElementById(curCB).checked=false;
					    		     		  
		  }
}
function checkForLoadedValues()
{
	
	//SELECTIONS	  
	checkForLoaded=document.getElementById("loadedSelBehav").value;
	//alert(checkForLoaded); 
	if(checkForLoaded!="")
   {
   		  clearCheckboxes();
   		  //check required checkboxes
   		  loadedMatrixAry=checkForLoaded.split(",");
   		  for(i = 1; i < loadedMatrixAry.length; i++)
   		  {
   		  		//alert(loadedMatrixAry[i]);	 
   		  		matrixInfoListAry=document.getElementById("hiddenIndInfolist").value.split(",");
   		  		for(curCBind=1; curCBind < matrixInfoListAry.length; curCBind++)
   		  		{
					  curCB=document.getElementById(matrixInfoListAry[curCBind]).value;
					  if(document.getElementById(curCB).value==loadedMatrixAry[i])
					  {
					  			 document.getElementById(curCB).checked=true;
					  }   		     		  
					}
			  }
	}
	document.getElementById("loadedSelBehav").value="";
	
	//DEMOGRAPHICS
	checkForDemog=document.getElementById("loadedDemog").value;
	//alert(checkForLoaded); 
	if(checkForDemog!="")
   {
   	demogInfoAry=checkForDemog.split("<pfl>");
   	for(i=1;i<(demogInfoAry.length-1);i++)
   	{
   			  curInfoAry=demogInfoAry[i].split(":");
   			  document.getElementById(curInfoAry[0]).value=curInfoAry[1].split('<br/>').join('\n');
   			  
   	}
	}
	document.getElementById("loadedDemog").value="";	
	
}
function calibrate()
{
  
	matrixInfoListAry=document.getElementById("hiddenIndInfolist").value.split(",");
	curSelectedInds="";
	for(i = 1; i < matrixInfoListAry.length; i++)
	{
		
		curClr=document.getElementById(matrixInfoListAry[i]+"id").style.backgroundColor;
		
		
		if(curClr!="white")
		{
			//alert(curClr);
			curCB=document.getElementById(matrixInfoListAry[i]).value;
			if(document.getElementById(curCB).checked)
			{				
				document.getElementById(matrixInfoListAry[i]+"id").style.backgroundColor="#99ff99";
				
				if(curSelectedInds.indexOf(document.getElementById(curCB).value)<0)
				{				
					curSelectedInds=curSelectedInds+","+document.getElementById(curCB).value
				}
			}
			if(!document.getElementById(curCB).checked)
			{
				document.getElementById(matrixInfoListAry[i]+"id").style.backgroundColor="#ffffcc";
			}
		}
			
	}

	document.getElementById("saveSelBehav").value=curSelectedInds;
	return curSelectedInds;	
}

function setHorizPos(elID)
{
	
	curhoriz=getPos(document.getElementById(elID)).x;

	if(curhoriz>750)
	{
		//alert(curhoriz);	
		newHorizPos=(975-curhoriz-200);
		document.getElementById(elID).style.left=newHorizPos;
	}

}

function getPos(el) 
{
    // yay readability
    for (var lx=0, ly=0;
         el != null;
         lx += el.offsetLeft, ly += el.offsetTop, el = el.offsetParent);
    return {x: lx,y: ly};
}

function showStratDesc(divID)
{
	toogleDiv(divID);
	setHorizPos(divID);

}



function saveDemographics()
{
	curname=document.getElementById("curname").value;
	curgrade=document.getElementById("curgrade").value;
	curinterests=document.getElementById("curinterests").value.replace(/(\n)/g,"<br/>");
	curactivities=document.getElementById("curactivities").value.replace(/(\n)/g,"<br/>");
	
	curDemog="[demogs]<pfl>";
	curDemog=curDemog+"curname:"+curname+"<pfl>";
	curDemog=curDemog+"curgrade:"+curgrade+"<pfl>";
	curDemog=curDemog+"curinterests:"+curinterests+"<pfl>";
	curDemog=curDemog+"curactivities:"+curactivities+"<pfl>";
	curDemog=curDemog+"[demogs]";
	

	document.getElementById("saveDemog").value=curDemog;
	//alert(document.getElementById("saveDemog").value);
}	
