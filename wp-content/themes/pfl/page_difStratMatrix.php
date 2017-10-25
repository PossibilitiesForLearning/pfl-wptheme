<?php /* Template name: Differentiation Strategy Matrix */ ?>
<?php
/**
 * This is a template specifically to work with the PFL differentation strategy matrix
 *
 * @package WordPress
 * @subpackage PFL
 * @since PFL 2.0
 */

get_header(); ?>

<!-- BEGINING OF HTML PAGE -->	

<body ng-cloak ng-controller="pflMatrixController" ng-app='pflMatrixApp' class="body-content body-matrix">
	
<?php include 'nav.php';?>

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
	</div>

	<div class="container-fluid breadcrumb-container hidden-xs hidden-sm" print-remove>
		<div class="row breadcrumb-row">				
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
				<?php custom_breadcrumbs(); ?>
			</div>
		</div>
	</div>

	<!-- Bottom Info Hover bar -->
	<div class="container-fluid container-infotip" print-remove>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 infotip-cell">
					<div id="matrixDefs" print-remove>
						<div class="defTitle" print-remove>Definition<i class="fa fa-times pull-right"></i></div>
						<div class="defInfo" print-remove>
							Click on a behaviour or strategy for the definition
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="primary" class="container-fluid">

		<div class="row">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 hero" print-remove>
				<em><?php the_title(); ?></em>
			</div>
		</div>

		<div class="row content-row settings-row " print-remove>

			<div class="col-xs-12 col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1 toggle-row">
				<span class="sku" ng-class="{'active' : language=='default_en'}">Teacher/Parent</span>
				<label class="switch">
					<input type="checkbox" ng-model="isStudentText" ng-click="setLanguage(isStudentText);">
					<div class="slider round"></div>
				</label>
				<span class="sku" ng-class="{'active' : language=='kids_en'}" ng-click="language!='kids_en' ? isStudentText.checked=true">Student</span>
			</div>

			<div class="col-xs-12 col-sm-5 col-md-5 text-right button-row">
				<button class="btn btn-default" ng-click="showHelp();">Instructions</button>
				<!--button class="btn" ng-click="savePflMatrix();">Save</button-->
				<label for="file-input" class="btn" >Load</label>				
				<input type="file" id="file-input" style="display:none;">
				<!--button class="btn" print-btn >Print</button-->
			</div>
		</div>

		<div class="row content-row form-row container-fluid" print-remove>					
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
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
					<div class='col-xs-12 col-md-6' ng-class="{'col-md-12' : language=='kids_en'}">
						<div class="form-group row">
							<label for="pflStrengths" class="col-form-label" ng-show="language=='default_en'">Strengths</label>
							<label for="pflStrengths" class="col-form-label" ng-show="language=='kids_en'">Things You LOVE to Learn About</label>
							<textarea class="form-control span6" rows="6" id="pflStrengths" ng-model="userInfo.pflStrengths"></textarea>
						</div>
					</div>
					<div class='col-xs-12 col-md-6' ng-show="language=='default_en'">
						<div class="form-group row">
							<label for="pflEvidence" class="col-form-label" >Dates and Descriptions of Activities Observed</label>
							<textarea class="form-control span6" rows="6" id="pflEvidence" ng-model="userInfo.pflEvidence"></textarea>
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


		<div class="row content-row matrix-heading">
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
				Differentiation Strategies
			</div>
		</div>

		<div class="row content-row matrix-row" print-section >
			<div class="col-xs-12">
				<table class="matrixTable" >
					<tr class="pflGroupRow">
						<th >
						</th>
						<th colspan=8 class="pflDiffGroups pflCont">Content</th>
						<th colspan=11 class="pflDiffGroups pflProc">Process</th>
						<th colspan=6 class="pflDiffGroups pflProd">Product</th>
					</tr>
					<tr class="stratRow">
						<th>Behaviours</th>
						
						<th ng-repeat="diffStrat in orderedDiffOptsArray"
							ng-mouseover="showDef(diffOptions[diffStrat.id])" class="infotip-mouseover"
							>
							<div ng-show="diffStrat.id!='break'" >
								<span ng-class="{'selected' :  topDiffOpts.indexOf(diffStrat.id)>=0 }" 
								class="pflDiffTitles matrix-strategy  {{diffStrat.htmlTitleClass}}">
									{{diffOptions[diffStrat.id].title}}
								</span>
							</div>
							<div  ng-show="diffStrat.id=='break'" class="breakColumn"></div>
						</th>								
						
					</tr>
					<tr class="pflRow" ng-repeat="orderedIndic in orderdIndicators">
						<td class="matrix-indicator infotip-mouseover" ng-mouseover="showDef(indicators[orderedIndic])">
							<input type="checkbox" ng-model="indicators[orderedIndic].isSelected" ng-change="updateRank(indicators[orderedIndic]);" class="checkbox-indicator">{{indicators[orderedIndic].title}}
						</td>
						<td class="pflCell" ng-repeat="diffStrat in orderedDiffOptsArray" ng-class="(diffStrat.id=='break') ? 'breakColumn':diffStrat.htmlTitleClass">
							<i ng-show="diffStrat.id!='break' && indicators[orderedIndic].isSelected && setIndicatorLocation(indicators[orderedIndic] , diffOptions[diffStrat.id])" class="fa fa-check"></i>
							<i ng-show="diffStrat.id!='break' && !indicators[orderedIndic].isSelected && setIndicatorLocation(indicators[orderedIndic], diffOptions[diffStrat.id])" class="fa fa-circle"></i>						
						</td>
																											
					</tr>
					<tr class="rankingRow" ng-show="topDiffOpts.length > 0">
						<td>Ranking</td>	
						<td class="pflRankingCell"
						ng-class="{'ranked' : topDiffOpts.indexOf(diffStrat.id)>=0}" 						
						ng-repeat="diffStrat in orderedDiffOptsArray">
							{{diffOptRankings[diffStrat.id].displayRank}}
						</td>
						
					</tr>		
				</table>	
			</div>	
		</div>	

		<div class="row content-row recommendations-row" print-section  ng-show="topDiffOpts.length > 0">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-sm-offset-1 recommendations-cell">
						<div ng-show="topDiffOpts.length>0 && topDiffOpts.length<diffOptionsCount">
							<div class="recommend-heading">Recommended Strategies</div>
							<ul class="recommendations">
								<li ng-repeat="rec in topDiffOpts"> 	
									<span class="rec-title">{{diffOptions[rec].title}}</span> : <span class="rec-description">{{diffOptions[rec].descriptions[language]}}</span>
								</li>
							</ul>	
						</div>
						<div ng-show="topDiffOpts.length > 0 && topDiffOpts.length==diffOptionsCount">
							<span>All differentiation strategies are recommended</span>
							</br></br>		
						</div>	
					</div>
				</div>				
			</div>
		</div>
		<div class="row content-row settings-row ">

			<div class="col-xs-12 col-sm-10 col-sm-offset-1 text-right button-row">
				<button class="btn" ng-click="savePflMatrix();">Save</button>
				<button class="btn" print-btn >Print</button>
			</div>
		</div>


	<div class="pageBreak"></div>
	<!-- page break -->

	<div print-section class="printOnly">
		</br></br></br></br>
		<span>Behaviours</span><br>
		<ul>
			<li ng-repeat="orderedIndic in orderdIndicators"> 				
				<span style="font-size:10px;font-weight:bold;">{{indicators[orderedIndic].title}}</span> : <span style="font-size:9px;" >{{indicators[orderedIndic].descriptions[language]}}</span>
			</li>
		</ul>	
	</div>

	<div print-section class="printOnly">
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
		

		<?php include 'footer_index.php' ?>
</div>


	<div id="helpDialog" title="Instructions" style="display:none;background-color:beige;" print-remove>
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

</div><!-- end main -->


	<?php get_footer(); ?>

	<script type="text/javascript" src="<?=getThemePath()?>/matrixApp/static.content/indicator.matrix.js"></script>
	<script type="text/javascript" src="<?=getThemePath()?>/matrixApp/app/pflMatrixApp.js"></script>
	<script type="text/javascript" src="<?=getThemePath()?>/matrixApp/app/pflMatrixApp.controller.js"></script>
	<script type="text/javascript" src="<?=getThemePath()?>/matrixApp/app/pflMatrixApp.service.js"></script>

	</body>


<!-- END OF HTML PAGE -->

