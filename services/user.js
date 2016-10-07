(function(){
    angular.module('compOp')
    .factory("userData",userData);
    
    function userData($http, $cookieStore, $rootScope, oportunityData){
        var baseUrl = "api";
        
        var services = {
            login: login,
            register: register,
            update: update,
            currentUser: currentUser,
            clearUserData: clearUserData,
            getUser: getUser,
            addInterest: addInterest,
            removeInterest: removeInterest,
            getMyInterests: getMyInterests
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
        
        function update(user){
            return $http.put(baseUrl+"/users/"+user.id,user).then(function(response){
                return response;
            });
        }
        
        function currentUser(){ 
            return $http.get(baseUrl+"/users/0").then(function(response){
                return response.data;
            }, function(response){
                services.clearUserData();
                return response;
            });
        }
        
        function getUser(id){ 
            return $http.get(baseUrl+"/users/"+id).then(function(response){
                return response.data;
            });
        }
        
        function clearUserData(){            
            $rootScope.globals = {};
            $cookieStore.remove('globals');
            $http.defaults.headers.common.AuthKey = '';
        }

        function addInterest(oid){
            var obj={"oportunity_id": oid}
            return $http.post(baseUrl+"/interests", obj).then(function(response){
                return response;
            });
        }

        function removeInterest(oid){
            return $http.delete(baseUrl+"/interests/"+oid).then(function(response){
                return response;
            });
        }

        function getMyInterests(){
            if($rootScope.globals.currentLogin) return oportunityData.getUserInterests($rootScope.globals.currentLogin.user.id).then(function(response){
                return response.data;
            });
            else
            return oportunityData.getUserInterests(-1).then(function(response){
                return response.data;
            });
        }
      
    }
}())