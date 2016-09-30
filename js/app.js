(function(){
    angular.module('compOp', ['ngSanitize','ngRoute','timeAgo','angular-loading-bar', 'ngAnimate'])
    .config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
        cfpLoadingBarProvider.includeSpinner = false;
    }]);
}())