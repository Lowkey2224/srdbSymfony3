/**
 * Created by jenz on 25.04.16.
 */
(function () {
    var app = angular.module('character', []);

    app.baseUrl = indexUrl;
    app.bundleDir = bundleDir;
    app.directive("characterList", function () {
        return {
            restrict: 'E',
            controller: ['$http', 'userService', function ($http, userService) {
                var character = this;
                character.loading = true;
                character.isLoggedIn = userService.isLoggedIn;
                character.characters = [];
                url = app.baseUrl + 'character';
                $http.get(url).then(function (request) {
                    character.characters = request.data;
                    character.loading = false;
                }, function (request) {
                    character.characters = {'code': request.status};
                    character.loading = false;
                });
            }],
            templateUrl: app.bundleDir + 'html/directives/character-list.html',
            controllerAs: 'characterController'
        };
    });

    app.directive("characterDetails", function () {
        return {
            restrict: 'E',
            templateUrl: app.bundleDir + 'html/directives/character-details.html',
            controller: ['$http', '$routeParams', "$scope", function ($http, $routeParams, $scope) {
                var characterDetail = this;
                characterDetail.description = "...";
                characterDetail.needsSubString = true;
                characterDetail.loading = true;
                characterDetail.short = false;
                //Toggle the length of Description
                characterDetail.toggleDescription = function () {
                    if (characterDetail.short) {
                        if(characterDetail.characterDetails.description > 100){
                            characterDetail.description = characterDetail.characterDetails.description.substring(0, 100) + "...";
                            characterDetail.short = false;
                        }
                    } else {
                        characterDetail.description = characterDetail.characterDetails.description;
                        characterDetail.short = true;
                    }

                };
                //Fill CharacterData
                characterDetail.characterDetails = null;
                url = app.baseUrl + 'character/' + $routeParams.characterId;
                $http.get(url).then(function (request) {
                    characterDetail.characterDetails = request.data;
                    characterDetail.short = request.data.description.length > 100;
                    characterDetail.needsSubString = characterDetail.short;
                    characterDetail.loading = false;

                    characterDetail.toggleDescription();

                }, function (request) {
                    characterDetail.characterDetails = {'code': request.status};
                    characterDetail.loading = false;
                });
            }],
            controllerAs: 'characterDetail'
        };
    });

})();