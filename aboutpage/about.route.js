(function(){
    angular.module('compOp').config(function($locationProvider, $routeProvider){
        $routeProvider
        .when('/about', {
            templateUrl: 'aboutpage/about.html',
            controller: 'generalCtrl',
            controllerAs: 'vm'
        });
    });
}())