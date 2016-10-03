(function(){
    angular.module('compOp')
    .factory("oportunityData",oportunityData);
    
    function oportunityData($http){
        var baseUrl = "api";
        
        var services = {
          getFeatured: getFeatured,
          getRecent: getRecent,
          getResult: getResult  
        };
        
        return services;
        
        function getFeatured(limit){
            var featuredUrl=baseUrl+"/featured";
            if(limit != 0)featuredUrl+="?limit="+limit;
            return $http.get(featuredUrl, {cache: true}).then(function(response){
                return response.data;
            });
        }
        
        function getRecent(limit){
            var recentUrl=baseUrl+"/recent";
            if(limit != 0)recentUrl+="?limit="+limit;
            return $http.get(recentUrl, {cache: true}).then(function(response){
                return response.data;
            });
        }
        
        function getResult(key){
            var resultUrl=baseUrl+"/oportunities";
            if(key != "")resultUrl+="?keyword="+key;
            return $http.get(resultUrl, {cache: true}).then(function(response){
                return response;
            });
        }
    }
}())