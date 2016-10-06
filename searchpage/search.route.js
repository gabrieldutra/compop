(function(){
    angular.module('compOp').config(function($routeProvider){
        $routeProvider
        .when('/search', {
            templateUrl: 'searchpage/search.html',
            controller: 'searchCtrl',
            controllerAs: 'vm'
        })
        .when('/search/:key', {
            templateUrl: 'searchpage/search.html',
            controller: 'searchCtrl',
            controllerAs: 'vm'
        });
    });
}())