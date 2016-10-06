(function(){
    angular.module('compOp')
    .factory("userData",userData);
    
    function userData($http, $cookieStore, $rootScope){
        var baseUrl = "api";
        
        var services = {
            login: login,
            register: register,
            currentUser: currentUser,
            clearUserData: clearUserData
        };
        
        return services;
        
        function login(email, password){
            
            var log={
              "email": email,
              "password": password  
            };
            return $http.post(baseUrl+"/login",log).then(function(response){
                if(response.data.result){  
                    $rootScope.globals = {
                        currentLogin: response.data
                    };
                    $http.defaults.headers.common['AuthKey'] = response.data.auth_key; 
                    $cookieStore.put('globals', $rootScope.globals);                    
                }
                return response;
            });
        }
        
        function register(user){
            return $http.post(baseUrl+"/users",user).then(function(response){
                return response;
            });
        }
        
        function currentUser(){ 
            return $http.get(baseUrl+"/users/0").then(function(response){
                return response.data;
            }, function(response){
                services.clearUserData();
                return {};
            });
        }
        
        function clearUserData(){            
            $rootScope.globals = {};
            $cookieStore.remove('globals');
            $http.defaults.headers.common.AuthKey = '';
        }
      
    }
}())