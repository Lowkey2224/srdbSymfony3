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
                console.log("Status 00", form.loadStatus);
                form.count = 0;

                form.needsRow = function (countPerRow) {
                    var val = form.count % countPerRow == 0;
                    form.count++;
                    return val;
                };
                var url = "";
                if ($routeParams.characterId > 0) {
                    url = indexUrl + 'character/' + $routeParams.characterId;
                    $http.get(url).then(function (request) {
                        form.character = request.data;
                        form.reformatCharacter(request.data);
                        console.log(form.character);
                        console.log(form.character.attributes);
                        //form.loadStatus--;
                    }, function (request) {
                        form.error = {'code': request.status};
                        form.character = {};
                        //form.loadStatus--;
                    });
                    console.log("Load Character");
                }
                //form.character = {};
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



                form.getVars = function () {
                    url = indexUrl + 'skill';
                    $http.get(url).then(function (request) {
                        form.skills = request.data;
                        form.loadStatus--;
                        console.log("Status 11", form.loadStatus);
                    }, function (request) {
                        form.error = {'code': request.status};
                        form.loadStatus--;
                        console.log("Status 12", form.loadStatus);
                    });
                    url = indexUrl + 'attribute';
                    $http.get(url).then(function (request) {
                        form.attributes = request.data;
                        form.loadStatus--;
                        console.log("Status 21", form.loadStatus);
                    }, function (request) {
                        form.error = {'code': request.status};
                        form.loadStatus--;
                        console.log("Status 22", form.loadStatus);
                    });
                    url = indexUrl + 'totem';
                    $http.get(url).then(function (request) {
                        form.totems = request.data;
                        form.loadStatus--;
                        console.log("Status 31", form.loadStatus);
                    }, function (request) {
                        form.error = {'code': request.status};
                        form.loadStatus--;
                        console.log("Status 32", form.loadStatus);
                    });
                    url = indexUrl + 'capability';
                    $http.get(url).then(function (request) {
                        form.capabilities = request.data;
                        form.loadStatus--;
                        console.log("Status 41", form.loadStatus);
                    }, function (request) {
                        form.error = {'code': request.status};
                        form.loadStatus--;
                        console.log("Status 42", form.loadStatus);
                    });
                    url = indexUrl + 'tradition';
                    $http.get(url).then(function (request) {
                        form.traditions = request.data;
                        form.loadStatus--;
                        console.log("Status 51", form.loadStatus);
                    }, function (request) {
                        form.error = {'code': request.status};
                        form.loadStatus--;
                        console.log("Status 52", form.loadStatus);
                    });
                };
                form.getVars();

                form.reformatCharacter = function (char) {
                    var atts = char.attributes;
                    form.character.attributes = [];
                    for (var i = 0; i < atts.length; i++) {
                        form.character.attributes[atts[i].name] = atts[i].level;
                    }
                }
            }],
            controllerAs: 'form'
        };
    });

    app.directive("skillSelector", function () {
        return {
            restrict: 'E',
            templateUrl: bundleDir + 'html/directives/skill-selector.html',
            controller: ['$http', function ($http) {
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