(function(){
    angular.module('compOp').config(function($locationProvider, $routeProvider){
        $routeProvider
        .when('/about', {
            templateUrl: 'pages/about/about.html',
            controller: 'generalCtrl',
            controllerAs: 'vm'
        });
    });
}())