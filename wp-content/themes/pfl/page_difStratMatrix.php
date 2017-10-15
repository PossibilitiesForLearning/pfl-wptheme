<?php /* Template name: Differentiation Strategy Matrix */ ?>
<?php
/**
 * The template for displaying all pages.
 * This is a template specifically to work with the pfl differentation strategy matrix
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

<!-- BEGINING OF HTML PAGE -->

	<link rel="stylesheet" href="./matrixApp/libs/angularPrint.css">
    <link rel="stylesheet" href="./matrixApp/libs/bootstrap.min.css">
	<link rel="stylesheet" href="./matrixApp/libs/font-awesome.min.css">
	<link rel="stylesheet" href="./matrixApp/libs/jquery-ui.css">

	
    <style>
        html {
        height: 100%;
        width: 100%;
        padding: 40px;		
        }


        .row {
             width: 100%;
             //text-align: center; 
             vertical-align:top;
        } 

 
        .saveBar {
            padding: 5px;
            background-color:white;
        }
        .saveBar button{
            padding: 5px;
        }
		
		.matrixTable td{
			border: 1px solid #ccc;
			background-color:white;	
			text-align:center;
			
		}			

		.matrixTable th{
			height: 40px; 
			white-space: nowrap;
		}		
		
		.matrixTable th > div{
			-webkit-transform: translate(25px, 51px);
			-webkit-transform: rotate(315deg);
			transform: translate(25px, 51px);
			transform: rotate(315deg);			
			width:35px;	
			}

		.breakColumn {width:5px !important; background-color: #4CAF50 !important;	}
		
		.matrixTable th > div > span{ 
			border-bottom: 1px solid #ccc
			
		}	
			
		#matrixDefs{
			border: 1px solid #ccc;
			height:165px!important;
			width:195px!important;
			-webkit-transform: translate(1px, 1px) !important;
			-webkit-transform: rotate(0deg) !important;
			transform: translate(1px, 1px)!important;
			transform: rotate(0deg)!important;			
			white-space: normal !important;		
			color:	#ccc;	
			padding:5px;
			position:relative;
			top:-45px;
			
		}
		
		#matrixDefsForPrint{
			height:165px!important;
			width:195px!important;
			-webkit-transform: translate(1px, 1px) !important;
			-webkit-transform: rotate(0deg) !important;
			transform: translate(1px, 1px)!important;
			transform: rotate(0deg)!important;			
			white-space: normal !important;		
			color:	#ccc;	
			padding:5px;
			position:relative;
			top:-45px;
			
		}		

		/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 30px;
  height: 17px;
}

/* Hide default HTML checkbox */
.switch input {display:none;}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 13px;
  width: 13px;
  left: 2px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(13px);
  -ms-transform: translateX(13px);
  transform: translateX(13px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 17px;
}

.slider.round:before {
  border-radius: 50%;
}​
    </style>

    <style>
        body {
            font-size:11px !important;
            padding: 10px;
			font-family: "Comic Sans MS", "Comic Sans", cursive;
        }
    </style>

<body ng-cloak ng-controller="pflMatrixController" ng-app='pflMatrixApp' style="max-width:1100">
	<div id="helpDialog" title="Pfl Matrix - Instructions" style="display:none;background-color:beige;font-size:13px;font-family: 'Comic Sans MS', 'Comic Sans', cursive;" print-remove>
			<ol ng-show="language=='default_en'">
			<li>Print a copy of the Brilliant Behaviours to record the behaviours that appear. Use either an individual checklist, group checklist, or a copy of the Guide.</li>
			<li>Record the information required information about the student and activity or activities at the top of the form.</li>
			<li>Observe a student while she or he is engaged in a challenging activity in an area of strength or interest. Click here to see a description of suitable activities.</li>
			<li>Put a check to the left of each Brilliant Behaviour the student demonstrates frequently, intensely and consistently.</li>
			<li>Transfer the student information and behaviours observed from the Brilliant Behaviours form to the Guide online. The Guide will change the Xs to the right of each behaviour you check into <i class="fa fa-check-circle-o" aria-hidden="true"></i>.</li>
			<li>The Guide will also highlight the differentiation strategies to emphasize for this student when she or he is working in this area of strength or interest.</li>
			<li>The definition of each behaviour and strategy will appear when the cursor rests on it. Read the definitions for each of the strategies recommended by the Guide. Do they seem appropriate?</li>
		</ol>

			<ol ng-show="language=='kids_en'">
			<li>Fill in the information at the top of the form.</li>
			<li>Read the list of Behaviours in the form. Let the cursor rest on the name of a behaviour and a description of it will appear. Click here if you want more information about any of them.</li>
			<li>Do you experience any of those behaviours when you are learning something challenging about a topic you love? Put a check mark (v) in the column to the left of each Behaviour that is consistently, intensely true of you while you’re learning something fascinating.</li>
			<li>Now look at the names of the strategies the Guide is recommending for you. They will be highlighted in green. A brief definition for each strategy will appear if you put your cursor over the name. Click on the name if you want more information and examples. The Guide thinks activities like that involve the strategies highlighted in green will challenge you in ways you’ll like when you are learning about your favourite topic. Do you agree with some or all of what the Guide has recommended?</li>
			<li>Share your Guide and the results with your teacher.</li>			
			</ol>
	</div>

<div class="panel panel-default" print-remove>
  <div class="panel-heading">
	<div class="row">
		<div class="col-sm-3">
			Differentiation Strategy Guide
			<i class="fa fa-info-circle" aria-hidden="true" ng-click="showHelp();"></i>			
		</div>
		<div class="col-sm-4">			
			<div style="float:right;">
				Teacher/Parent Version
				<label class="switch" style="top:7px;">
					<input type="checkbox" ng-model="isStudentText" ng-click="setLanguage(isStudentText);">
					<div class="slider round"></div>
				</label>
				Student Version				
			</div>
		</div>		
		<div class="col-sm-5">			
			<div style="float:right;">
				<button class="btn btn-info btn-sm fa fa-save" ng-click="savePflMatrix();">&nbsp;Save</button>
				<label for="file-input" class="btn btn-info btn-sm fa fa-folder-open" >&nbsp;Open</label>				
				<input type="file" id="file-input" style="display:none;">
				<button class="btn btn-info btn-sm fa fa-print" print-btn >&nbsp;Print</button>
			</div>
		</div>				
	</div>
  </div>  
</div>

<div class="panel panel-default" print-remove>
  <div class="panel-heading">
	<div class="row">
		<div class="col-sm-6">Information</div>
		<div class="col-sm-6">			
			<div style="float:right;" ng-init="showInfoForm=true;">
				<i class="fa fa-caret-up" aria-hidden="true" ng-show="showInfoForm" ng-click="showInfoForm=false;"></i>
				<i class="fa fa-caret-down" aria-hidden="true" ng-show="!showInfoForm" ng-click="showInfoForm=true;"></i>
			</div>
		</div>		
	</div>
  </div>
  <div class="panel-body" ng-show="showInfoForm">
	<div class='row'>
		<div class='col-sm-4'>
			<div class="form-group row">
				<label for="pflName" class="col-form-label">Name</label>
				<input class="form-control" type="text" id="pflName" ng-model="userInfo.pflName">
			</div>
		</div>
		<div class='col-sm-4'>
			<div class="form-group row">
				<label for="pflGrade" class="col-form-label">Grade</label>
				<input class="form-control" type="number" id="pflGrade" ng-model="userInfo.pflGrade">
			</div>
		</div>		
		<div class='col-sm-4'>
			<div class="form-group row">
				<label for="pflDate" class="col-form-label">Date</label>
				<input class="form-control" type="date" id="pflDate" ng-model="userInfo.pflDate">
			</div>
		</div>				
	</div>
	<div class='row'>
		<div class='col-sm-12'>
			<div class="form-group row">
				<label for="pflStrengths" class="col-form-label" ng-show="language=='default_en'">Strengths:</label>
				<label for="pflStrengths" class="col-form-label" ng-show="language=='kids_en'">Things you LOVE to learn about: </label>
				<textarea class="form-control span6" rows="3" id="pflStrengths" ng-model="userInfo.pflStrengths"></textarea>
			</div>
		</div>
	</div>
	<div class='row' ng-show="language=='default_en'">  
		<div class='col-sm-12'>
			<div class="form-group row">
				<label for="pflEvidence" class="col-form-label" >Dates and descriptions of activities observed:</label>
				<textarea class="form-control span6" rows="3" id="pflEvidence" ng-model="userInfo.pflEvidence"></textarea>
			</div>
		</div>
	</div>	
    
  </div>
</div>
	
<div class="row printOnly" >
	<div class="row">
		<div class="col-sm-2">Name: {{userInfo.pflName}}</div>
		<div class="col-sm-2">Grade: {{userInfo.pflGrade}}</div>
		<div class="col-sm-2">Date: {{userInfo.pflDateStr}}</div>
	</div>
	<div class="row">
		<div class="col-sm-6"><b>Strengths</b></br>{{userInfo.pflStrengths}}</div>
		<div class="col-sm-6" ng-class="isStudentText ? 'printRemove' : 'printOnly'"><b>Evidence</b></br>{{userInfo.pflEvidence}}</div>
	</div>
</div>
	
	<div class='row' style='height:10px;'>&nbsp;</div>
	<div class='row' height='25px' print-section>
		<div class='col-sm-12' style="padding-right: 0px;" >
			<style>				
				.pflDiffGroups{
					text-align:center;height:25px;vertical-align:top
				}
				.pflDiffTitles{
					font-size:11px
				}
				.pflCont {color:blue;}
				.pflProc {color:cadetblue;}
				.pflProd {color:dodgerblue;}
			</style>
			<table class="matrixTable" >
				<tr>
					<th colspan=23 class="pflDiffGroups">Differentiation Strategies<span class="printOnly"></br></br></br></span></th>
				</tr>
				<tr>
					<th >
						<div id="matrixDefs" print-remove>
							<div id="defTitle" style="border:solid 1px #ccc;background-color:#ccc;color:white;font-size:12px;" print-remove>Definition</div>
							<div id="defInfo" style="font-size:12px;" print-remove>
								Click on a behaviour or strategy for the definition
							</div>
						</div>
					</th>
					<th colspan=8 class="pflDiffGroups pflCont">Content</th>
					<th colspan=9 style="height:80px;" class="pflDiffGroups pflProc">Process</th>
					<th colspan=6 class="pflDiffGroups pflProd">Product</th>
				</tr>
				<tr>
					<th>Behaviours</th>
					
					<th ng-repeat="diffStrat in orderedDiffOptsArray"
						ng-click="showDef(diffOptions[diffStrat.id])" 
						>
						<div ng-show="diffStrat.id!='break'" >
							<span ng-style="{'background-color': topDiffOpts.indexOf(diffStrat.id)>=0 ? '#eff579':'white'}" 
							style="text-shadow: 1px 0 #888888;letter-spacing:1px;font-weight:bold;"
							class="pflDiffTitles {{diffStrat.htmlTitleClass}}">
								{{diffOptions[diffStrat.id].title}}
							</span>
						</div>
						<div  ng-show="diffStrat.id=='break'" class="breakColumn"></div>
					</th>								
					
				</tr>
				<tr ng-repeat="orderedIndic in orderdIndicators">
					<td style="text-align:left;border: 0px; font-size:11px;text-shadow: 1px 0 #888888;letter-spacing:1px;font-weight:bold;" ng-click="showDef(indicators[orderedIndic])">
						<input type="checkbox" ng-model="indicators[orderedIndic].isSelected" ng-change="updateRank(indicators[orderedIndic]);" style="margin-right:3px;">{{indicators[orderedIndic].title}}
					</td>
					<td  ng-repeat="diffStrat in orderedDiffOptsArray" ng-class="(diffStrat.id=='break') ? 'breakColumn':diffStrat.htmlTitleClass">
						<i ng-show="diffStrat.id!='break' && indicators[orderedIndic].isSelected && setIndicatorLocation(indicators[orderedIndic] , diffOptions[diffStrat.id])" class="fa fa-check-circle-o"></i>
						<i ng-show="diffStrat.id!='break' && !indicators[orderedIndic].isSelected && setIndicatorLocation(indicators[orderedIndic], diffOptions[diffStrat.id])" class="fa fa-times"></i>						
					</td>
																										
				</tr>
				<tr>
					<td style=" font-size:11px;text-align:right;padding-right:10px;">Ranking</td>	
					<td style="background-color:#eee; font-size:11px;" 
					ng-style="{'background-color': topDiffOpts.indexOf(diffStrat.id)>=0 ? '#eff579':'#eee'}"
					ng-repeat="diffStrat in orderedDiffOptsArray">
						{{diffOptRankings[diffStrat.id].displayRank}}
					</td>
					
				</tr>		
			</table>		
		</div>		
	</div>

<div class="row" style="margin-top:10px;" print-section>
	<div ng-show="topDiffOpts.length>0 && topDiffOpts.length<diffOptionsCount">
		<span>Recommended Strategies</span>
		</br>
		<ul>
			<li ng-repeat="rec in topDiffOpts"> 	
				<span style="font-size:10px;font-weight:bold;">{{diffOptions[rec].title}}</span> : <span style="font-size:9px;" >{{diffOptions[rec].descriptions[language]}}</span>
			</li>
		</ul>	
	</div>
	<div ng-show="topDiffOpts.length > 0 && topDiffOpts.length==diffOptionsCount">
		<span>All differentiation strategies are recommended</span>
		</br></br>		
	</div>	
</div>	

<div class="pageBreak"></div>

<div style="color:white;margin-top:100px;" print-section>
	</br></br></br></br>
	<span>Behaviours</span><br>
	<ul>
		<li ng-repeat="orderedIndic in orderdIndicators"> 				
			<span style="font-size:10px;font-weight:bold;">{{indicators[orderedIndic].title}}</span> : <span style="font-size:9px;" >{{indicators[orderedIndic].descriptions[language]}}</span>
		</li>
	</ul>	
</div>


<div style="color:white;margin-top:10px;" print-section>
	</br></br>
	<span>Differentiation Strategies</span><br><br>
	<span>Content</span><br>
	<ul>
		<li ng-repeat="diffStrat in orderedDiffOptsArray" ng-show="diffStrat.id!='break' && diffStrat.htmlTitleClass=='pflCont'"> 				
			<span style="font-size:10px;font-weight:bold;">{{diffOptions[diffStrat.id].title}}</span> : <span style="font-size:9px;" >{{diffOptions[diffStrat.id].descriptions[language]}}</span>
		</li>
	</ul>		
	<br><br><span>Process</span><br>
	<ul>
		<li ng-repeat="diffStrat in orderedDiffOptsArray" ng-show="diffStrat.id!='break' && diffStrat.htmlTitleClass=='pflProc'"> 				
			<span style="font-size:10px;font-weight:bold;">{{diffOptions[diffStrat.id].title}}</span> : <span style="font-size:9px;" >{{diffOptions[diffStrat.id].descriptions[language]}}</span>
		</li>
	</ul>			
	<br><br><span>Product</span><br>
	<ul>
		<li ng-repeat="diffStrat in orderedDiffOptsArray" ng-show="diffStrat.id!='break' && diffStrat.htmlTitleClass=='pflProd'"> 				
			<span style="font-size:10px;font-weight:bold;">{{diffOptions[diffStrat.id].title}}</span> : <span style="font-size:9px;" >{{diffOptions[diffStrat.id].descriptions[language]}}</span>
		</li>
	</ul>			
</div>



	</body>

<script src="./matrixApp/libs/jquery.min.js"></script>
<script src="./matrixApp/libs/bootstrap.min.js"></script>
<script src="./matrixApp/libs/angular_1.3.9.js"></script>
<script src="./matrixApp/libs/jquery-ui.min.js"></script>
<script src="./matrixApp/libs/alasql.min.js"></script>
<script src="./matrixApp/libs/moment.min.js"></script>
<script src="./matrixApp/libs/angularPrint.js"></script>

<script type="text/javascript" src="./matrixApp/static.content/indicator.matrix.js"></script>
<script type="text/javascript" src="./matrixApp/app/pflMatrixApp.js"></script>
<script type="text/javascript" src="./matrixApp/app/pflMatrixApp.controller.js"></script>
<script type="text/javascript" src="./matrixApp/app/pflMatrixApp.service.js"></script>
	


<!-- END OF HTML PAGE -->

