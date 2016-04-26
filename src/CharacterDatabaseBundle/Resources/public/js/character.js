/**
 * Created by jenz on 25.04.16.
 */
(function () {
    var app = angular.module('character',[

    ]);

    app.baseUrl = indexUrl;
    app.bundleDir = bundleDir;
    app.directive("characterList", function(){
        return{
            restrict: 'E',
            controller: ['$http', function ($http) {
                var character = this;
                character.loading = true;
                character.characters = [];
                url = app.baseUrl+'character';
                $http.get(url).success(function(data){
                    character.characters = data;
                    character.loading = false;
                });
            }],
            templateUrl: app.bundleDir+'html/directives/character-list.html',
            controllerAs: 'characterController'
        };
    });

    app.directive("characterDetails", function(){
        return{
            restrict: 'E',
            templateUrl: app.bundleDir+'html/directives/character-details.html',
            controller: ['$http', '$routeParams', "$scope", function ($http, $routeParams, $scope) {
                var characterDetail = this;
                characterDetail.description = "...";
                characterDetail.needsSubString = true;
                characterDetail.loading = true;
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

                };
                //Fill CharacterData
                characterDetail.characterDetails = null;
                url = app.baseUrl+'character/'+$routeParams.characterId;
                $http.get(url).success(function(data){
                    characterDetail.characterDetails = data;
                    characterDetail.short = data.description.length>100;
                    characterDetail.needsSubString = characterDetail.short;
                    characterDetail.loading = false;

                    characterDetail.toggleDescription();

                });
            }],
            controllerAs: 'characterDetail'
        };
    });

})();