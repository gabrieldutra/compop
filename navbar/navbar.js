(function(){
    angular.module('compOp')
    .controller('navbarCtrl',navbarCtrl);
    function navbarCtrl(userData){
        var vm = this;
        
        vm.logout = function(){
            userData.clearUserData();
        }
        
        userData.currentUser();
    }
}())