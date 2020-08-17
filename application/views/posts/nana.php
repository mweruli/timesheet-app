<!DOCTYPE html>
<html  ng-app="defaultApp">
    <head>
        <!-- Essential Studio for JavaScript  theme reference -->
        <link rel="stylesheet" href="http://cdn.syncfusion.com/14.3.0.49/js/web/flat-azure/ej.web.all.min.css" />
        <!-- Essential Studio for JavaScript  script references -->   
        <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
        <script src="http://cdn.syncfusion.com/js/assets/external/jsrender.min.js" type="text/javascript"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
        <script src="https://code.angularjs.org/1.4.0-rc.2/angular.min.js"></script>
        <script src="http://cdn.syncfusion.com/14.3.0.49/js/web/ej.web.all.min.js" type="text/javascript"></script>
        <script src="http://js.syncfusion.com/demos/web/scripts/xljsondata.js" type="text/javascript"></script>
        <script src="https://code.angularjs.org/1.4.0-rc.2/angular-route.min.js"></script>
        <script src="http://cdn.syncfusion.com/14.3.0.49/js/common/ej.widget.angular.min.js"></script>
    </head>
    <body>
    <body ng-controller="SpreadsheetCtrl">
        <div id="Spreadsheet" ej-spreadsheet>

        </div>
        <script>
                    var syncApp = angular.module("defaultApp", ["ngRoute", "ejangular"]);
                    syncApp.controller('SpreadsheetCtrl', function ($scope, $rootScope) {
                    });
        </script>
    </body>
</body>
</html>