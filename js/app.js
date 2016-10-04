(function(){
    angular.module('compOp', ['ngSanitize','ngRoute','timeAgo','angular-loading-bar', 'ngAnimate','ng-showdown'])
    .config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
        cfpLoadingBarProvider.includeSpinner = false;
    }]);
}())