(function(){
    angular.module('compOp').config(function($locationProvider, $routeProvider){
        $routeProvider
        .when('/send', {
            templateUrl: 'sendpage/send.html',
            controller: 'sendCtrl',
            controllerAs: 'vm'
        });
    });
}())