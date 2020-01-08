app.service("pflSurveyService", function ($http, $q) {
		
		//public api
		return({
			getSurveyNavMessages:getSurveyNavMessages,
			getFavNumErrorMessages:getFavNumErrorMessages,
			getSurveyTitle:getSurveyTitle,
			getPartTitles:getPartTitles,
			getPartShortTitles:getPartShortTitles,
			getSurveyRatings:getSurveyRatings,
			getSurveyQuestionsByPart:getSurveyQuestionsByPart,
			getPartFavorites:getPartFavorites,
			getSelectedListData:getSelectedListData,
			isCompatibleVersion
			
        });	
		
		
		function getSurveyNavMessages(){return navMessages;			}
		function getFavNumErrorMessages(){return favNumErrorMessages;}
		function getSurveyQuestionsByPart(partId){return pflSurvey[partId];			}
		function getSurveyTitle(lang){ return surveyTitle[lang];}
		function getPartTitles(lang){return alasql('select partId, partTitle, isComplete from ?',[pflSurvey])}
		function getSurveyRatings(){return surveyRatings;}
		function getPartShortTitles(lang){return alasql('select partId, partShortTitle, isComplete from ?',[pflSurvey])}
 
		function getPartFavorites(partId, type){

			//type is either "most" or "least"
			var favs=alasql('select favorites from ? where partId='+partId,[pflSurvey])[0];
			
			//limitted for now to just a and b
			var favIds=[favs.favorites[type].data.a,favs.favorites[type].data.b]; 
			if(!favIds[0]||!favIds[1]){return [];}
			
			//handle index starts
			var qIndex=alasql('select questionIndex from ? where partId='+partId,[pflSurvey])[0];
			favIds[0]=favIds[0]-qIndex.questionIndex.start + 1;
			favIds[1]=favIds[1]-qIndex.questionIndex.start + 1; 
			
			var partQuestions=alasql('select questions from ? where partId='+partId,[pflSurvey])[0].questions;
			var statements = alasql('select text from ? where id in ('+favIds.join(',')+')',[partQuestions]);
			
			return statements;
			
		}
		
		function getSelectedListData(){

			//type is either "most" or "least"
			var lists=alasql('select listSections from ? where partId=5',[pflSurvey])[0].listSections;
			
			//topics
			var topics= alasql('select sectionItems from ? where sectionId=1',[lists])[0].sectionItems;
			var selectedTopics=alasql('select itemText from ? where selected is not null',[topics]);
			
			var ways= alasql('select sectionItems from ? where sectionId=2',[lists])[0].sectionItems;
			var selectedWays=alasql('select itemText from ? where selected is not null',[ways]);

			var shows= alasql('select sectionItems from ? where sectionId=3',[lists])[0].sectionItems;
			var selectedShows=alasql('select itemText from ? where selected is not null',[shows]);

						
			return {
				topics:selectedTopics,
				ways:selectedWays,
				show:selectedShows
			};
			
				
			//return statements;
			
		}
		
		function updateV2ToV3(curPflSurvey){
			console.log("attempt to updateV2ToV3");
			for(var i=0;i<curPflSurvey.length;i++){
				if(curPflSurvey[i].version!=2){continue;}
				curPflSurvey[i].version=3; //incremental version update

				//reorder question IDs in part 4
				if(curPflSurvey[i].partId==4){					
					for(var j=0;j<curPflSurvey[i].questions.length;j++){
						curPflSurvey[i].questions[j].id=(j+1);
					}
				}
			}
		}

		function isCompatibleVersion(curPflSurvey){	

			//update code:
			updateV2ToV3(curPflSurvey);

			var versions=alasql('select version from ?' ,[curPflSurvey]);
			console.log('isCompatibleVersion', surveyVersion, versions);
			for(var i=0;i<versions.length;i++){
				console.log(versions[i].version, surveyVersion);
				if(versions[i].version!=surveyVersion){return false;}
			}
			return true;
		}		
		
//end of service
});