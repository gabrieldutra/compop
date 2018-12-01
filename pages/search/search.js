(function(){
    angular.module('compOp')
    .controller('searchCtrl',searchCtrl);
    function searchCtrl($location, $routeParams, oportunityData, timeAgo){
        var vm = this;
        vm.result = [];
        vm.loading = true;
        vm.empty=false;
        vm.search=$routeParams.key || "";
        vm.loadOportunities = function(){
            oportunityData.getResult(vm.search).then(function(response){
                vm.result = response.data;
                if(response.status == 204) vm.empty=true;
                vm.loading=false;
            });
        }
        
        vm.searchOp = function(){
            $location.path("search/"+encodeURIComponent(vm.search));
        }
        vm.loadOportunities();
    }
}())