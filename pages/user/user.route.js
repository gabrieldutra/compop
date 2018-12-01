(function(){
    angular.module('compOp').config(function($routeProvider){
        $routeProvider
        .when('/user/:id', {
            templateUrl: 'pages/user/user.html',
            controller: 'userCtrl',
            controllerAs: 'vm'
        });
    });
}())