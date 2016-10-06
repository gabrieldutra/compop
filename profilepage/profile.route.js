(function(){
    angular.module('compOp').config(function($locationProvider, $routeProvider){
        $routeProvider
        .when('/profile', {
            templateUrl: 'profilepage/profile.html',
            controller: 'profileCtrl',
            controllerAs: 'vm'
        });
    });
}())