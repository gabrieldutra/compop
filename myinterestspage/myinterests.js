(function(){
    angular.module('compOp')
    .controller('myInterestsCtrl',myInterestsCtrl);
    function myInterestsCtrl($window, userData){
        var vm = this;
        vm.loading=true;
        vm.interests=[];

        vm.loadInterests = function(){
            vm.loading=true;
            userData.getMyInterests().then(function(response){
                vm.loading=false;
                vm.interests=response;
            });
        }
        vm.loadInterests();
        $window.scrollTo(0, 0);        
    }
}())