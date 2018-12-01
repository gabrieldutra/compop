(function(){
    angular.module('compOp')
    .controller('homeCtrl',homeCtrl);
    function homeCtrl($location, $rootScope, oportunityData, timeAgo, userData){
        var vm = this;
        vm.morefeatured=false;
        vm.morerecent=false;
        vm.f=0;
        vm.r=0;
        vm.featured = [];
        vm.recent = [];
        vm.loadingF = false;
        vm.loadingO = false;
        vm.search="";
        vm.loadFeatured = function(){
            vm.f+=4;
            vm.loadingF=true;
            oportunityData.getFeatured(vm.f).then(function(response){
                vm.loadingF=false;
                vm.featured = response.data;
                if(vm.featured.length == vm.f) vm.morefeatured=true; 
                else vm.morefeatured=false;
            });            
        }
        vm.loadRecent = function(){
            vm.r+=4;
            vm.loadingR=true;
            oportunityData.getRecent(vm.r).then(function(response){
                vm.loadingR=false;
                vm.recent = response.data;
                if(vm.recent.length == vm.r) vm.morerecent=true; 
                else vm.morerecent=false;
            });     
        }
        vm.loadOportunities = function(){
            vm.loadFeatured();
            vm.loadRecent();
        }
        
        vm.searchOp = function(){
            $location.path("search/"+encodeURIComponent(vm.search));
        }
        vm.loadOportunities();
    }
}())