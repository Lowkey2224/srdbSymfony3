/**
 * Created by jenz on 05.05.16.
 */
(function () {
    var app = angular.module('skills', []);


    app.directive("skillForm", function () {
        return {
            restrict: 'E',
            controller: ['$http', 'userService', function ($http, userService) {
                var skills = this;
                skills.loading = true;
                skills.isLoggedIn = userService.isLoggedIn;
                skills.skills = [];
                skills.edit = null;
                skills.attributes =[];
                skills.editSkill = function (skill) {
                    skills.edit = skill;
                    console.log("Edit Skill", skills.edit);
                };
                skills.submitForm = function () {
                    var data = {
                        "name": skills.edit.name,
                        "type": 1,
                        "attribute": {
                            "id":skills.edit.attribute.id,
                            "name":skills.edit.attribute.name
                        }
                    };
                    console.log('Sending data', data);
                    var url = indexUrl + 'skill';
                    url += (skills.edit.id)?'/'+(skills.edit.id):'';
                    $http.put(url, data).then(function (request) {
                        console.log(request);
                        skills.skills.indexOf()
                        skills.skills.push(skills.edit);
                        skills.edit = null;
                    }, function (request) {
                        console.log(request);
                    });

                };
                var url = indexUrl + 'skill';
                $http.get(url).then(function (request) {
                    skills.skills = request.data;
                    skills.loading = false;
                    console.log("Skills:", skills.skills);
                }, function (request) {
                    skills.skills = {'code': request.status};
                    skills.loading = false;
                });
                url = indexUrl + 'attribute';
                $http.get(url).then(function (request) {
                    skills.attributes = request.data;
                    skills.loading = false;
                    console.log("Skills:", skills.skills);
                }, function (request) {
                    skills.attributes = {'code': request.status};
                    skills.loading = false;
                });
            }],
            templateUrl: bundleDir + 'html/directives/skill-form.html',
            controllerAs: 'skills'
        };
    });

})();