(function(){
    angular.module('compOp').config(function($routeProvider){
        $routeProvider
        .when('/search', {
            templateUrl: 'pages/search/search.html',
            controller: 'searchCtrl',
            controllerAs: 'vm'
        })
        .when('/search/:key', {
            templateUrl: 'pages/search/search.html',
            controller: 'searchCtrl',
            controllerAs: 'vm'
        });
    });
}())