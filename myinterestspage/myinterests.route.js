(function(){
    angular.module('compOp').config(function($locationProvider, $routeProvider){
        $routeProvider
        .when('/myinterests', {
            templateUrl: 'myinterestspage/myinterests.html',
            controller: 'myInterestsCtrl',
            controllerAs: 'vm'
        });
    });
}())