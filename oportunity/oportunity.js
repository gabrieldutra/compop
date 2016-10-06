(function(){
    angular.module('compOp')
    .controller('oportunityCtrl',oportunityCtrl);
    function oportunityCtrl($location, $routeParams, $window, $rootScope, userData, oportunityData, timeAgo){
        var vm = this;
        vm.oportunity = {};
        vm.error = false;
        vm.loaded=false;
        vm.interestButton=true;
        vm.interested=false;
        vm.loadOportunity = function(){
            oportunityData.getOportunity($routeParams.id).then(function(response){
                if(response.status == 200) {
                    vm.oportunity = response.data;
                    vm.loaded=true;
                    vm.isUserInterested();
                }
                else vm.error=true;
            });
        }
        vm.interest = function(){
            if(vm.interestButton) if(!$rootScope.globals.currentLogin) $location.path("login");
            else {
                vm.interestButton=false;
                var func=userData.addInterest;
                if(vm.interested) func=userData.removeInterest;
                func($routeParams.id).then(function(responseF){
                    oportunityData.getInterested($routeParams.id).then(function(response){
                        vm.oportunity.interested = response.data;
                        vm.interestButton=true;
                        vm.isUserInterested();
                    });
                }, function(responseF){
                    oportunityData.getInterested($routeParams.id).then(function(response){
                        vm.oportunity.interested = response.data;
                        vm.interestButton=true;
                        vm.isUserInterested();
                    });
                });
            }
        }
        vm.isUserInterested = function(){
            var result = false;
            if($rootScope.globals.currentLogin){
                if(vm.oportunity.interested){
                    vm.oportunity.interested.forEach(function(user){
                        if(user.user_id == $rootScope.globals.currentLogin.user.id) result=true;
                    });
                }
            }
            vm.interested = result;
        }
        $window.scrollTo(0, 0);
        vm.loadOportunity();
    }
}())