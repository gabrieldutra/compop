(function(){
    angular.module('compOp', ['ngSanitize','ngRoute', 'ngCookies','timeAgo','angular-loading-bar', 'ngAnimate','ng-showdown'])
    .config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
        cfpLoadingBarProvider.includeSpinner = false;
    }]).run(['$rootScope', '$cookieStore', '$http', function ($rootScope, $cookieStore, $http){
        $rootScope.globals = $cookieStore.get('globals') || {};        
        if ($rootScope.globals.currentLogin) {
            $http.defaults.headers.common['AuthKey'] = $rootScope.globals.currentLogin.auth_key;
        }
    }]);
}())