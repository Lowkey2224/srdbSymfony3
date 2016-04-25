/**
 * Created by jenz on 25.04.16.
 */
(function () {
    var app = angular.module('character',[

    ]);

    app.baseUrl = function() {
        if(window.location.pathname.indexOf("app_dev.php") > 0){
            return "app_dev.php/";
        }
        return "";
    };

    app.directive("characterList", function(){
        return{
            restrict: 'E',
            templateUrl: 'bundles/characterdatabase/html/directives/character-list.html',
            controller: ['$http', function ($http) {

                var character = this;
                character.characters = [];
                url = app.baseUrl()+'character';
                console.log("Getting data from: ", url);
                $http.get(url).success(function(data){
                    character.characters = data;
                    console.log("received data for all", data)
                });
            }],
            controllerAs: 'characterController'
        };
    });

    app.directive("characterDetails", function(){
        return{
            restrict: 'E',
            templateUrl: 'bundles/characterdatabase/html/directives/character-details.html',
            controller: ['$http', '$routeParams', function ($http, $routeParams) {

                var characterDetail = this;
                characterDetail.characterDetails = null;
                url = app.baseUrl()+'character/'+$routeParams.characterId;
                console.log("Details Url", url);
                $http.get(url).success(function(data){
                    characterDetail.characterDetails = data;
                    console.log("Details ", data)
                });
            }],
            controllerAs: 'characterDetail'
        };
    });

})();