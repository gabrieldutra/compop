(function(){
    angular.module('compOp').config(function($routeProvider){
        $routeProvider
        .when('/', {
            templateUrl: 'home/home.html',
            controller: 'homeCtrl',
            controllerAs: 'vm'
        }).otherwise({
            redirectTo: '/'
        });
    });
}())