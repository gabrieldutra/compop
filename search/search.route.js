(function(){
    angular.module('compOp').config(function($routeProvider){
        $routeProvider
        .when('/search/:key', {
            templateUrl: 'search/search.html',
            controller: 'searchCtrl',
            controllerAs: 'vm'
        });
    });
}())