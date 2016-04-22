/**
 * Created by jenz on 01.03.16.
 */

(function () {
    var app = angular.module('srdb', [
        'mobile-angular-ui',
        'mobile-angular-ui.gestures'
    ]);

    app.controller('StoreController', ['$http', '$log', function($http, $log){
        var store = this;
        store.gems = [];

        $http.get('bundles/characterdatabase/js/foo.json').success(function(data){
            store.gems = data;
        });
    }]);

})();
