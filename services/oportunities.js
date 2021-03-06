(function(){
    angular.module('compOp')
    .factory("oportunityData",oportunityData);
    
    function oportunityData($http){
        var baseUrl = "api";
        
        var services = {
          getFeatured: getFeatured,
          getRecent: getRecent,
          getResult: getResult,
          send: send,
          getOportunity: getOportunity,
          getInterested: getInterested,
          getUserInterests:getUserInterests  
        };
        
        return services;
        
        function getFeatured(limit){
            var featuredUrl=baseUrl+"/featured";
            if(limit != 0)featuredUrl+="?limit="+limit;
            return $http.get(featuredUrl, {cache: true}).then(function(response){
                return response;
            });
        }
        
        function getRecent(limit){
            var recentUrl=baseUrl+"/recent";
            if(limit != 0)recentUrl+="?limit="+limit;
            return $http.get(recentUrl, {cache: true}).then(function(response){
                return response;
            });
        }

        function send(oportunity){
            var send=baseUrl+"/oportunities";
            return $http.post(send, oportunity)
        }
        
        function getResult(key){
            var resultUrl=baseUrl+"/oportunities";
            if(key != "")resultUrl+="?keyword="+key;
            return $http.get(resultUrl, {cache: true}).then(function(response){
                return response;
            });
        }
        
        function getOportunity(id){
            var oportunityUrl=baseUrl+"/oportunities/"+id;
            return $http.get(oportunityUrl, {cache: true}).then(function(response){
                return services.getInterested(id).then(function(responseI){
                    response.data.interested = responseI.data;
                    return response;
                });
            }, function(response){
                return response;
            });
        }

        function getInterested(id){
            var interestedUrl=baseUrl+"/interests?oportunity_id="+id;
            return $http.get(interestedUrl).then(function(response){
                return response;
            });
        }

        function getUserInterests(uid){
            var resultUrl=baseUrl+"/oportunities";
            resultUrl+="?user="+uid;
            return $http.get(resultUrl).then(function(response){
                return response;
            });
        }
    }
}())