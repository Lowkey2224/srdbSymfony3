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
                    skills.bindAttribute(skill);
                    skills.currentlyEditedSkill = skill;
                };

                skills.bindAttribute = function(skill){
                    if(skill.attribute){
                        skill.attribute =  skills.attributes.find(function(elem){
                            return elem.id == skill.attribute.id;
                        });
                    }
                };
                skills.submitForm = function () {
                    var data = {
                        "name": skills.currentlyEditedSkill.name,
                        "type": skills.currentlyEditedSkill.type,
                        "attribute": skills.currentlyEditedSkill.attribute
                    };
                    var url = indexUrl + 'skill';
                    url += (skills.currentlyEditedSkill.id)?'/'+(skills.currentlyEditedSkill.id):'';
                    $http.put(url, data).then(function (request) {
                        console.log(request.data);
                        skills.currentlyEditedSkill = null;
                        var pushed = false;
                        for(var i = 0; i< skills.skills.length; i++){
                            if(request.data.id == skills.skills[i].id){
                                skills.skills[i] = request.data;
                                pushed = true;
                            }
                        }
                        if(!pushed){
                            skills.skills.push(request.data);
                        }
                    }, function (request) {
                        console.log(request);
                    });

                };
                var url = indexUrl + 'skill';
                $http.get(url).then(function (request) {
                    skills.skills = request.data;
                    skills.loading = false;
                }, function (request) {
                    skills.skills = {'code': request.status};
                    skills.loading = false;
                });
                url = indexUrl + 'attribute';
                $http.get(url).then(function (request) {
                    skills.attributes = request.data;
                    skills.loading = false;
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