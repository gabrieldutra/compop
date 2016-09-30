var app = angular.module('compOp', ['ngSanitize','ngRoute','timeAgo','angular-loading-bar', 'ngAnimate']);

app.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
  }]);