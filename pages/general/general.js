(function(){
    angular.module('compOp')
    .controller('generalCtrl',generalCtrl);
    function generalCtrl($window){        
        $window.scrollTo(0, 0);
    }
}())