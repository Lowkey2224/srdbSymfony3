/**
 * Created by jenz on 01.03.16.
 */

(function () {
    var app = angular.module('srdb', [
        'mobile-angular-ui',
        'ngRoute',
        'mobile-angular-ui.gestures',
        'character',
        'form',
        'skills',
        'Utildirectives'
    ]);

    app.service('CharacterService', ['$http', function ($http) {
        /**
         * Get Character for users null all users, me for the current user int for userId
         *
         * @param callback callable successcallbackmethod
         * @param errorCallback callable errorcallback
         * @param forUser "me"|null|int
         * @returns {Array|*}
         */
        this.getCharacters = function (callback, errorCallback, forUser) {
            var url = app.baseUrl + 'character';
            if(forUser) {
                if (forUser == 'me') {
                    url += "/mine";
                }
                else if (forUser.match(/\d/)) {
                    url += "/user/"+forUser;
                }
            }
            $http.get(url).then(function (request) {
                callback(request);
            }, function (request) {
                if(errorCallback){
                    errorCallback(request);
                }
            });
        }
    }]);

    app.service('userService', ['$http', function ($http) {
        this.isLoggedIn = function () {
            url = app.baseUrl + 'user/loggedIn';
            var f = this;
            f.logged = false;
            $http.get(url).success(function (data) {
                f.logged = data;
                console.log('Logged IN: ', f.logged);
            });
            console.log('Logged IN: ', f.logged);
            return f.logged;
        }
    }]);
    app.bundleDir = bundleDir;


    app.baseUrl = indexUrl;

    app.config(function ($routeProvider) {

        $routeProvider.when('/', {templateUrl: app.bundleDir + 'html/home.html', reloadOnSearch: false});
        $routeProvider.when('/new', {templateUrl: app.bundleDir + 'html/new-character.html', reloadOnSearch: false});

        $routeProvider.when('/edit/:characterId', {templateUrl: app.bundleDir + 'html/edit-character.html'});
        $routeProvider.when('/character/user/:userId?', {
            templateUrl: app.bundleDir + 'html/characters.html'
            //reloadOnSearch: false
        });
        $routeProvider.when('/character/:characterId', {
            templateUrl: app.bundleDir + 'html/character-show.html'
            //reloadOnSearch: false
        });
        $routeProvider.when('/skills', {
            templateUrl: app.bundleDir + 'html/skills.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/specs', {
            templateUrl: app.bundleDir + 'html/overlay.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/attributes', {
            templateUrl: app.bundleDir + 'html/forms.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/traditions', {
            templateUrl: app.bundleDir + 'html/dropdown.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/totems', {
            templateUrl: app.bundleDir + 'html/touch.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/cyberware', {
            templateUrl: app.bundleDir + 'html/swipe.html',
            reloadOnSearch: false
        });
        $routeProvider.when('/logout', {
            templateUrl: app.bundleDir + 'html/drag.html',
            reloadOnSearch: false
        }).otherwise({
            redirectTo: '/all'
        });
    });


})();
