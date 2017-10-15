app.service("pflMatrixService", function ($http, $q) {
		
		//public api
		return({
			getIndicatorList:getIndicatorList,
			getOrderedIndicatorList:getOrderedIndicatorList,
			getDifferentiationOptions:getDifferentiationOptions,
			initDifferentiationOptionsRanking:initDifferentiationOptionsRanking,
			updateDifferentiationOptionsRanking:updateDifferentiationOptionsRanking
        });	
		
		
		function getIndicatorList(){
			return pflMatrix.indicators;			
		}

		function getOrderedIndicatorList(){
			//very hack way to do this....
			var orderedIndicators = [];
			for(var i=0; i < Object.keys(pflMatrix.indicators).length;i++){
				orderedIndicators.push({});
			}
			for(var diffInd in pflMatrix.indicators){
				orderedIndicators[pflMatrix.indicators[diffInd].dispOrder]=diffInd;
			}
			
			return orderedIndicators;
			
		}
		
		function getDifferentiationOptions(){
			return pflMatrix.diffOptions;
		}
		
		function initDifferentiationOptionsRanking(){
			var diffOptsRank={};
			for(var diffOpt in pflMatrix.diffOptions){
				diffOptsRank[diffOpt]={}; 
				diffOptsRank[diffOpt].availIndicators=angular.copy(pflMatrix.diffOptions[diffOpt].indicators); 
				diffOptsRank[diffOpt].selectedIndicators=[];
				diffOptsRank[diffOpt].rank=0; //defaults to all being possible options
				diffOptsRank[diffOpt].displayRank=''; 
			}
			//console.log('diffOptsRank',diffOptsRank);
			return diffOptsRank;
		}		
	
		
		function setTopRecomendedStrats(diffOptsRank){
			// - show all with a ranking of 1
			// - if less than 3 1s, show 1s and 2s
			// - if less than 2 2s, show 1s, 2s and 3s
			
			var topRankedStrategies=[];
			var rank1s=[];
			var rank2s=[];
			var rank3s=[];						
			
			for(var diffOpt in diffOptsRank){
				if(diffOptsRank[diffOpt].displayRank==1){rank1s.push(pflMatrix.diffOptions[diffOpt].id);continue;}
				if(diffOptsRank[diffOpt].displayRank==2){rank2s.push(pflMatrix.diffOptions[diffOpt].id);continue;}
				if(diffOptsRank[diffOpt].displayRank==3){rank3s.push(pflMatrix.diffOptions[diffOpt].id);continue;}
			}						
			
			topRankedStrategies=rank1s; //start with 1s
			if(rank1s.length<3){
				topRankedStrategies=topRankedStrategies.concat(rank2s);//add 2s
				if(rank2s.length<2){topRankedStrategies=topRankedStrategies.concat(rank3s);} //add 3s					
			} 			
			
			return topRankedStrategies;
		}
	
		function updateDifferentiationOptionsRanking(selectedIndicator, isSelected, diffOptsRank){
			//console.log('updateDifferentiationOptionsRanking',diffOptsRank);
			var ranksClusters=[];						
			//console.log("updateDifferentiationOptionsRanking",selectedIndicator,isSelected);
			for(var diffOpt in diffOptsRank){
				if(diffOptsRank[diffOpt].availIndicators.indexOf(selectedIndicator)>=0){ //is this in the available indecators?
					var index = diffOptsRank[diffOpt].selectedIndicators.indexOf(selectedIndicator); //has it already been selected?
					if(isSelected && index<0){ //add to selected
						diffOptsRank[diffOpt].selectedIndicators.push(selectedIndicator);
					}
					else if(!isSelected && index>=0){ //remove from selected
						diffOptsRank[diffOpt].selectedIndicators.splice(index,1);
					}					
					diffOptsRank[diffOpt].rank = Math.floor((diffOptsRank[diffOpt].selectedIndicators.length * 100)/diffOptsRank[diffOpt].availIndicators.length);
					//console.log(diffOpt,diffOptsRank[diffOpt]);
				}
				if(ranksClusters.indexOf(diffOptsRank[diffOpt].rank)<0){
					ranksClusters.push(diffOptsRank[diffOpt].rank);
				}
			}
			ranksClusters.sort(function(a,b){return b-a;});
			console.log('ranksClusters',ranksClusters);
			
			//there is no single behaviour that is attributed to a single strategy.
			var topRankedStrategies=[];
			if(ranksClusters.length>1){				
				for(var diffOpt in diffOptsRank){
					diffOptsRank[diffOpt].displayRank = ranksClusters.indexOf(diffOptsRank[diffOpt].rank) + 1; //diffOptsRank[diffOpt].rank
					/*if((diffOptsRank[diffOpt].displayRank>0&&diffOptsRank[diffOpt].displayRank<=3) && topRankedStrategies.length<3){
						topRankedStrategies.push(pflMatrix.diffOptions[diffOpt].id);
					}*/
				}
				topRankedStrategies=setTopRecomendedStrats(diffOptsRank);
			}
			else{
				if(ranksClusters.length<1 ||ranksClusters[0]==0){
					//clear out ranks
					for(var diffOpt in diffOptsRank){diffOptsRank[diffOpt].displayRank = null;}												
				}
				else if(ranksClusters.length=1 && ranksClusters[0]==100){
					//set all ranks to 1
					for(var diffOpt in diffOptsRank){diffOptsRank[diffOpt].displayRank = 1;}	
					topRankedStrategies=setTopRecomendedStrats(diffOptsRank);					
				}

			}
			

			return topRankedStrategies;
		}
	
 
//end of service
});