(function(){
    angular.module('compOp')
    .controller('userCtrl',userCtrl);
    function userCtrl($location, $routeParams, $window, $rootScope, userData, oportunityData){
        var vm = this;
        vm.user = {};
        vm.loading = true;
        vm.error = false;
        vm.interests = [];
        vm.loadUser = function(){
            userData.getUser($routeParams.id).then(function(response){
                if(response) {
                    oportunityData.getUserInterests(response.id).then(function(responseI){
                        vm.loading=false;
                        vm.user=response;
                        vm.interests = responseI.data;
                    });
                } else {
                    vm.error=true;
                    vm.loading=false;
                }
            });
        }
        vm.loadUser();
        $window.scrollTo(0, 0);
    }
}())