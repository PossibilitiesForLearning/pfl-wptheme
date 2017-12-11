







var partsAry=["pflSurveyPart00","pflSurveyPart01","pflSurveyPart02","pflSurveyPart03","pflSurveyPart04","pflSurveyPart05"];



function toogleElementView(elemId)
{
	if(document.getElementById(elemId).style.display=="block")
	{
		document.getElementById(elemId).style.display="none";
	}
	else
	{
		document.getElementById(elemId).style.display="block";
	} 	
}


function getDemogInfo()
{
		  //this is intentionally done like this, as this will likely be pulle
		  //out. the order for decode will be identical in the collection
		  //generated from the split
		  name=document.getElementById("inptPFLName").value;
		  age=document.getElementById("inptPFLAge").value;
		  grade=document.getElementById("inptPFLGrade").value;
		  demogInfo=name;
		  demogInfo=demogInfo+"<pfl>"+age;
		  demogInfo=demogInfo+"<pfl>"+grade;		  
		  
		  return demogInfo; 
}

function inputDemogInfo(demogInfo)
{
		  demogInfo=demogInfo.replace("demog{","").replace("}","");
		  demogInfoArray=demogInfo.split("<pfl>");
		  document.getElementById("inptPFLName").value=demogInfoArray[0];
		  document.getElementById("inptPFLAge").value=demogInfoArray[1];
		  document.getElementById("inptPFLGrade").value=demogInfoArray[2];		  
}

function getPFLFavSubj()
{
		   selectedFavSubjIds="";
		 	var allCBs = document.getElementsByTagName("input");
		 	for(i=0;i<allCBs.length;i++)
		 	{
				  if (allCBs[i].getAttribute("group")=="pflFavSubj")
				  {
				  			 if(allCBs[i].checked)
				  			 {				  			 			
				  			 			if(allCBs[i].value!="other")
				  			 			{
				  			 					  selectedFavSubjIds=selectedFavSubjIds+","+allCBs[i].id;
				  			 			}
				  			 			else
				  			 			{
				  			 					  selectedFavSubjIds=selectedFavSubjIds+",other-"+allCBs[i].id+":"+document.getElementById('inptPFLSubjFavOther').value;
				  			 			}
				  			 }
				  }
			}
			return  selectedFavSubjIds;
}
function getSectionCBs(sectionID,qStart,qEnd)
{
		   sectionInfo="";
		   var allRBs = document.getElementsByTagName("input");
		   totalQs=qEnd-qStart + 1;
		   
		   for(qId=1;qId<=totalQs;qId++)
			{
				curRBGroupDone=false;	  
				for(j=0;j<allRBs.length;j++)
				{
				  if (allRBs[j].getAttribute("type")=="radio")
				  {
				  curRBGroup=allRBs[j].getAttribute("name");
				  
				  if (curRBGroup==sectionID+"_"+qId)
				  {
				  			curRBGroupObj=document.getElementsByName(sectionID+"_"+qId); 
				  			//alert(sectionID+"_"+qId+"-"+curRBGroupObj.length); 
						   for (var i = 0; i < curRBGroupObj.length; i++) 
						   {
						   		  if (curRBGroupObj[i].checked) 
						   		  {
						   		  			 if(curRBGroupDone==false)
						   		  			 {
						   		  			 //alert(curRBGroupObj[i].value);
						   		  			 sectionInfo=sectionInfo+","+qId+":"+curRBGroupObj[i].value;
						   		  			 curRBGroupDone=true;
						   		  			 }
            					  }
            			}
				  }
				  }
				}
				
			}
			return  sectionInfo;
}

function getListOfInputValues(inputIdAry)
{
		  aryValList="";
		  for(var i=0;i<inputIdAry.length;i++)
		  {
		  			 aryValList=aryValList+","+document.getElementById(inputIdAry[i]).value;			 
		  }
		  return aryValList;
}

function getSelectedCBListFrom(secId)
{
		var curSelAry=[];
		p05SecDiv=document.getElementById(secId);
		secDivSels=p05SecDiv.getElementsByTagName("input");
		for(i=0;i<secDivSels.length;i++)
		{
				  if((secDivSels[i].type=="checkbox")&&(secDivSels[i].checked))
				  {
				  			 curSelAry.push(secDivSels[i].id);
				  }
		}
		idListString="";
		for(i=0;i<curSelAry.length;i++)
		{
				  idListString=idListString+","+curSelAry[i];	  
		}	
		return idListString;
}

function trackPFL()
{
		  	curpfl="[pflSY_start]";
		 //intro
		   //demographic info
		   curpfl=curpfl+"\ndemog{"+getDemogInfo()+"}";
		 	//subjects only
		 	curpfl=curpfl+"\nintro{"+getPFLFavSubj()+"}";
		 //part 1
		 	//questions #1-44 
		 	curpfl=curpfl+"\npart01_Questions{"+getSectionCBs("PART01",1,44)+"}";
		 	//2 things liked
		 	curpfl=curpfl+"\npart01_Likes{"+getListOfInputValues(["pflP01LikeBest01","pflP01LikeBest02"])+"}";
		 	//2 things disliked
		 	curpfl=curpfl+"\npart01_Dislikes{"+getListOfInputValues(["pflP01LikeLeast01","pflP01LikeLeast02"])+"}";		 	

		 //part 2
		 	curpfl=curpfl+"\npart02_Questions{"+getSectionCBs("PART02",45,62)+"}";
		 	//2 things liked
		 	curpfl=curpfl+"\npart02_Likes{"+getListOfInputValues(["pflP02LikeBest01","pflP02LikeBest02"])+"}";
		 	//2 things disliked
		 	curpfl=curpfl+"\npart02_Dislikes{"+getListOfInputValues(["pflP02LikeLeast01","pflP02LikeLeast02"])+"}";		 	

		 //part 3
		 	curpfl=curpfl+"\npart03_Questions{"+getSectionCBs("PART03",63,89)+"}";
		 	//2 things liked
		 	curpfl=curpfl+"\npart03_Likes{"+getListOfInputValues(["pflP03LikeBest01","pflP03LikeBest02"])+"}";
		 	//2 things disliked
		 	curpfl=curpfl+"\npart03_Dislikes{"+getListOfInputValues(["pflP03LikeLeast01","pflP03LikeLeast02"])+"}";		 	

		 //part 4
		 	curpfl=curpfl+"\npart04_Questions{"+getSectionCBs("PART04",90,114)+"}";
		 	//2 things liked
		 	curpfl=curpfl+"\npart04_Likes{"+getListOfInputValues(["pflP04LikeBest01","pflP04LikeBest02"])+"}";
		 	//2 things disliked
		 	curpfl=curpfl+"\npart04_Dislikes{"+getListOfInputValues(["pflP04LikeLeast01","pflP04LikeLeast02"])+"}";		 	
	 
		 //part 5
		 curpfl=curpfl+"\npart05_LikeToLearn{"+getSelectedCBListFrom("pfl_liketolearn_P05")+"}";
		 curpfl=curpfl+"\npart05_WaysToLearn{"+getSelectedCBListFrom("pfl_waystolearn_P05")+"}";
		 curpfl=curpfl+"\npart05_ShowLearn{"+getSelectedCBListFrom("pfl_showlearn_P05")+"}";
		 
		 curpfl=curpfl+"\n[pflSY_end]";
		 document.getElementById("savePFLInput").value=curpfl;
		 
}

function loadSavedPFLSurvey()
{
		  loadedInfo=document.getElementById("loadedPFLInput").value;
		  //alert(loadedInfo);
		  infoAry=loadedInfo.split("|$$|");
		  //alert(infoAry.length);
		  if(infoAry.length==18)
		  {
					 /*SAMPLE		  
					 line 1: demog{eliot<pfl>3<pfl>4}
					 line 2: intro{,cbpflIntroMath,cbpflIntroWrite}
					 line 3: part01_Questions{,1:SA,2:A,3:N,4:D,5:SD}
					 line 4: part01_Likes{,4,5}
					 line 5: part01_Dislikes{,6,7}
					 line 6: part02{,1:SD,2:D,3:N,4:A,5:SA}
					 line 7: part02_Likes{,46,47}
					 line 8: part02_Dislikes{,48,49}
					 line 9: part03{,1:SA,2:A,3:N,4:D,5:SD}
					 line 10: part03_Likes{,64,65}
					 line 11: part03_Dislikes{,66,67}
					 line 12: part04{,1:SD,2:D,3:N,4:A,5:SA}
					 line 13: part04_Likes{,91,92}
					 line 14: part04_Dislikes{,93,94}
					 line 15: part05_LikeToLearn{,liketolearn_business,liketolearn_force,liketolearn_mythology}
					 line 16: part05_WaysToLearn{,waystolearn_assess,waystolearn_deconstruct,waystolearn_form}
					 line 17: part05_ShowLearn{,showlearn_biography,showlearn_game,showlearn_narrative}
					 */
					 
					 //THIS LINE NUMBER SETUP SHOULD BE TURNED INTO A MAP WITH VARIABLES TO ALLOW FOR AN EASY WAY TO ADD A NEW SAVE COMPONENT
					 
					 //apply saved intro:
					 inputDemogInfo(infoAry[1]);
					 checkSelectedBoxes(infoAry[2],"intro");
					 
					 //apply saved part 1
					 setSelectedQuestions("PART01",infoAry[3]);
					 setSelectedIDValues(["pflP01LikeBest01","pflP01LikeBest02"],infoAry[4].replace("}","").split("{")[1].split(","));
					 setSelectedIDValues(["pflP01LikeLeast01","pflP01LikeLeast02"],infoAry[5].replace("}","").split("{")[1].split(","));
					 
					 //apply saved part 2
					 setSelectedQuestions("PART02",infoAry[6]);
					 setSelectedIDValues(["pflP02LikeBest01","pflP02LikeBest02"],infoAry[7].replace("}","").split("{")[1].split(","));					 
					 setSelectedIDValues(["pflP02LikeLeast01","pflP02LikeLeast02"],infoAry[8].replace("}","").split("{")[1].split(","));
					 
					 //apply saved part 3
					 setSelectedQuestions("PART03",infoAry[9]);
					 setSelectedIDValues(["pflP03LikeBest01","pflP03LikeBest02"],infoAry[10].replace("}","").split("{")[1].split(","));
					 setSelectedIDValues(["pflP03LikeLeast01","pflP03LikeLeast02"],infoAry[11].replace("}","").split("{")[1].split(","));					 

					 //apply saved part 4
					 setSelectedQuestions("PART04",infoAry[12]);
					 setSelectedIDValues(["pflP04LikeBest01","pflP04LikeBest02"],infoAry[13].replace("}","").split("{")[1].split(","));
					 setSelectedIDValues(["pflP04LikeLeast01","pflP04LikeLeast02"],infoAry[14].replace("}","").split("{")[1].split(","));					 					 
					 
					 //apply saved part 5
					 checkSelectedBoxes(infoAry[15],"part05_LikeToLearn");
					 checkSelectedBoxes(infoAry[16],"part05_WaysToLearn");								 
					 checkSelectedBoxes(infoAry[17],"part05_ShowLearn");
					 
					 //analyze survey
					 runPFLAnalyze("PART01",1,44);
					 runPFLAnalyze("PART02",45,62);
					 runPFLAnalyze("PART03",63,89);
					 runPFLAnalyze("PART04",90,114);
					 
		  }

}
function checkSelectedBoxes(infoStr,parseRoot)
{
		  idAry=infoStr.replace(parseRoot+"{,","").replace("}","").split(",");
		  for(i=0;i<idAry.length;i++)
		  {
		  			 try
		  			 {
		  			 			document.getElementById(idAry[i]).checked=true;
		  			 }
		  			 catch(err)
		  			 {
		  			 			//do nothing
		  			 }
		  }		  
}
function setSelectedIDValues(idAry,valueAry)
{
		  for(i=0;i<idAry.length;i++)
		  {
		  			 //alert(valueAry[i+1]);
		  			 document.getElementById(idAry[i]).value=valueAry[i+1];	 
		  }
}
function setSelectedQuestions(rootID,info)
{
		  //1:SA,2:A,3:N,4:D,5:SD
		  //alert("length:"+infoAry.length);
		  
		  //alert(info.replace(rootID.toLowerCase()+"_Questions{,","").replace("}",""));
		  cleanInfoAry=info.replace(rootID.toLowerCase()+"_Questions{,","").replace("}","").split(",");
		  
		  //alert("length:"+cleanInfoAry.length);
		  for(i=0;i<cleanInfoAry.length;i++)
		  {
		  			 qInfo=cleanInfoAry[i].split(":");
		  			 qName=rootID+"_"+qInfo[0];
		  			 //alert(qName);
		  			 qOpts=document.getElementsByName(qName);
		  			 for(j=0;j<qOpts.length;j++)
		  			 {
		  			 			if(qOpts[j].value==qInfo[1])
		  			 			{
		  			 					  qOpts[j].checked=true;	  			 					  
		  			 			}
		  			 }
		  }
		  //alert("done "+rootID);
		  
}

//pfl survey analysis
function runPFLAnalyze(sectionID,qStart,qEnd)
{
		   var allRBs = document.getElementsByTagName("input");
		   totalQs=qEnd-qStart + 1;
		   for(qId=1;qId<=totalQs;qId++)
			{
				groupName=sectionID+"_"+qId;
				curRBGroupDone=false;	  
				
				for(j=0;j<allRBs.length;j++)
				{
				  if (allRBs[j].getAttribute("type")=="radio")
				  {
				  			 curRBGroup=allRBs[j].getAttribute("name");
				  			 if (curRBGroup==groupName)
				  			 {				  			 		 
				  			 			curRBGroupObj=document.getElementsByName(groupName); 
				  			 			//alert(sectionID+"_"+qId+"-"+curRBGroupObj.length); 
									  for (i = 0; i < curRBGroupObj.length; i++) 
									  {
									  			 if(curRBGroupObj[i].checked)
									  			 {
									  			 			if(curRBGroupObj[i].value=="SA")
									  			 			{
									  			 					  //alert(curRBGroupObj[i].id+":"+groupName+":"+curRBGroupObj[i].value);
									  			 					  analyzePFL(curRBGroupObj[i].id ,sectionID);
									  			 					  curRBGroupDone=true;									  			 					  
									  			 			}
									  			 }
												 if(curRBGroupDone==true)
												 {
															i=curRBGroupObj.length;
															j=allRBs.length;
												 }
									  }
							 }
				  }
				}
				
			}	  
}

function analyzePFL(cbId,partId)
{
		 try
		 {
					curStrtats=document.getElementById(cbId).getAttribute("stratids");
					curStrtatsAry=curStrtats.split(",");
					for(i = 0; i < curStrtatsAry.length; i++)
					{
						curIdRef=partId+"_"+curStrtatsAry[i];	  
						curIdMaxRef=partId+"_"+curStrtatsAry[i]+"_max";
						curIdPercRef=partId+"_"+curStrtatsAry[i]+"_perc";
						
						curIdCount=parseInt(document.getElementById(curIdRef).innerHTML);
						curIdMax=parseInt(document.getElementById(curIdMaxRef).innerHTML);
						
						if(document.getElementById(cbId).checked){curIdCount=curIdCount+1;}
						else{curIdCount=curIdCount-1;}
						
						curIdPerc=Math.round((100*curIdCount)/curIdMax);
						
						document.getElementById(curIdRef).innerHTML=curIdCount;
						document.getElementById(curIdPercRef).innerHTML=curIdPerc+"%";
						
						
					}  
					topSelAry=buildSummaryResList(3);
					resDom=document.getElementById("resSummaryList");
					reslist="";
					for (var i=0; i<topSelAry.length; i++)
					{
							  reslist=reslist+"<li>"+topSelAry[i]+"</li>";
					}
					resDom.innerHTML=reslist;
					prepPFLPrintValues();
					//trackPFL();
		 }
		 catch(err)
		 {
		 			//alert(err.message);//do nothing
		 }
		 			
}
function prepPFLPrintValues()
{
		 document.getElementById("pflAnalysisRef").value=document.getElementById("fullPFLSummaryTable").innerHTML;
		 document.getElementById("pflNameRef").value=document.getElementById("inptPFLName").value;
		 document.getElementById("pflGradeRef").value=document.getElementById("inptPFLGrade").value;
		 document.getElementById("pflFavSubjRef").value=pflFavSubjList();

		 document.getElementById("pflNameSumRef").value=document.getElementById("inptPFLName").value;
		 document.getElementById("pflGradeSumRef").value=document.getElementById("inptPFLGrade").value;
		 document.getElementById("pflFavSubjSumRef").value=pflFavSubjList();		 
		 document.getElementById("pflFavQsRef").value=document.getElementById("pflFavQs").innerHTML;
		 document.getElementById("pflLeastFavQsRef").value=document.getElementById("pflLeastFavQs").innerHTML;
		 getPFLSelectValue('pflSSP05Sec0101','pflFavTopics01Ref');
		 getPFLSelectValue('pflSSP05Sec0102','pflFavTopics02Ref');	
		 
		 getPFLSelectValue('pflSSP05Sec0201','pflFavWayLearn01Ref');
		 getPFLSelectValue('pflSSP05Sec0202','pflFavWayLearn02Ref');
		 
		 getPFLSelectValue('pflSSP05Sec0301','pflFavWayShow01Ref');
		 getPFLSelectValue('pflSSP05Sec0302','pflFavWayShow02Ref');
		 
		 document.getElementById("pflDreamRef").value=document.getElementById("fullPFLDreamDiv").innerHTML;
		 document.getElementById("pflNameDreamRef").value=document.getElementById("inptPFLName").value;
		 document.getElementById("pflGradeDreamRef").value=document.getElementById("inptPFLGrade").value;
		 document.getElementById("pflFavSubjDreamRef").value=pflFavSubjList();		 
		 
		 
}

function getPFLSelectValue(selectId,frmInputId)
{
		 document.getElementById(frmInputId).value=document.getElementById(selectId).value;
}

function pflFavSubjList()
{
		favSubLst="";
		var allCBs = document.getElementsByTagName("input");
		for(i=0;i<allCBs.length;i++)
		{
				  if (allCBs[i].getAttribute("group")=="pflFavSubj")
				  {
				  			 if(allCBs[i].checked)
				  			 {
				  			 			if(allCBs[i].value!="other")
				  			 			{
				  			 					  favSubLst=favSubLst+"<li>"+allCBs[i].value+"</li>";
				  			 			}
				  			 			else
				  			 			{
				  			 					  favSubLst=favSubLst+"<li>"+document.getElementById('inptPFLSubjFavOther').value+"</li>";
				  			 			}
				  			 }
				  }
		}
		return "<ul>"+favSubLst+"</ul>";
}
function sortMultiDimensional(a,b)
{
    // this sorts the array using the second element    
    return ((a[1] > b[1]) ? -1 : ((a[1] < b[1]) ? 1 : 0));
}
function buildSummaryResList(selectNum)
{
		  var resultsList = [];
		  //var matches = [];
		  var elems = document.getElementsByTagName("td");
		  //alert(elems.length);
		  for (var i=0; i<elems.length; i++) 
		  {
			 if (elems[i].id.indexOf("_perc") != -1)
			 {
			 			elemTitle=elems[i].getAttribute("info");
			 			elemPerc=parseInt(elems[i].innerHTML.replace("%",""));
			 			resultsList.push([elemTitle,elemPerc]);
			 }
		  }
		  sortedList=resultsList.sort(sortMultiDimensional);
		  
		  var selectedAry = [];
		  for(var j=0;j<selectNum;j++)
		  {
		  			 selectedAry.push(sortedList[j][0]);
		  }
		  
		  return selectedAry;
		  
		  
}

//pfl survey generate summary sheet
function generatePFLSummarySheet()
{
		  document.getElementById("pflSSName").innerHTML= document.getElementById("inptPFLName").value;

		document.getElementById("pflSSDate").innerHTML= document.getElementById("inptPFLDate").value;
		
		favSubLst="";
		var allCBs = document.getElementsByTagName("input");
		for(i=0;i<allCBs.length;i++)
		{
				  if (allCBs[i].getAttribute("group")=="pflFavSubj")
				  {
				  			 if(allCBs[i].checked)
				  			 {
				  			 			if(allCBs[i].value!="other")
				  			 			{
				  			 					  favSubLst=favSubLst+"<li>"+allCBs[i].value+"</li>";
				  			 			}
				  			 			else
				  			 			{
				  			 					  favSubLst=favSubLst+"<li>"+document.getElementById('inptPFLSubjFavOther').value+"</li>";
				  			 			}
				  			 }
				  }
		}
		
		document.getElementById("pflSSFavSubj").innerHTML=favSubLst;
		
		//Likes/dislikes Part 1
		document.getElementById("pflSSP01LikeBest01").innerHTML=getQTextByNum("pflSurveyPart01","pflP01LikeBest01");
		document.getElementById("pflSSP01LikeBest02").innerHTML=getQTextByNum("pflSurveyPart01","pflP01LikeBest02");
		document.getElementById("pflSSP01LikeLeast01").innerHTML=getQTextByNum("pflSurveyPart01","pflP01LikeLeast01");
		document.getElementById("pflSSP01LikeLeast02").innerHTML=getQTextByNum("pflSurveyPart01","pflP01LikeLeast02");		
		

		//Likes/dislikes Part 2
		document.getElementById("pflSSP02LikeBest01").innerHTML=getQTextByNum("pflSurveyPart02","pflP02LikeBest01");
		document.getElementById("pflSSP02LikeBest02").innerHTML=getQTextByNum("pflSurveyPart02","pflP02LikeBest02");
		document.getElementById("pflSSP02LikeLeast01").innerHTML=getQTextByNum("pflSurveyPart02","pflP02LikeLeast01");
		document.getElementById("pflSSP02LikeLeast02").innerHTML=getQTextByNum("pflSurveyPart02","pflP02LikeLeast02");	


		//Likes/dislikes Part 3
		document.getElementById("pflSSP03LikeBest01").innerHTML=getQTextByNum("pflSurveyPart03","pflP03LikeBest01");
		document.getElementById("pflSSP03LikeBest02").innerHTML=getQTextByNum("pflSurveyPart03","pflP03LikeBest02");
		document.getElementById("pflSSP03LikeLeast01").innerHTML=getQTextByNum("pflSurveyPart03","pflP03LikeLeast01");
		document.getElementById("pflSSP03LikeLeast02").innerHTML=getQTextByNum("pflSurveyPart03","pflP03LikeLeast02");

		//Likes/dislikes Part 4
		document.getElementById("pflSSP04LikeBest01").innerHTML=getQTextByNum("pflSurveyPart04","pflP04LikeBest01");
		document.getElementById("pflSSP04LikeBest02").innerHTML=getQTextByNum("pflSurveyPart04","pflP04LikeBest02");
		document.getElementById("pflSSP04LikeLeast01").innerHTML=getQTextByNum("pflSurveyPart04","pflP04LikeLeast01");
		document.getElementById("pflSSP04LikeLeast02").innerHTML=getQTextByNum("pflSurveyPart04","pflP04LikeLeast02");	

		//selected topics
		document.getElementById("pflSSP05Sec0101").innerHTML=buildSumSheetDDL("pfl_liketolearn_P05");
		document.getElementById("pflSSP05Sec0102").innerHTML=buildSumSheetDDL("pfl_liketolearn_P05");
		document.getElementById("pflSSP05Sec0201").innerHTML=buildSumSheetDDL("pfl_waystolearn_P05");
		document.getElementById("pflSSP05Sec0202").innerHTML=buildSumSheetDDL("pfl_waystolearn_P05");
		document.getElementById("pflSSP05Sec0301").innerHTML=buildSumSheetDDL("pfl_showlearn_P05");
		document.getElementById("pflSSP05Sec0302").innerHTML=buildSumSheetDDL("pfl_showlearn_P05");
		
		prepPFLPrintValues();		
}

function generatePFLDreamSheet()
{
		  //Settings(part1)
		  document.getElementById("pflDSSet01").innerHTML="I really like "+getQTextByNum("pflSurveyPart01","pflP01LikeBest01");
		  document.getElementById("pflDSSet02").innerHTML="I really like "+getQTextByNum("pflSurveyPart01","pflP01LikeBest02");
		  document.getElementById("pflDreamSettingRef").value=document.getElementById("pflDSSet01").innerHTML;

		  //ideas(part2)
		  document.getElementById("pflDSIdea01").innerHTML="I really like "+getQTextByNum("pflSurveyPart02","pflP02LikeBest01");
		  document.getElementById("pflDSIdea02").innerHTML="I really like "+getQTextByNum("pflSurveyPart02","pflP02LikeBest02");	
		  document.getElementById("pflDreamIdeasRef").value=document.getElementById("pflDSIdea01").innerHTML;
		  
		  //ways(part3)
		  document.getElementById("pflDSWay01").innerHTML="I really like "+getQTextByNum("pflSurveyPart03","pflP03LikeBest01");
		  document.getElementById("pflDSWay02").innerHTML="I really like "+getQTextByNum("pflSurveyPart03","pflP03LikeBest02");	
		  document.getElementById("pflDreamWaysRef").value=document.getElementById("pflDSWay01").innerHTML;

		  //show(part4)
		  document.getElementById("pflDSShow01").innerHTML="I really like "+getQTextByNum("pflSurveyPart04","pflP04LikeBest01");
		  document.getElementById("pflDSShow02").innerHTML="I really like "+getQTextByNum("pflSurveyPart04","pflP04LikeBest02");	
		  document.getElementById("pflDreamShowRef").value=document.getElementById("pflDSShow01").innerHTML;	  


		//selected topics
		document.getElementById("pflDSTopic").innerHTML=buildSumSheetDDL("pfl_liketolearn_P05");
		document.getElementById("pflDSAction").innerHTML=buildSumSheetDDL("pfl_waystolearn_P05");
		document.getElementById("pflDSProduct").innerHTML=buildSumSheetDDL("pfl_showlearn_P05");
		
		document.getElementById("pflDreamTopicRef").value=document.getElementById("pflDSTopic").value;
		document.getElementById("pflDreamActionRef").value=document.getElementById("pflDSAction").value;
		document.getElementById("pflDreamProductRef").value=document.getElementById("pflDSProduct").value;
		
		
		
		prepPFLPrintValues();
		  
}


function addYCCB(parentElemId,inputElemId)
{
		  ycDiv=document.getElementById(parentElemId);
		  ycIn=document.getElementById(inputElemId);
		  
		  ycDiv.innerHTML=ycDiv.innerHTML+"<input type='checkbox' value='"+ycIn.value+"' checked>"+ycIn.value+"<br>";
}

function buildSumSheetDDL(secId)
{
		var curSelAry=[];
		p05SecDiv=document.getElementById(secId);
		secDivSels=p05SecDiv.getElementsByTagName("input");
		for(i=0;i<secDivSels.length;i++)
		{
				  if((secDivSels[i].type=="checkbox")&&(secDivSels[i].checked))
				  {
				  			 curSelAry.push(secDivSels[i].value);
				  }
		}
		ddlListString="";
		for(i=0;i<curSelAry.length;i++)
		{
				  ddlListString=ddlListString+"<option value='"+curSelAry[i]+"'>"+curSelAry[i]+"</option>";	  
		}	
		return ddlListString;
}

function getQTextByNum(partId,inptId)
{
		qIdNum=document.getElementById(inptId).value;
		  
		partDiv=document.getElementById(partId);
		qTables=partDiv.getElementsByTagName("table");
		//alert(qTables.length);
		for(i=0;i<qTables.length;i++)
		{
				  qnum=qTables[i].getAttribute("qnum");
				  if(qnum==qIdNum)
				  {
				  			 return qTables[i].getAttribute("qtext").replace("I like"," ").replace("I only like"," ");
				  }
		}
		return " ... "+qIdNum;
}


//input validation
function isNumeric(value,minRange,maxRange,id) {
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
				  	
