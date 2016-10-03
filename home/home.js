(function(){
    angular.module('compOp')
    .controller('homeCtrl',homeCtrl);
    function homeCtrl($location, oportunityData, timeAgo){
        var vm = this;
        vm.featured = [];
        vm.recent = [];
        vm.loading = false;
        vm.loadOportunities = function(){
            oportunityData.getFeatured(4).then(function(response){
                vm.featured = response;
            });
            oportunityData.getRecent(4).then(function(response){
                vm.recent = response;
            });
        }
        
        vm.searchOp = function(){
            $location.path("search/"+encodeURIComponent(vm.search));
        }
        vm.loadOportunities();
    }
}())