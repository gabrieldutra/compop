(function(){
    angular.module('compOp')
    .controller('loginCtrl',loginCtrl);
    function loginCtrl($location, userData){
        var vm = this;
        vm.email = "";
        vm.password = "";
        vm.login = function(){
            userData.login(vm.email,vm.password).then(function(response){
                if(response.data.result) $location.path("/");
            });
        }
    }
}())