(function(){
    angular.module('compOp').config(function($locationProvider, $routeProvider){
        $routeProvider
        .when('/profile', {
            templateUrl: 'pages/profile/profile.html',
            controller: 'profileCtrl',
            controllerAs: 'vm'
        });
    });
}())