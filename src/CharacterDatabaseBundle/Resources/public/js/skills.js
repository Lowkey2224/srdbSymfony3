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
                skills.currentlyEditedSkill = null;
                skills.attributes =[];
                skills.editSkill = function (skill) {
                    skills.currentlyEditedSkill = skill;
                    console.log("Edit Skill", skills.currentlyEditedSkill);
                };
                skills.submitForm = function () {
                    var data = {
                        "name": skills.currentlyEditedSkill.name,
                        "type": 1,
                        "attribute": {
                            "id":skills.currentlyEditedSkill.attribute.id,
                            "name":skills.currentlyEditedSkill.attribute.name
                        }
                    };
                    console.log('Sending data', data);
                    var url = indexUrl + 'skill';
                    url += (skills.currentlyEditedSkill.id)?'/'+(skills.currentlyEditedSkill.id):'';
                    $http.put(url, data).then(function (request) {
                        console.log(request);
                        skills.skills.push(skills.currentlyEditedSkill);
                        skills.currentlyEditedSkill = null;
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