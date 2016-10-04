(function(){
    angular.module('compOp')
    .controller('oportunityCtrl',oportunityCtrl);
    function oportunityCtrl($location, $routeParams, $window, oportunityData, timeAgo){
        var vm = this;
        vm.oportunity = {};
        vm.error = false;
        vm.loaded=false;
        vm.loadOportunity = function(){
            oportunityData.getOportunity($routeParams.id).then(function(response){
                if(response.status == 200) {
                    vm.oportunity = response.data;
                    vm.loaded=true;
                }
                else vm.error=true;
            });
        }
        $window.scrollTo(0, 0);
        vm.loadOportunity();
    }
}())