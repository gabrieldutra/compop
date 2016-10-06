(function(){
    angular.module('compOp')
    .controller('loginCtrl',loginCtrl);
    function loginCtrl($location, userData){
        var vm = this;
        vm.email = "";
        vm.password = "";
        vm.user={};
        vm.loadingL=false;
        vm.errorL=false;
        vm.loadingR=false;
        vm.errorR=false;
        vm.successR=false;
        vm.login = function(){
            vm.loadingL=true;
            userData.login(vm.email,vm.password).then(function(response){
                vm.loadingL=false;
                if(response.data.result) $location.path("/");
            }, function(response){
                vm.errorL=true;
                vm.loadingL=false;
            });
        }
        vm.register = function(){
            vm.loadingR=true;
            userData.register(vm.user).then(function(response){
                vm.loadingR=false;
                vm.successR=true;
                vm.errorR=false;
                vm.user={};
            }, function(response){
                vm.loadingR=false;
                vm.errorR=true;
                vm.successR=false;
            });
        }
    }
}())