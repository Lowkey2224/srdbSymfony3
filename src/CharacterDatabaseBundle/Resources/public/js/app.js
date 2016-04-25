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

    app.baseUrl = function() {
        //console.log("Loacation", $location, $location.absUrl(), $location.url());
        return "app_dev.php/";
    };

    app.controller('CharacterController', ['$http', '$log', function($http, $log){
        var character = this;
        character.characters = [];
        url = app.baseUrl()+'character';
        console.log(url);
        $http.get(url).success(function(data){
            character.characters = data;
            console.log(data, "yello ")
        });
    }]);

    app.config(function($routeProvider) {
        $routeProvider.when('/',              {templateUrl: 'bundles/characterdatabase/html/home.html', reloadOnSearch: false});
        $routeProvider.when('/new',        {templateUrl: 'bundles/characterdatabase/html/scroll.html', reloadOnSearch: false});
        $routeProvider.when('/mine',        {templateUrl: 'bundles/characterdatabase/html/toggle.html', reloadOnSearch: false});
        $routeProvider.when('/all',          {templateUrl: 'bundles/characterdatabase/html/characters.html', reloadOnSearch: false});
        $routeProvider.when('/skills',     {templateUrl: 'bundles/characterdatabase/html/accordion.html', reloadOnSearch: false});
        $routeProvider.when('/specs',       {templateUrl: 'bundles/characterdatabase/html/overlay.html', reloadOnSearch: false});
        $routeProvider.when('/attributes',         {templateUrl: 'bundles/characterdatabase/html/forms.html', reloadOnSearch: false});
        $routeProvider.when('/traditions',      {templateUrl: 'bundles/characterdatabase/html/dropdown.html', reloadOnSearch: false});
        $routeProvider.when('/totems',         {templateUrl: 'bundles/characterdatabase/html/touch.html', reloadOnSearch: false});
        $routeProvider.when('/cyberware',         {templateUrl: 'bundles/characterdatabase/html/swipe.html', reloadOnSearch: false});
        $routeProvider.when('/logout',          {templateUrl: 'bundles/characterdatabase/html/drag.html', reloadOnSearch: false});
    });


})();
