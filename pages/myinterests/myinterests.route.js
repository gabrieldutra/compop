(function(){
    angular.module('compOp').config(function($locationProvider, $routeProvider){
        $routeProvider
        .when('/myinterests', {
            templateUrl: 'pages/myinterests/myinterests.html',
            controller: 'myInterestsCtrl',
            controllerAs: 'vm'
        });
    });
}())