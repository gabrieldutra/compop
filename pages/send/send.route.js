(function(){
    angular.module('compOp').config(function($locationProvider, $routeProvider){
        $routeProvider
        .when('/send', {
            templateUrl: 'pages/send/send.html',
            controller: 'sendCtrl',
            controllerAs: 'vm'
        });
    });
}())