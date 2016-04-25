/**
 * Created by jenz on 25.04.16.
 */
(function () {
    var app = angular.module('character',[

    ]);

    app.baseUrl = function() {
        return "app_dev.php/";
    };

    app.directive("characterList", function(){
        return{
            restrict: 'E',
            templateUrl: 'bundles/characterdatabase/html/directives/character-list.html',
            controller: ['$http', function ($http) {

                var character = this;
                character.characters = [];
                url = app.baseUrl()+'character';
                console.log(url);
                $http.get(url).success(function(data){
                    character.characters = data;
                    console.log(data, "Character App ")
                });
            }],
            controllerAs: 'characterController'
        };
    });

})();