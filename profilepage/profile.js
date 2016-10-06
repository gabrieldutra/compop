(function(){
    angular.module('compOp')
    .controller('profileCtrl',profileCtrl);
    function profileCtrl($location, $window, userData){
        var vm = this;
        vm.loading=true;
        vm.error=false;
        vm.success=false;
        vm.user={};
        vm.getUser=function(){
            userData.currentUser().then(function(response){
                if(!response) $location.path("login");
                else {
                    response.registry = parseInt(response.registry);
                    response.receive_emailb = response.receive_email == "1";
                    vm.user = response;
                    vm.loading=false;
                }
            });
        }
        vm.save=function(){
            vm.loading=true;
            vm.user.receive_email = vm.user.receive_emailb ? 1 : 0;
            userData.update(vm.user).then(function(response){
                vm.loading=false;
                vm.success=true;
                vm.error=false;
            }, function(response){
                vm.error=true;
                vm.success=false;
                vm.loading=false;
            });
        }
        $window.scrollTo(0, 0);
        vm.getUser();
    }
}())