/**
 * Created by jenz on 01.03.16.
 */

(function () {
    var app = angular.module('srdb', [
        'mobile-angular-ui',
        'ngRoute',
        'mobile-angular-ui.gestures',
        'character'
    ]);


    app.bundleDir = bundleDir;
    app.baseUrl = indexUrl;


    app.controller('CharacterController', ['$http', '$log', function ($http, $log) {
        var character = this;
        character.characters = [];
        url = app.baseUrl + 'character';
        $http.get(url).success(function (data) {
            character.characters = data;
        });
    }]);

    app.config(function ($routeProvider) {

        $routeProvider.when('/', {templateUrl: app.bundleDir+'html/home.html', reloadOnSearch: false});
        $routeProvider.when('/new', {templateUrl: app.bundleDir+'html/scroll.html', reloadOnSearch: false});
        $routeProvider.when('/mine', {
            templateUrl: app.bundleDir+'html/toggle.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/character/:characterId', {
            templateUrl: app.bundleDir+'html/character-show.html',
            //reloadOnSearch: false
        });
        $routeProvider.when('/all', {
            templateUrl: app.bundleDir+'html/characters.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/skills', {
            templateUrl: app.bundleDir+'html/accordion.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/specs', {
            templateUrl: app.bundleDir+'html/overlay.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/attributes', {
            templateUrl: app.bundleDir+'html/forms.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/traditions', {
            templateUrl: app.bundleDir+'html/dropdown.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/totems', {
            templateUrl: app.bundleDir+'html/touch.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/cyberware', {
            templateUrl: app.bundleDir+'html/swipe.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/logout', {
            templateUrl: app.bundleDir+'html/drag.html',
            reloadOnSearch: false
        }).otherwise({
            redirectTo: '/all'
        });
    });


})();
