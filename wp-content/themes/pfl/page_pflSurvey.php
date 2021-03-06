<?php /* Template name: PFL Survey */ ?>
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

<!--style-->

<style>
	[ng\:cloak],
		[ng-cloak],
		.ng-cloak {
			display: none !important;
		}
	</style>

<style>
	.formError {
			border: 3px solid red;
		}

		.completedPartBtn {
			background-color: #68da68;
		}

		.progressPartBtn {
			background-color: #a1a1da;
		}
		/* The switch - the box around the slider */

		.switch {
			position: relative;
			display: inline-block;
			width: 30px;
			height: 17px;
		}

		/* Hide default HTML checkbox */

		.switch input {
			display: none;
		}

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

		input:checked+.slider {
			background-color: #2196F3;
		}

		input:focus+.slider {
			box-shadow: 0 0 1px #2196F3;
		}

		input:checked+.slider:before {
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
		}

		​
	</style>

<!-- BEGINING OF HTML PAGE -->

<body ng-cloak ng-controller="pflSurveyController" ng-app='pflSurveyApp' class="body-content body-survey">
	<?php include 'nav.php';?>


	<div class="printOnly" style="position:absolute;max-width:800px;left:50px;" ng-show="printSurvey">
		<div print-section>
			<div class="row" style="margin-left:15px;font-size:10px;">
				<div class="col-sm-12">
					<div class="row" style="margin-left:10px;">{{surveyTitle}}</div>
					<div class='row' style="margin-top:15px;" ng-repeat="sPart in surveyForPrint" print-avoid-break>
						<div class='row' style="margin:10px;">
							<p>{{sPart.partTitle[language]}}</p>
						</div>

						<div ng-show="sPart.partId==0" style="margin-left:10px;">
							<div class='row' ng-repeat="info in sPart.infoFields">
								<div class='col-sm-3'>
									<label>{{info.label[language]}}</label>
								</div>
								<div class='col-sm-8'>{{info.data}}</div>
							</div>
							<div class='row' style="margin-left:5px;">
								<div class="form-group row">
									<label>{{sPart.subjectsLabel.label[language]}}</label>
								</div>
							</div>
							<div class='row' style="margin-left:5px;">
								<div class='col-sm-2' ng-repeat="opts in sPart.subjects">
									<input type="radio" name='favSubject' ng-model="sPart.selectedSubjectId" ng-value="opts.id">
									<label class="col-form-label">{{opts.label[language]}}</label>
									<span class="col-sm-2" ng-show="sPart.selectedSubjectId==5 && opts.id==5">
										{{sPart.otherSubjectText}}
									</span>
								</div>
							</div>
						</div>
						<div ng-show="sPart.partId!=0 && sPart.partId!=5 && sPart.partId!=6">
							<div class='row' style="margin-top:15px;border-top:1px solid black;border-bottom:1px solid black;max-width:1200px;">
								<div class='col-sm-2' ng-repeat="sr in surveyRatings">
									<strong>{{sr.abrv[language]}}</strong> = {{sr.label[language]}}
								</div>
							</div>
							<div class='row' ng-repeat="quest in sPart.questions" style="margin-left:-15px;">
								<div class='row'>
									<div class="col-sm-10">
										<span ng-repeat="sr in surveyRatings">
											<input type="radio" ng-model="quest.selection" ng-value="sr.id">
											<label>{{sr.abrv[language]}}</label>
										</span>
										<span style="width:30px;">
											<strong>{{sPart.questionIndex.start + $index}})</strong>&nbsp;{{quest.text[language]}}</span>
									</div>
								</div>
							</div>
						</div>
						<div ng-show="sPart.partId==5">
							<div class="pageBreak"></div>
							<div class="row" ng-repeat="section in sPart.listSections" style="margin-top:15px;margin-left:10px;">
								<div class="row">
									<div class="col-sm-10">
										<h4>{{section.sectionTitle[language]}}</h4>
										<p>{{section.sectionInfo[language]}}</p>
									</div>
								</div>
								<div class="row" style="margin-top:15px;">
									<div width="150px" class="col-sm-4" ng-repeat="item in section.sectionItems">
										<input type="checkbox" ng-value="item.selected" /> {{item.itemText[language]}}
									</div>
								</div>
								<div class="row" style="margin-top:15px;">
									<strong>{{section.otherItemsText[language]}}</strong>
									<br>
									<textarea style="box-sizing:border-box;width:80%;" ng-model="section.sectionOtherItems"></textarea>
								</div>
								<div class="row" ng-hide="!section.userQuestionsText" style="margin-top:15px;">
									<strong>{{section.userQuestionsText[language]}}</strong>
									<br>
									<textarea style="box-sizing:border-box;width:80%;" ng-model="section.sectionUserQuestions"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="printOnly" style="position:absolute;max-width:1050px;top:-100px;left:50px" ng-show="printSummary">
		<div class="row" ng-repeat="sPart in surveyForPrint">
			<div ng-show="sPart.partId==6">
				<div class="row">
					<b>{{sPart.summary.partTitle[language]}}</b>
				</div>
				<div class="row" ng-repeat="partId in [1,2,3,4]">
					<u>{{sPart.summary.statements.most[language]}} {{partId}}</u>
					<br>
					<div class="row" ng-repeat="favs in summaryPartFavs['p'+partId].most">
						>> {{favs.text[language]}}
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-6">
						<u>{{sPart.summary.statements.lists.topics[language]}}</u>
					</div>
					<div class="col-sm-6">
						<ul>
							<li ng-repeat="topics in summaryList.topics" style="display: inline-block;padding-left:10px;">{{topics.itemText[language]}}</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<u>{{sPart.summary.statements.lists.ways[language]}}</u>
					</div>
					<div class="col-sm-6">
						<ul>
							<li ng-repeat="ways in summaryList.ways" style="display: inline-block;padding-left:10px;">{{ways.itemText[language]}}</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<u>{{sPart.summary.statements.lists.show[language]}}</u>
					</div>
					<div class="col-sm-6">
						<ul>
							<li ng-repeat="show in summaryList.show" style="display: inline-block;padding-left:10px;">{{show.itemText[language]}}</li>
						</ul>
					</div>
				</div>
				<br>
				<div class="row" ng-repeat="partId in [1,2,3,4]">
					<u>{{sPart.summary.statements.least[language]}} {{partId}}</u>
					<br>
					<div class="row" ng-repeat="favs in summaryPartFavs['p'+partId].least">
						>> {{favs.text[language]}}
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="printOnly" style="position:absolute;max-width:1050px;left:50px" ng-show="printDream">
		<img src="<?=getThemePath()?>/surveyApp/static.content/dreamSheet.svg" style="height:800px;width:600px" />

		<div style="position:absolute;top:80px;left:120px;width:200px; z-index:999;">
			<b>{{surveyForPrint[6].sections.settingsForLearning.title[language]}}</b>
		</div>
		<div style="position:absolute;top:105px;left:110px;max-width:190px;z-index:999;">{{surveyForPrint[6].sections.settingsForLearning.textVal}}</div>

		<div style="position:absolute;top:33px;left:400px;z-index:999;">
			<b>{{surveyForPrint[6].sections.bigIdeas.title[language]}}</b>
		</div>
		<div style="position:absolute;top:52px;left:400px;width:130px;z-index:999;">{{surveyForPrint[6].sections.bigIdeas.textVal}}</div>

		<div style="position:absolute;top:585px;left:140px;z-index:999;">
			<b>{{surveyForPrint[6].sections.wayToLearn.title[language]}}</b>
		</div>
		<div style="position:absolute;top:610px;left:105px;width:170px;z-index:999;">{{surveyForPrint[6].sections.wayToLearn.textVal}}</div>

		<div style="position:absolute;top:615px;left:390px;z-index:999;">
			<b>{{surveyForPrint[6].sections.wayToShowLearning.title[language]}}</b>
		</div>
		<div style="position:absolute;top:635px;left:375px;width:160px;z-index:999;">{{surveyForPrint[6].sections.wayToShowLearning.textVal}}</div>

		<div style="position:absolute;top:150px;left:425px;z-index:999;">
			<b>{{surveyForPrint[6].sections.topic.title[language]}}</b>
		</div>
		<div style="position:absolute;top:175px;left:400px;z-index:999;">{{surveyForPrint[6].sections.topic.textVal}}</div>

		<div style="position:absolute;top:485px;left:185px;z-index:999;">
			<b>{{surveyForPrint[6].sections.action.title[language]}}</b>
		</div>
		<div style="position:absolute;top:505px;left:160px;z-index:999;">{{surveyForPrint[6].sections.action.textVal}}</div>

		<div style="position:absolute;top:500px;left:380px;z-index:999;">
			<b>{{surveyForPrint[6].sections.product.title[language]}}</b>
		</div>
		<div style="position:absolute;top:520px;left:360px;z-index:999;">{{surveyForPrint[6].sections.product.textVal}}</div>

		<div style="position:absolute;top:300px;left:280px;z-index:999;">
			<b>{{surveyForPrint[6].sections.activity.title[language]}}</b>
		</div>
		<div style="position:absolute;top:320px;left:260px;z-index:999;">
			{{surveyForPrint[6].sections.activity.textVal}}
		</div>
	</div>

	<!-- div id='navGrowler' print-remove 
	style="position:absolute;top:50%;left:50%;width:250px;font-size:10pt;font-weight:bold;background-color:#7ade7a;padding:10px;border-radius:7px;z-index:9999;" 
		ng-show="showNavGrowler&&navProgressChange">
	<div class="row" style="margin:5px;">{{navMessages.partCompletion[language]}}</div>
	<div class="row" style="margin:5px;">
		<button class="btn btn-info btn-xs" style="float:right;" ng-click="showNavGrowler=!showNavGrowler;loadSurveyByPartId(currentSurveyPart.partId + 1)">{{navMessages.partContinue[language]}}</button>
	</div>
</div -->

	<div id='printSelectorPopUp' print-remove style="position:absolute;top:37%;left:40%;width:375px;font-size:10pt;font-weight:bold;background-color:#898d9c;padding:10px;border-radius:7px;z-index:9999;"
	 ng-show="showPrintSelectorPopUp">
		<div class="row" style="float:right;margin-right:20px;margin-left:20px;">Print Dialog</div>
		<div class="row" style="margin:5px;">
			<button class="btn btn-default" print-btn ng-click="printSurvey=true;printSummary=false;printDream=false;">&nbsp;Survey</button>
		</div>
		<div class="row" style="margin:5px;">
			<button class="btn btn-default" print-btn ng-click="printSurvey=false;printSummary=true;printDream=false;">&nbsp;Summary</button>
		</div>
		<div class="row" style="margin:5px;">
			<button class="btn btn-default" print-btn ng-click="printSurvey=false;printSummary=false;printDream=true;">&nbsp;Dream
				Sheet</button>
		</div>
		<div class="row" style="margin:5px;">
			<button class="btn btn-default" style="float:right;" ng-click="showPrintSelectorPopUp=false;">Close</button>
		</div>
	</div>


	<!-- KEVIN'S CHANGES AND STUFF STARTS HERE this is the start of the visible form -->

	<div id="main">
		<div id="image-background" style="background-image: url('<?= bgRandom() ?>');" print-remove>

		</div>

		<div id="content-background" print-remove>
			<div class="color-block block1">

			</div>
			<div class="color-block block2">

			</div>
			<div class="color-block block3">

			</div>

			<div class="container-fluid breadcrumb-container hidden-xs hidden-sm" print-remove>
				<div class="row breadcrumb-row">
					<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
						<?php custom_breadcrumbs(); ?>
					</div>
				</div>
			</div>
		</div>

		<div id="primary" class="container-fluid">
			<div class="row" print-remove>
				<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 hero">
					<em>
					{{surveyTitle}}</em>
				</div>
			</div>


			<div class="row content-row settings-row" print-remove>

				<div class="col-xs-12 col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 toggle-row">
				</div>

				<div class="col-xs-12 col-sm-5 col-md-5 text-right button-row">
					
					<label for="file-input" class="btn btn-default" >Load</label>				
					<input type="file" id="file-input" style="display:none;">
					<button class="btn btn-default" ng-click="savePflSurvey();"">Save</button>
					<button class="btn btn-default" ng-click="showPrintSelectorPopUp=true;getSurveyDataForPrinting();getPartFavorites();">Print</button>
				</div>
			</div>

			<div class="row content-row" print-remove>

				<div class="col-xs-12 text-center">
					<ul class="page-progression">
						<li ng-repeat="part in surveyButtonParts" 
						ng-click="loadSurveyByPartId(part.partId);" 
						ng-show="part.partId<6" 
						ng-disabled="lockedPart(part);"
						ng-class="{'in-progress' :part.partId==currentSurveyPart.partId, 'completed':part.isComplete && part.partId!=currentSurveyPart.partId }"
						>
						<div class="h-line"></div>
						<div class="indicator"></div>
						{{part.partShortTitle[language]}}
						</li>
					</ul>
				</div>
			</div>
			<div class="row content-row body-row" print-remove>

				<!-- My Info Page -->
				<div class="col-xs-12 col-sm-6 col-sm-offset-3" ng-show="currentSurveyPart.partType=='INFO'">									
					<div class="panel-body">
						<div class='row' ng-repeat="info in currentSurveyPart.infoFields">
							<div class='col-xs-4'>
								<div class="form-group row">
									<label class="col-form-label">{{info.label[language]}}
										<span ng-show="!info.data" class="error-indicator" style="color:red;">*</span>
									</label>
								</div>
							</div>
							<div class='col-xs-6'>
								<div class="form-group row">
									<input ng-show="info.type!='date' && info.type!='text'" class="form-control" type="{{info.type}}" ng-model="info.data"
									ng-blur="checkNavAction(currentSurveyPart)" min="1">
									<input ng-show="info.type=='date' || info.type=='text'" class="form-control" type="{{info.type}}" ng-model="info.data"
									ng-blur="checkNavAction(currentSurveyPart)">
								</div>
							</div>
						</div>
						<div class='row'>
							<div class="col-xs-12 col-sm-4 row">
								<label class="col-form-label">{{currentSurveyPart.subjectsLabel.label[language]}}
									<span ng-show="!currentSurveyPart.selectedSubjectId && currentSurveyPart.selectedSubjectId!=0" style="color:red;">*</span>
								</label>
							</div>
						</div>
						<div class='row'>
							<div class='col-xs-2' ng-repeat="opts in currentSurveyPart.subjects">
								<div class="row">
										<div class="col-sm-2">
											<input type="radio" name='favSubject' ng-model="currentSurveyPart.selectedSubjectId" ng-value="opts.id"
											ng-click="checkNavAction(currentSurveyPart)">									 
											<div class="radio-label">{{opts.label[language]}}</div>
											<div ng-show="currentSurveyPart.selectedSubjectId==5 && opts.id==5">
												<input type="text" ng-model="currentSurveyPart.otherSubjectText">
											</div>
										</div>
								</div>
							</div>
						</div>
					</div>			
				</div>
				<!-- end My Info Page -->

				<!-- Question Template -->
				<div class="col-xs-12" ng-show="currentSurveyPart.partType=='QUESTION'">
					<div class="panel-body">
						<div class='row' style="margin:20px 0px;">
							<div class='col-xs-12 col-sm-8 col-sm-offset-2'>
								{{currentSurveyPart.partInfo[language]}}
							</div>
						</div>
						
						<div class='row'>
							<div class='col-xs-12 col-sm-10 col-sm-offset-1'>							
								<div class="col-xs-1"></div>
								<div class='col-xs-2 rating-legend' ng-repeat="sr in surveyRatings">
									<div class="term">{{sr.abrv[language]}}</div>
									<div class="explanation">{{sr.label[language]}}</div>
								</div>
							</div>
						</div>
						<div class="row" id="questDiv">							
							<div class='col-xs-12 col-sm-8 col-sm-offset-2'>	
								<div class='row' ng-repeat="quest in currentSurveyPart.questions">
									<div class="col-xs-1" style="max-width:30px;">
										<strong>{{currentSurveyPart.questionIndex.start + $index}}
											<span ng-show="!quest.selection && quest.selection!=0" style="color:red;">*</span>
										</strong>
									</div>
									<div class="col-xs-12" style="max-width:200px;">
										<div class='col-xs-1' ng-repeat="sr in surveyRatings">
											<label>
											<input type="radio" name='{{quest.id}}_surveyQuestion' ng-model="quest.selection" ng-value="sr.id" ng-click="checkNavAction(currentSurveyPart)">
											<div class="legend-label">{{sr.abrv[language]}}</div></label>
										</div>
									</div>
									<div class="col-xs-7">
										<p class="question">{{quest.text[language]}}</p>
									</div>
								</div>
							</div>
						</div>
						<div class='row'>
							<div class="col-xs-12 col-sm-8 col-sm-offset-2">
								<div class="row">
									
							<div class='col-sm-4'>
								<div class='row'>
									<div class='row'>
										<p>{{currentSurveyPart.favorites.title[language]}} {{currentSurveyPart.questionIndex.start}} to
											{{currentSurveyPart.questionIndex.end}}</p>
									</div>
									<div class='row'>
										<p>{{currentSurveyPart.favorites.most.label[language]}}</p>
									</div>
									<div class='row'>
										<div class='col-sm-5'>
											<input class="form-control" type="number" ng-model="currentSurveyPart.favorites.most.data.a" ng-class="{'formError':!validFavNums()&&!favNumValidation[0].isValid}"
											ng-blur="checkNavAction(currentSurveyPart)" min="{{currentSurveyPart.questionIndex.start}}" max="{{currentSurveyPart.questionIndex.end}}">
										</div>
										<div class='col-sm-5'>
											<input class="form-control" type="number" ng-model="currentSurveyPart.favorites.most.data.b" ng-class="{'formError':!validFavNums()&&!favNumValidation[1].isValid}"
											ng-blur="checkNavAction(currentSurveyPart)" min="{{currentSurveyPart.questionIndex.start}}" max="{{currentSurveyPart.questionIndex.end}}">
										</div>
									</div>
									<div class='row'>
										<p>{{currentSurveyPart.favorites.least.label[language]}}</p>
									</div>
									<div class='row'>
										<div class='col-sm-5'>
											<input class="form-control" type="number" ng-model="currentSurveyPart.favorites.least.data.a" ng-class="{'formError':!validFavNums()&&!favNumValidation[2].isValid}"
											ng-blur="checkNavAction(currentSurveyPart)" min="{{currentSurveyPart.questionIndex.start}}" max="{{currentSurveyPart.questionIndex.end}}">
										</div>
										<div class='col-sm-5'>
											<input class="form-control" type="number" ng-model="currentSurveyPart.favorites.least.data.b" ng-class="{'formError':!validFavNums()&&!favNumValidation[3].isValid}"
											ng-blur="checkNavAction(currentSurveyPart)" min="{{currentSurveyPart.questionIndex.start}}" max="{{currentSurveyPart.questionIndex.end}}">
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6" style="padding:20px;color:red;">
								<ul>
									<li ng-repeat="err in favNumErrors">{{favNumErrorMessages[err][language]}}</li>
								</ul>
							</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<!-- End Question Template -->

				<!-- List Template -->
				
				<div class="col-xs-12 list-template" ng-show="currentSurveyPart.partType=='LIST'">
					<div class="panel-body container">
						<div class='row' style="margin:20px 0px;">
							<div class='col-xs-12 col-sm-8 col-sm-offset-2'>
								Please click on the arrow to see the possibilities for each section or to enter your own.
							</div>
						</div>							
						<div class="row" ng-repeat="section in currentSurveyPart.listSections" style="margin-top:15px;margin-left:10px;">
							<div class="row">
								<div class="col-sm-10">
									<h4 class="section-heading">{{section.sectionTitle[language]}} [
										<span ng-show="getListSectionSelectedCount(section)==0" class="selected-count inactive">{{getListSectionSelectedCount(section)}}</span>
										<span ng-show="getListSectionSelectedCount(section)>0" class="selected-count active">{{getListSectionSelectedCount(section)}}</span>
										{{navMessages.selected[language]}} ]</h4>
									<p>{{section.sectionInfo[language]}}</p>
								</div>
								<div class="col-sm-2">
									<button ng-show="!section.show" ng-click="section.show=!section.show" ng-init="section.show=false;" class="list-dropdown-btn btn btn-lg fa fa-caret-down"></button>
									<button ng-show="section.show" ng-click="section.show=!section.show" class="list-dropdown-btn btn btn-lg fa fa-caret-up"></button>
								</div>
							</div>
							<div class="row" style="margin-top:15px;max-height:500px;overflow-y:scroll;overflow-x:hidden;" ng-show="section.show">
								<div class="col-sm-2 checkbox-container" ng-repeat="item in section.sectionItems">
										<label>
									<input type="checkbox" ng-model="item.selected" ng-value="item.selected" /> {{item.itemText[language]}}</label>
								</div>
							</div>
							<div class="row" style="margin-top:15px;" ng-show="section.show">
								<strong>{{section.otherItemsText[language]}}</strong>
								<br>
								<textarea style="box-sizing:border-box;width:80%;" ng-model="section.sectionOtherItems"></textarea>
							</div>
							<div class="row" ng-hide="!section.userQuestionsText || !section.show" style="margin-top:15px;">
								<strong>{{section.userQuestionsText[language]}}</strong>
								<br>
								<textarea style="box-sizing:border-box;width:80%;" ng-model="section.sectionUserQuestions"></textarea>
							</div>
						</div>	
					</div>
				</div>

				<!-- End List Template -->

				<!-- Dream Template -->
				
				<div class="col-xs-12 dream-template" ng-show="currentSurveyPart.partType=='DREAM'">
					<div class="panel-body container">
						<div class="row">
								
							<div ng-class="{'col-sm-4':!showSummaryOnly,'col-sm-10 col-sm-offset-1':showSummaryOnly }">
								<div class="panel-default">
									<div class="panel-heading" ng-show="showSummaryOnly" >{{currentSurveyPart.summary.partTitle[language]}}</div>
									<div class="panel-heading" ng-show="!showSummaryOnly" >{{currentSurveyPart.summary.partTitleDream[language]}}</div>
									<div class="panel-body">
										<div class="row summary-row" ng-repeat="partId in [1,2,3,4]">
											<div class="summary-question">{{currentSurveyPart.summary.statements.most[language]}} {{partId}}</div>
											<ul class="summary-ul">
												<li ng-repeat="favs in summaryPartFavs['p'+partId].most">
													<input ng-show="!showSummaryOnly" type="radio" name="p{{partId}}_selection" ng-click="setDreamSheetText(partId,favs.text[language])">
													{{favs.text[language]}}
												</li>
											</ul>
										</div>
										<div class="row summary-row">
										<div class="summary-question">{{currentSurveyPart.summary.statements.lists.topics[language]}}</div>
											<ul ng-show="showSummaryOnly">
												<li ng-repeat="topics in summaryList.topics" style="display: inline-block;padding-left:10px;">
													{{topics.itemText[language]}}
												</li>
											</ul>
											<ul ng-show="!showSummaryOnly">
												<li ng-repeat="topics in summaryList.topics" style="display: inline-block;padding-left:10px;">
													<input  type="radio" name="5.1" ng-click="setDreamSheetTextList(5.1,topics.itemText[language])"> 
													{{topics.itemText[language]}}
												</li>
											</ul>
										</div>
										<div class="row summary-row">
											<div class="summary-question">{{currentSurveyPart.summary.statements.lists.ways[language]}}</div>											
											<ul ng-show="showSummaryOnly">
												<li ng-repeat="ways in summaryList.ways" style="display: inline-block;padding-left:10px;">
													{{ways.itemText[language]}}
												</li>
											</ul>
											<ul ng-show="!showSummaryOnly">
												<li ng-repeat="ways in summaryList.ways" style="display: inline-block;padding-left:10px;">
													<input  type="radio" name="5.2" ng-click="setDreamSheetTextList(5.2,ways.itemText[language])" > 
													{{ways.itemText[language]}}
												</li>
											</ul>											
										</div>
										<div class="row summary-row">
											<div class="summary-question">{{currentSurveyPart.summary.statements.lists.show[language]}}</div>											
											<ul ng-show="showSummaryOnly">
												<li ng-repeat="show in summaryList.show" style="display: inline-block;padding-left:10px;">
													{{show.itemText[language]}}
												</li>
											</ul>
											<ul ng-show="!showSummaryOnly">
												<li ng-repeat="show in summaryList.show" style="display: inline-block;padding-left:10px;">
													<input type="radio" name="s53" value="{{show.itemText[language]}}" ng-click="setDreamSheetTextList(5.3,show.itemText[language])" > 
													{{show.itemText[language]}}
												</li>
											</ul>											
										</div>
										<div class="row" ng-show="showSummaryOnly">
										</div>
										<div class="row  summary-row" ng-show="showSummaryOnly" ng-repeat="partId in [1,2,3,4]">
											<div class="summary-question">{{currentSurveyPart.summary.statements.least[language]}} {{partId}}</div>
											<ul class="summary-ul">
												<li ng-repeat="favs in summaryPartFavs['p'+partId].least">{{favs.text[language]}}</li>
											</ul>
										</div>
									</div>
								</div>
							</div>

							<div ng-show="!showSummaryOnly" class="col-sm-8" style="font-size:11px;margin-left:10px;background-image: url(<?=getThemePath()?>/surveyApp/static.content/dreamSheet.svg);height:800px;width:600px;background-repeat:no-repeat; background-color: white;">
								<div style="position:absolute;top:12%;left:15%;max-width:30%">
									<b>{{currentSurveyPart.sections.settingsForLearning.title[language]}}</b>
								</div>
								<div style="position:absolute;top:16%;left:15%;max-width:30%">{{currentSurveyPart.sections.settingsForLearning.textVal}}</div>

								<div style="position:absolute;top:5%;left:58%;max-width:25%">
									<b>{{currentSurveyPart.sections.bigIdeas.title[language]}}</b>
								</div>
								<div style="position:absolute;top:8%;left:56%;max-width:25%">{{currentSurveyPart.sections.bigIdeas.textVal}}</div>

								<div style="position:absolute;top:74%;left:11%;max-width:30%">
									<b>{{currentSurveyPart.sections.wayToLearn.title[language]}}</b>
								</div>
								<div style="position:absolute;top:77%;left:9%;max-width:30%">{{currentSurveyPart.sections.wayToLearn.textVal}}</div>

								<div style="position:absolute;top:78%;left:57%;max-width:30%">
									<b>{{currentSurveyPart.sections.wayToShowLearning.title[language]}}</b>
								</div>
								<div style="position:absolute;top:81%;left:56%;max-width:30%">{{currentSurveyPart.sections.wayToShowLearning.textVal}}</div>

								<div style="position:absolute;top:22%;left:58%;max-width:25%">
									<b>{{currentSurveyPart.sections.topic.title[language]}}</b>
								</div>
								<div style="position:absolute;top:25%;left:58%;max-width:25%">{{currentSurveyPart.sections.topic.textVal}}</div>

								<div style="position:absolute;top:61%;left:23%;max-width:30%">
									<b>{{currentSurveyPart.sections.action.title[language]}}</b>
								</div>
								<div style="position:absolute;top:64%;left:23%;max-width:30%">{{currentSurveyPart.sections.action.textVal}}</div>

								<div style="position:absolute;top:62%;left:55%;max-width:30%">
									<b>{{currentSurveyPart.sections.product.title[language]}}</b>
								</div>
								<div style="position:absolute;top:65%;left:55%;max-width:30%">{{currentSurveyPart.sections.product.textVal}}</div>

								<div style="position:absolute;top:38%;left:40%;max-width:30%">
									<b>{{currentSurveyPart.sections.activity.title[language]}}</b>
								</div>
								<div style="position:absolute;top:41%;left:30%;">
									<textarea style="box-sizing:border-box;width:140%;height:70px" ng-model="dreamSheetActivity" ng-change="setDreamSheetActivity(dreamSheetActivity)"></textarea>
								</div>

							</div>

						</div>
					</div>
				</div>

				<div class="panel-body" ng-show="currentSurveyPart.partType=='DREAM'">
					<div class="row">
					</div>
				</div>
				<!-- End Dream Template -->

				</div>

			<div class="row content-row settings-row" style="padding-bottom: 40px;">

				<div class="col-xs-12 col-sm-10 col-sm-offset-1 text-left button-row">				
					<button class="btn btn-special" ng-click="showSummaryOnly=true;loadSurveyByPartId(6)">Summary</button>
					<button class="btn btn-special" ng-click="showSummaryOnly=false;loadSurveyByPartId(6);">Dream Sheet</button>

					<button ng-show="currentSurveyPart.partId<5" class="btn" style="float:right;" ng-click="loadSurveyByPartId(currentSurveyPart.partId + 1)" 
						 aria-hidden="true">{{navMessages.next[language]}}</button>
					
					<button ng-show="currentSurveyPart.partId==5" class="btn" style="float:right;" ng-click="completePart5()" 
						 aria-hidden="true">Continue to Summary</button>	 
					
					<button ng-show="currentSurveyPart.partId>0 && currentSurveyPart.partId<6" class="btn btn-default" style="float:right;" ng-click="loadSurveyByPartId(currentSurveyPart.partId - 1)" 
						 aria-hidden="true">{{navMessages.back[language]}}</button>
				</div>

				<div id='errorPopUp' print-remove style="position:relative;top:-200px;margin:0 auto;width:375px;font-size:10pt;font-weight:bold;background-color:#e6c1c1;padding:10px;border-radius:7px;z-index:9999;"
	 				ng-show="showErrorPopUp">
					<div class="row" style="margin:5px;">{{navMessages.partIncomplete[language]}}</div>
					<div class="row" style="margin:5px;">
						<button class="btn btn-info btn-xs" style="float:right;" ng-click="showErrorPopUp=!showErrorPopUp">{{navMessages.partContinue[language]}}</button>
					</div>
				</div>


			</div>


		</div>


				
			

			
			
			<a ng-show="false" href='https://www.freepik.com/free-vector/speech-bubbles-with-halftone-dots_1111603.htm'>Designedby Freepik</a>

			<?php get_footer(); ?>


			<script type="text/javascript" src="<?=getThemePath()?>/surveyApp/static.content/survey.data.js"></script>
			<script type="text/javascript" src="<?=getThemePath()?>/surveyApp/app/pflSurveyApp.js"></script>
			<script type="text/javascript" src="<?=getThemePath()?>/surveyApp/app/pflSurveyApp.controller.js"></script>
			<script type="text/javascript" src="<?=getThemePath()?>/surveyApp/app/pflSurveyApp.service.js"></script>


</body>