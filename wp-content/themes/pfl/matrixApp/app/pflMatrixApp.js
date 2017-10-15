var app = angular.module('pflMatrixApp', ['AngularPrint'])

;

app.config(function() {},
[
	"$httpProvider",
	function($httpProvider) {
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
		if (!$httpProvider.defaults.headers.get) {
			$httpProvider.defaults.headers.get = {};    
		}		
		$httpProvider.defaults.headers.get['Cache-Control'] = 'no-cache'; 
		$httpProvider.defaults.headers.get['Pragma'] = 'no-cache';
 //disable IE ajax request caching
  $httpProvider.defaults.headers.get['If-Modified-Since'] = '0';
		
    }
]
	
);
