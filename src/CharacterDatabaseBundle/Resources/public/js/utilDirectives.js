/**
 * Created by jenz on 26.05.16.
 */
(function () {
    var app = angular.module('Utildirectives', []);


    app.directive("showMore", function () {
        return {
            restrict: 'C',
            controller: [function (elem) {

            }],
            //templateUrl: bundleDir + 'html/directives/show-more.html',
            link: function($scope, $element, attrs) {
                var length = 100;
                var short = false;
                $scope.originalText = $element.text();
                //console.log("Scope",$scope, "element", $element, "attrs", attrs);

                if($element.text().length > 103){
                    $element.text($scope.originalText.substr(0,100)+"...");
                }else{
                    $element.text($scope.originalText);
                }
                console.log("orig", $scope.originalText);
            },
            //controllerAs: 'skills'
        };
    });

})();