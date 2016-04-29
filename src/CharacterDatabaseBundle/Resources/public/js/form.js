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
                form.count = 0;
                form.needsRow = function (countPerRow) {
                    val = form.count % countPerRow == 0;
                    form.count++;
                    return val;
                };
                form.character = {};
                form.skills = [];
                form.attributes = [];
                form.totems = [];
                form.capabilities = [];
                form.traditions = [];
                form.formSkills = [];
                form.submitData = function () {
                    console.log("Formdata:", form.character);
                    var url = indexUrl + 'character' + "?XDEBUG_SESSION_START=PHPSTORM";
                    $http.put(url, form.character).then(function (request) {
                        console.log(request);
                        $location.path("/character/" + request.data.id);
                    }, function (request) {
                        console.log(request);
                    });
                };
                form.toggleSkill = function (skill) {
                    var index = form.formSkills.indexOf(skill);
                    console.log("Toggle skill;", skill, index);
                    if (index == -1) {
                        form.formSkills.push(skill);
                    } else {
                        form.formSkills.splice(index, 1);
                    }
                    console.log("Formskills", form.formSkills);
                };
                form.isAdded = function (skill) {
                    return form.formSkills.indexOf(skill) != -1;
                };
                var url = indexUrl + 'skill';
                $http.get(url).then(function (request) {
                    form.skills = request.data;
                }, function (request) {
                    form.skills = {'code': request.status};
                });
                url = indexUrl + 'attribute';
                $http.get(url).then(function (request) {
                    form.attributes = request.data;
                }, function (request) {
                    form.attributes = {'code': request.status};
                });
                url = indexUrl + 'totem';
                $http.get(url).then(function (request) {
                    form.totems = request.data;
                }, function (request) {
                    form.totems = {'code': request.status};
                });
                url = indexUrl + 'capability';
                $http.get(url).then(function (request) {
                    form.capabilities = request.data;
                }, function (request) {
                    form.capabilities = {'code': request.status};
                });
                url = indexUrl + 'tradition';
                $http.get(url).then(function (request) {
                    form.traditions = request.data;
                }, function (request) {
                    form.traditions = {'code': request.status};
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
                    console.log("Toggle skill;", skill, index);
                    if (index == -1) {
                        skills.formSkills.push(skill);
                    } else {
                        skills.formSkills.splice(index, 1);
                    }
                    console.log("Formskills", form.formSkills);
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