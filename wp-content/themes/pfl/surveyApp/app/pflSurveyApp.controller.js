app.controller("pflSurveyController", function ($scope, pflSurveyService) {

    console.log("loading pflSurveyController");

	//default to english on load
	$scope.isFrench=false;	
	$scope.language='en';
	
	$scope.survey={};
	$scope.userInfo={};
	
	//for mouse position:
	var mouseX;
	var mouseY;
	$(document).mousemove( function(e) {
	   mouseX = e.pageX; 
	   mouseY = e.pageY;
	}); 	
	
	//language selection
	$scope.setLanguage=function(isFrench){
		if(isFrench){$scope.language='fr';}
		else{$scope.language='en';}

		$scope.setSurveyTitle();
		$scope.setSurveyButtonParts();
		
	}
	
	//display functions	
	$scope.surveyTitle='';
	$scope.setSurveyTitle=function(){
		$scope.surveyTitle = pflSurveyService.getSurveyTitle($scope.language);
	}
	
	$scope.surveyButtonParts=[];
	$scope.setSurveyButtonParts=function(){
		$scope.surveyButtonParts = pflSurveyService.getPartShortTitles($scope.language);
	}
	function updateButtonPartCompletion(partId, isComplete){
		
		for(var i=0;i<$scope.surveyButtonParts.length;i++){
			if($scope.surveyButtonParts[i].partId==partId){
				$scope.surveyButtonParts[i].isComplete=isComplete;
			}
		}
		console.log('updateButtonPartCompletion',partId, isComplete,$scope.surveyButtonParts);
	}

	$scope.surveyRatings=[];
	$scope.getSurveyRatings=function(){
		$scope.surveyRatings = pflSurveyService.getSurveyRatings();
	}
	
	//get survey parts by buttons
	$scope.showErrorPopUp=false;
	$scope.currentSurveyPart={};
	$scope.loadSurveyByPartId=function(partId){
		console.log('loadSurveyByPartId',partId, $scope.currentSurveyPart.partId  );		
		
		//check if going forward
		if($scope.currentSurveyPart.partId<partId){
			console.log('going forward');
			
			//make sure part is filled if going to next bit
			if(!$scope.checkNavAction($scope.currentSurveyPart) ){
				$scope.showErrorPopUp=true;
				return;
			}		
		
		}
		
		$scope.favNumErrors=[]; //do this to make sure it is refreshed on click
		$scope.currentSurveyPart = pflSurveyService.getSurveyQuestionsByPart(partId);
		if(partId==6){$scope.buildDreamSheet();}
		
		if(partId!=0 && partId!=5 && partId!=6){scrollToTopOfQuestions();}
	}
	
	
	//data for printing the survey
	$scope.surveyForPrint={};
	$scope.getSurveyDataForPrinting=function(){
		$scope.surveyForPrint=alasql('select * from ? ',[pflSurvey]);
		
	}
	
	//dream sheet functions
	$scope.buildDreamSheet=function(){
		//$scope.getDreamSheetStar();
		$scope.getPartFavorites();
		$scope.getSelectedListData();
	}
	
	$scope.summaryPartFavs={
		p1:{most:[{text:{en:"",fr:""}}],least:[{text:{en:"",fr:""}}]},
		p2:{most:[{text:{en:"",fr:""}}],least:[{text:{en:"",fr:""}}]},
		p3:{most:[{text:{en:"",fr:""}}],least:[{text:{en:"",fr:""}}]},
		p4:{most:[{text:{en:"",fr:""}}],least:[{text:{en:"",fr:""}}]}
	};
	$scope.getPartFavorites=function(){			
	
		for(var i=1;i<5;i++){
			$scope.summaryPartFavs['p'+i]['most'] =pflSurveyService.getPartFavorites(i, 'most');
			$scope.summaryPartFavs['p'+i]['least'] =pflSurveyService.getPartFavorites(i, 'least');
		}			
	}
	
	$scope.favNumErrors=[];
	//doing this as an array for ease of reference in the error function
	$scope.favNumValidation=[
		{isValid:false}, //most a
		{isValid:false}, //most b
		{isValid:false}, //least a
		{isValid:false} //least b
	];
	function validateFavouriteNumbers(){
		//reset errors and validation
		$scope.favNumErrors=[];
		for(var i=0;i<$scope.favNumValidation.length;i++){$scope.favNumValidation[i].isValid=true;}
		if($scope.currentSurveyPart.partId ==0 || $scope.currentSurveyPart.partId ==5|| $scope.currentSurveyPart.partId ==6){return;}
		
		var selectedNums=[
			$scope.currentSurveyPart.favorites.most.data.a,
			$scope.currentSurveyPart.favorites.most.data.b,		
			$scope.currentSurveyPart.favorites.least.data.a,
			$scope.currentSurveyPart.favorites.least.data.b
		];
		
		//null value check
		var nullCheckIndex=selectedNums.indexOf(null);
		if(nullCheckIndex>=0){
			if($scope.favNumErrors.indexOf('e0')<0){$scope.favNumErrors.push('e0');}
			$scope.favNumValidation[nullCheckIndex].isValid=false;
		}

		//index check
		for(var i=0;i<selectedNums.length;i++){
			if(selectedNums[i]<$scope.currentSurveyPart.questionIndex.start || selectedNums[i]>$scope.currentSurveyPart.questionIndex.end){
				if($scope.favNumErrors.indexOf('e1')<0){$scope.favNumErrors.push('e1');}
				$scope.favNumValidation[i].isValid=false;
			}
		}
		
		//check that same numbers are not used
		var uniqueNums=[];
		for(var i=0;i<selectedNums.length;i++){
			if(uniqueNums.indexOf(selectedNums[i])>=0){
				if($scope.favNumErrors.indexOf('e2')<0){$scope.favNumErrors.push('e2');}
				$scope.favNumValidation[i].isValid=false;
			}
			uniqueNums.push(selectedNums[i]);
		}
		
	}
	
	$scope.validFavNums=function(){
		validateFavouriteNumbers();
		
		if($scope.favNumErrors.length>0){return false;}
		return true;		
	}
	
	//$scope.showNavGrowler=false;
	$scope.navProgressChange=false;
	$scope.checkNavAction=function(curPart){		
		//console.log('checkNavAction',curPart );
	
		//$scope.showNavGrowler=true;
		$scope.navProgressChange=false;
		
		if(curPart.isComplete){return true;}//not a real naviation action, just going through the parts		
		if(curPart.partId==0){
			//info part			
			var infoComplete=(alasql('select count(1) as cnt from ? where data is null',[curPart.infoFields])[0].cnt==0)
			var subjComplete=(curPart.selectedSubjectId!=null);
			curPart.isComplete=infoComplete&&subjComplete;
		}
		else if(curPart.partId>=1 && curPart.partId<=4){
			//questions
			var infoComplete=(alasql('select count(1) as cnt from ? where selection is null',[curPart.questions])[0].cnt==0)
			var favsComplete=(curPart.favorites.most.data.a && curPart.favorites.most.data.b && curPart.favorites.least.data.a && curPart.favorites.least.data.b);
			//console.log('checkNavAction - questions',curPart,infoComplete,favsComplete);
			curPart.isComplete=infoComplete&&favsComplete&&($scope.favNumErrors.length==0);			
		}
		else if(curPart.partId==5){
			//lists
			var listSelctionsCount=[];
			for(var i=0;i<3;i++){
				listSelctionsCount.push(alasql('select count(1) as cnt from ? where selected is not null',[curPart.listSections[i].sectionItems])[0].cnt);
			}
			console.log('checkNavAction - lists',curPart,listSelctionsCount);
			//at least 1 thing selected in each
			curPart.isComplete=!(listSelctionsCount.indexOf(0)>=0);
		}
		else {
			return false;
		}
		
		//this shows the transition
		if(curPart.isComplete){
			updateButtonPartCompletion(curPart.partId,curPart.isComplete);
			$scope.navProgressChange=true;
		}
		console.log('checkNavAction',curPart.isComplete);
		return curPart.isComplete;
		
	}
	
	$scope.getListSectionSelectedCount=function(section){
		return alasql('select count(1) as cnt from ? where selected is not null',[section.sectionItems])[0].cnt		
	}
	
	$scope.lockedPart=function(surveyPart){
		if(surveyPart.partId==0){return false;}
		var prevPartComplete=alasql('select isComplete from ? where partId='+(surveyPart.partId-1),[pflSurvey])[0].isComplete;
		return (!prevPartComplete && surveyPart.partId!=$scope.currentSurveyPart.partId);		
	}

	
	
	$scope.dreamSheetActivity='';
	$scope.dreamSheetText={
		selectedSettingForLearning:{textVal:""},
		bigIdeasToLearn:{textVal:""},
		waysToLearn:{textVal:""},
		waysToShowLearning:{textVal:""},
		topic:{list:[],textVal:""},
		action:{list:[],textVal:""},
		product:{list:[],textVal:""},
	}
	
	$scope.setDreamSheetText=function(partId,textVal){	
		if(partId==1){$scope.currentSurveyPart.sections.settingsForLearning.textVal=textVal;}
		if(partId==2){$scope.currentSurveyPart.sections.bigIdeas.textVal=textVal;}
		if(partId==3){$scope.currentSurveyPart.sections.wayToLearn.textVal=textVal;}
		if(partId==4){$scope.currentSurveyPart.sections.wayToShowLearning.textVal=textVal;}
	}
	
	$scope.setDreamSheetTextList=function(partId,textVal){	
		var baseObj=null;
		if(partId==5.1){baseObj=$scope.currentSurveyPart.sections.topic;}		
		if(partId==5.2){baseObj=$scope.currentSurveyPart.sections.action;}		
		if(partId==5.3){baseObj=$scope.currentSurveyPart.sections.product;}	
		if(!baseObj){return;}		
		
		baseObj.list.push(textVal);
		baseObj.textVal=baseObj.list.join(', ');		
		//console.log('setDreamSheetTextList',baseObj);		
	}
	
	$scope.setDreamSheetActivity=function(dreamSheetActivity){
		pflSurveyService.getSurveyQuestionsByPart(6).sections.activity.textVal=dreamSheetActivity;
	}
	
	$scope.summaryList={topics:[],ways:[],show:[]};
	$scope.getSelectedListData=function(){
		$scope.summaryList=pflSurveyService.getSelectedListData();
		console.log('getSelectedListData',$scope.summaryList );
	}
	
	
	//filli n dream sheet
	$scope.selectedSettingForLearning={text:'nothing'};
	
	//svg functions
	$scope.dreamSheet={star:"0,0"};
	$scope.getDreamSheetStar=function(){			
		var svgPoints=CalculateStarPoints(250, 250, 7, 150, 225);			
		$scope.dreamSheet.star=svgPoints.join(' ');
	}

	document.getElementById('file-input').addEventListener('change', readSingleFile, false);
	function readSingleFile(e) {
		var file = e.target.files[0];
		if (!file) {return;}
		var reader = new FileReader();
		reader.onload = function(e) {
			var contents = e.target.result;
			console.log(contents);
			loadSurveyFromFile(contents);
		};
		reader.readAsText(file);
	}
	
	function downloadFile(filename, text) {
		var element = document.createElement('a');
		element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
		element.setAttribute('download', filename);

		element.style.display = 'none';
		document.body.appendChild(element);

		element.click();

		document.body.removeChild(element);
	}
	
	function loadSurvey(surveyPart){
		/*$scope.indicators=angular.copy(pflMatrixService.getIndicatorList());
		$scope.orderdIndicators=angular.copy(pflMatrixService.getOrderedIndicatorList());
		$scope.diffOptions=angular.copy(pflMatrixService.getDifferentiationOptions());
		$scope.diffOptionsCount=Object.keys($scope.diffOptions).length;
		$scope.diffOptRankings=pflMatrixService.initDifferentiationOptionsRanking();*/
		
	}	

	$scope.savePflSurvey=function(){
		var userInfo=alasql('select * from ? where partId=0',[pflSurvey])[0].infoFields;
		var dataStr=JSON.stringify(pflSurvey);
		//console.log('savePflSurvey',userInfo,dataStr);	
		
		var fileName=prompt("Please enter your file name:", (userInfo[0].data +userInfo[2].data+userInfo[3].data.replace(/\//g,'_').replace(/\\/g,'_')+'PFLSurvey.pfl').replace(/\s/g,''));
		if (fileName == null || fileName.trim() == "") {
			//do nothing for now
		}
		else {downloadFile(fileName.trim(),dataStr);}
		
				
	}
	
	
	function loadSurveyFromFile(fileStr){
		var loadedPflSurvey = angular.copy(JSON.parse(fileStr));
		
		if(pflSurveyService.isCompatibleVersion(loadedPflSurvey)){pflSurvey=loadedPflSurvey;}
		else{
			
			alert("The saved survey being loaded is NOT compatible with the current version.");
			return;
		}
		
		
		
		//fix date to be an object
		//pflSurvey[0].infoFields[3].data=new Date(pflSurvey[0].infoFields[3].data);
		
		//reload buttons
		$scope.setSurveyButtonParts();
		
		//load dreamsheetactivity
		$scope.dreamSheetActivity=pflSurvey[6].sections.activity.textVal;
		
		/*var userInfo=alasql('select * from ? where partId=0',[pflSurvey])[0].infoFields[3].data;
		$scope.userInfo.pflDate=new Date($scope.userInfo.pflDate);
		$scope.userInfo.pflDateStr=moment(angular.copy($scope.userInfo.pflDate)).format("DD MMM YYYY");
		console.log($scope.userInfo);					*/
		
		loadSurvey('userInfo');
		$scope.loadSurveyByPartId(0);		
		$scope.$apply();
		
	}
	
	
	$scope.navMessages=pflSurveyService.getSurveyNavMessages();
	$scope.favNumErrorMessages=pflSurveyService.getFavNumErrorMessages();
	
	loadSurvey('userInfo');
	//set language on load
	$scope.setLanguage($scope.isFrench); 
	//set to part 0 - my info on load
	$scope.loadSurveyByPartId(0);
	//get ratings - just need them once
	$scope.getSurveyRatings();
	
  
  
  
  
  
  //######################################3
  //helper UI functions
  
	function scrollToTopOfQuestions(){
		console.log('go back to the top');
		setTimeout( function() {$("#questDiv").scrollTop(0)}, 200 );
	}
  
	function CalculateStarPoints(centerX, centerY, arms, outerRadius, innerRadius)
	{
		//addapted from 
		//https://dillieodigital.wordpress.com/2013/01/16/quick-tip-how-to-draw-a-star-with-svg-and-javascript/
	   var results = [];

	   var angle = Math.PI / arms;

	   for (var i = 0; i < 2 * arms; i++)
	   {
		  // Use outer or inner radius depending on what iteration we are in.
		  var r = (i & 1) == 0 ? outerRadius : innerRadius;
		  
		  var currX = centerX + Math.cos(i * angle) * r;
		  var currY = centerY + Math.sin(i * angle) * r;

		  results.push(currX + "," + currY);
	   }

	   return results;
	}
  
  
  
  
  
//end of controller
});