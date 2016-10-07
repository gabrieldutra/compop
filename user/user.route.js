(function(){
    angular.module('compOp').config(function($routeProvider){
        $routeProvider
        .when('/user/:id', {
            templateUrl: 'user/user.html',
            controller: 'userCtrl',
            controllerAs: 'vm'
        });
    });
}())