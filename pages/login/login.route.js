(function(){
    angular.module('compOp').config(function($locationProvider, $routeProvider){
        $routeProvider
        .when('/login', {
            templateUrl: 'pages/login/login.html',
            controller: 'loginCtrl',
            controllerAs: 'vm'
        });
    });
}())