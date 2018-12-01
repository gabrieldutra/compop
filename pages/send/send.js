(function(){
    angular.module('compOp')
    .controller('sendCtrl',sendCtrl);
    function sendCtrl($location, $rootScope, $window, oportunityData){
        var vm = this;
        vm.loading=false;
        vm.error=false;
        vm.success=false;
        vm.oportunity = {
            description:"",
            inscription:"",
            status: "0"
        };
        vm.send = function(){
            vm.loading=true;
            oportunityData.send(vm.oportunity).then(function(response){
                vm.loading=false;
                vm.error=false;
                vm.success=true;
            }, function(response){
                vm.loading=false;
                vm.error=true;
                vm.success=false;
            });
        }
        if(!$rootScope.globals.currentLogin) $location.path("/login");
        else vm.oportunity.creator = $rootScope.globals.currentLogin.user;
        $window.scrollTo(0, 0);
    }
}())