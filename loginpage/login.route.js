(function(){
    angular.module('compOp').config(function($locationProvider, $routeProvider){
        $routeProvider
        .when('/login', {
            templateUrl: 'loginpage/login.html',
            controller: 'loginCtrl',
            controllerAs: 'vm'
        });
    });
}())