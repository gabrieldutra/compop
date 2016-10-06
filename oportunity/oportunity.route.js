(function(){
    angular.module('compOp').config(function($routeProvider){
        $routeProvider
        .when('/oportunity/:id', {
            templateUrl: 'oportunity/oportunity.html',
            controller: 'oportunityCtrl',
            controllerAs: 'vm'
        });
    });
}())