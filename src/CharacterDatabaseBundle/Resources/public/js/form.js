/**
 * Created by jenz on 29.04.16.
 */
(function () {
    var app = angular.module('form', []);

    app.directive("characterForm", function () {
        return {
            restrict: 'E',
            templateUrl: bundleDir + 'html/directives/character-form.html',
            controller: ['$http', '$routeParams', "$scope", "$location", function ($http, $routeParams, $scope, $location) {
                var form = this;
                form.loadStatus = 5;
                form.count = 0;
                form.needsRow = function (countPerRow) {
                    val = form.count % countPerRow == 0;
                    form.count++;
                    return val;
                };
                form.character = {};
                form.attributes = [];
                form.totems = [];
                form.capabilities = [];
                form.traditions = [];
                form.error = {};
                form.showLogin = function () {
                    if (form.loadStatus) {
                        return false;
                    }
                    if (form.error.code) {
                        if (form.error.code == 401) {
                            return true;
                        }
                    }
                    return false;
                };
                form.showForm = function () {
                    if (form.error.length) {
                        if (form.error.code == 401)
                            return false;
                    }
                    return !form.loadStatus && form.attributes.length;
                };
                form.submitData = function () {
                    var url = indexUrl + 'character';// + "?XDEBUG_SESSION_START=PHPSTORM";
                    $http.put(url, form.character).then(function (request) {
                        $location.path("/character/" + request.data.id);
                    }, function (request) {
                    });
                };
                var url = indexUrl + 'skill';
                $http.get(url).then(function (request) {
                    form.skills = request.data;
                    form.loadStatus--;
                }, function (request) {
                    form.error = {'code': request.status};
                    form.loadStatus--;
                });
                url = indexUrl + 'attribute';
                $http.get(url).then(function (request) {
                    form.attributes = request.data;
                    form.loadStatus--;
                }, function (request) {
                    form.error = {'code': request.status};
                    form.loadStatus--;
                });
                url = indexUrl + 'totem';
                $http.get(url).then(function (request) {
                    form.totems = request.data;
                    form.loadStatus--;
                }, function (request) {
                    form.error = {'code': request.status};
                    form.loadStatus--;
                });
                url = indexUrl + 'capability';
                $http.get(url).then(function (request) {
                    form.capabilities = request.data;
                    form.loadStatus--;
                }, function (request) {
                    form.error = {'code': request.status};
                    form.loadStatus--;
                });
                url = indexUrl + 'tradition';
                $http.get(url).then(function (request) {
                    form.traditions = request.data;
                    form.loadStatus--;
                }, function (request) {
                    form.error = {'code': request.status};
                    form.loadStatus--;
                });
            }],
            controllerAs: 'form'
        };
    });

    app.directive("skillSelector", function () {
        return {
            restrict: 'E',
            templateUrl: bundleDir + 'html/directives/skill-selector.html',
            controller: ['$http', '$routeParams', "$scope", function ($http, $routeParams, $scope) {
                var skills = this;
                skills.skills = [];
                skills.formSkills = [];
                skills.toggleSkill = function (skill) {
                    var index = skills.formSkills.indexOf(skill);
                    if (index == -1) {
                        skills.formSkills.push(skill);
                    } else {
                        skills.formSkills.splice(index, 1);
                    }
                };
                skills.isAdded = function (skill) {
                    return skills.formSkills.indexOf(skill) != -1;
                };
                url = indexUrl + 'skill';
                $http.get(url).then(function (request) {
                    skills.skills = request.data;
                }, function (request) {
                    skills.skills = {'code': request.status};
                });

            }],
            controllerAs: 'skills'
        };
    });
})();