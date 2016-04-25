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
                });
            }],
            controllerAs: 'characterController'
        };
    });

    app.directive("characterDetails", function(){
        return{
            restrict: 'E',
            templateUrl: 'bundles/characterdatabase/html/directives/character-details.html',
            controller: ['$http', '$routeParams', "$scope", function ($http, $routeParams, $scope) {
                var characterDetail = this;
                characterDetail.description = "...";
                characterDetail.needsSubString = true;
                characterDetail.short = false;
                //Toggle the length of Description
                characterDetail.toggleDescription = function(){
                    if(characterDetail.short){
                        characterDetail.description = characterDetail.characterDetails.description.substring(0,100)+"...";
                        characterDetail.short = false;
                    }else{
                        characterDetail.description = characterDetail.characterDetails.description;
                        characterDetail.short = true;
                    }
                    console.log("length", characterDetail.description.length);
                };
                //Fill CharacterData
                characterDetail.characterDetails = null;
                url = app.baseUrl()+'character/'+$routeParams.characterId;
                $http.get(url).success(function(data){
                    characterDetail.characterDetails = data;
                    characterDetail.short = data.description.length>100;
                    characterDetail.needsSubString = characterDetail.short;

                    characterDetail.toggleDescription();

                });
            }],
            controllerAs: 'characterDetail'
        };
    });

})();