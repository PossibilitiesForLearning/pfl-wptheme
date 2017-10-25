app.controller("pflMatrixController", function ($scope, pflMatrixService) {

    console.log("loading pflMatrixController");
    
	$scope.language='default_en';	
	$scope.indicators={};
	$scope.orderdIndicators={};
	$scope.diffOptions={};
	$scope.diffOptionsCount=-1;
	$scope.diffOptRankings={};
	$scope.topDiffOpts={}
	$scope.userInfo={};
	
	//for mouse position:
	var mouseX;
	var mouseY;
	$(document).mousemove( function(e) {
	   mouseX = e.pageX; 
	   mouseY = e.pageY;
	}); 
	
	
	$scope.showHelp=function(){
		$( "#helpDialog" ).dialog({
			  modal: true,
			  width: 800,
			buttons: {
					OK: function() {
					  $( this ).dialog( "close" );
					}
				  },
			closeOnEscape: false,
				open: function(event, ui) {
					$(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
				}				  
		});
	}
	
	$scope.setLanguage=function(isStudentText){
		if(isStudentText){$scope.language='kids_en';}
		else{$scope.language='default_en';}
	}
	
	$scope.setIndicatorLocation=function(indicator, diffOpt){
		if(diffOpt.indicators.indexOf(indicator.id)>=0){return true;}
		return false;
	}
	
	$scope.updateRank=function(indicator){
		$scope.topDiffOpts=pflMatrixService.updateDifferentiationOptionsRanking(indicator.id, indicator.isSelected, $scope.diffOptRankings);
	}	
	
	$scope.savePflMatrix=function(){
		var indicatorList = [];
		for (var pflInd in $scope.indicators) {
			if ($scope.indicators[pflInd].isSelected) {
				indicatorList.push(pflInd)
			}
		}
		
		var userDataForSave=angular.copy($scope.userInfo);
		userDataForSave.indicators=indicatorList;
		var dataStr=JSON.stringify(userDataForSave);
		console.log(userDataForSave,dataStr);	
		
		var fileName=prompt("Please enter your file name:", ($scope.userInfo.pflName+$scope.userInfo.pflGrade+$scope.userInfo.pflDateStr+'PFLMatrix.pfl').replace(/\s/g,''));
		if (fileName == null || fileName.trim() == "") {
			//do nothing for now
		}
		else {downloadFile(fileName.trim(),dataStr);}
		
				
	}
	
	$scope.showDef=function(diffObj,elemId){
		//console.log("#"+diffObj.id,diffObj.descriptions[$scope.language]);

			/*if ($('#'+elemId+'_info').length ) {$('#'+elemId+'_info').show();}	
			else{
				$("#"+elemId).append('<div id="'+elemId+'_info" style="position:absolute;top:'+mouseX+'px;left:'+mouseY+'px;border:solid 1px black;">hello?...</div>');
			}			
			$('#'+elemId+'_info').fadeIn('fast').delay(3000).fadeOut('slow');*/

			//$('#DivToShow').css({'top':mouseY,'left':mouseX}).fadeIn('slow');
			
			$('.defTitle').html(diffObj.title + '<i class="fa fa-times pull-right hidden"></i>');
			$('.defInfo').text(diffObj.descriptions[$scope.language]);
	}
	
	document.getElementById('file-input').addEventListener('change', readSingleFile, false);
	function readSingleFile(e) {
		var file = e.target.files[0];
		if (!file) {return;}
		var reader = new FileReader();
		reader.onload = function(e) {
			var contents = e.target.result;
			console.log(contents);
			loadMatrixFromFile(contents);
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
	
	function loadMatrix(){
		$scope.indicators=angular.copy(pflMatrixService.getIndicatorList());
		$scope.orderdIndicators=angular.copy(pflMatrixService.getOrderedIndicatorList());
		$scope.diffOptions=angular.copy(pflMatrixService.getDifferentiationOptions());
		$scope.diffOptionsCount=Object.keys($scope.diffOptions).length;
		$scope.diffOptRankings=pflMatrixService.initDifferentiationOptionsRanking();
		
	}	
	
	function loadMatrixFromFile(fileStr){
		$scope.userInfo = angular.copy(JSON.parse(fileStr));
		$scope.userInfo.pflDate=new Date($scope.userInfo.pflDate);
		$scope.userInfo.pflDateStr=moment(angular.copy($scope.userInfo.pflDate)).format("DD MMM YYYY");
		console.log($scope.userInfo);					
		
		for (var pflInd in $scope.indicators) {$scope.indicators[pflInd].isSelected=false;}
		
		for(var i=0;i<$scope.userInfo.indicators.length;i++){
			var pflInd=$scope.userInfo.indicators[i];
			console.log($scope.indicators[pflInd]);
			//$scope.updateRank(indicator)
			$scope.indicators[pflInd].isSelected=true;
			$scope.updateRank($scope.indicators[pflInd]);
		}
		$scope.$apply();
		
	}
	
	var colors={grey:100,white:255, black:0, blue:"#0000ff",cadetblue:"#5f9ea0",dodgerblue:"#1e90ff" };
	var colorsRgb={
		grey:{r:125,g:125,b:125},
		white:{r:255,g:255,b:255}, 
		black:{r:0,g:0,b:0}, 
		blue:{r:0,g:0,b:255},
		cadetblue:{r:95,g:158,b:160},
		dodgerblue:{r:30,g:144,b:255} 
		};
	

	$scope.orderedDiffOptsArray=[
		{id:"contAbs",color:colors.blue, colorRgb:colorsRgb.blue, htmlTitleClass:'pflCont'},
		{id:"contComp",color:colors.blue, colorRgb:colorsRgb.blue, htmlTitleClass:'pflCont'},
		{id:"extTop",color:colors.blue, colorRgb:colorsRgb.blue, htmlTitleClass:'pflCont'},
		{id:"livLiv",color:colors.blue, colorRgb:colorsRgb.blue, htmlTitleClass:'pflCont'},
		{id:"orgLivVal",color:colors.blue, colorRgb:colorsRgb.blue, htmlTitleClass:'pflCont'},
		{id:"relLiTop",color:colors.blue, colorRgb:colorsRgb.blue, htmlTitleClass:'pflCont'},
		{id:"selSelCont",color:colors.blue, colorRgb:colorsRgb.blue, htmlTitleClass:'pflCont'},
		{id:"break",color:colors.blue, colorRgb:colorsRgb.blue, htmlTitleClass:'pflCont'},
		
		{id:"cmplxThink",color:colors.cadetblue, colorRgb:colorsRgb.cadetblue, htmlTitleClass:'pflProc'},
		{id:"expMeths",color:colors.cadetblue, colorRgb:colorsRgb.cadetblue, htmlTitleClass:'pflProc'},
		{id:"groupInt",color:colors.cadetblue, colorRgb:colorsRgb.cadetblue, htmlTitleClass:'pflProc'},
		{id:"indvPurs",color:colors.cadetblue, colorRgb:colorsRgb.cadetblue, htmlTitleClass:'pflProc'},
		{id:"inqBasLea",color:colors.cadetblue, colorRgb:colorsRgb.cadetblue, htmlTitleClass:'pflProc'},
		{id:"opEnd",color:colors.cadetblue, colorRgb:colorsRgb.cadetblue, htmlTitleClass:'pflProc'},
		{id:"pacProc",color:colors.cadetblue, colorRgb:colorsRgb.cadetblue, htmlTitleClass:'pflProc'},
		{id:"reasRefl",color:colors.cadetblue, colorRgb:colorsRgb.cadetblue, htmlTitleClass:'pflProc'},
		{id:"selSelProc",color:colors.cadetblue, colorRgb:colorsRgb.cadetblue, htmlTitleClass:'pflProc'},
		{id:"procVariety",color:colors.cadetblue, colorRgb:colorsRgb.cadetblue, htmlTitleClass:'pflProc'},
		{id:"break",color:colors.cadetblue, colorRgb:colorsRgb.cadetblue, htmlTitleClass:'pflProc'},
		
		{id:"authAud",color:colors.dodgerblue, colorRgb:colorsRgb.dodgerblue, htmlTitleClass:'pflProd'},
		{id:"feedAssProd",color:colors.dodgerblue, colorRgb:colorsRgb.dodgerblue, htmlTitleClass:'pflProd'},
		{id:"selSelProd",color:colors.dodgerblue, colorRgb:colorsRgb.dodgerblue, htmlTitleClass:'pflProd'},
		{id:"transProd",color:colors.dodgerblue, colorRgb:colorsRgb.dodgerblue, htmlTitleClass:'pflProd'},
		{id:"prodVariety",color:colors.dodgerblue, colorRgb:colorsRgb.dodgerblue, htmlTitleClass:'pflProd'}
	];
	
	

	loadMatrix();
	
  
//end of controller
});