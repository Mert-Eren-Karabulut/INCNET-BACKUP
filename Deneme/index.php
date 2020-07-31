<?php
if(isset($_POST['choose'])){
    header('location:profile.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>AngularJS Tutorials</title>
  <link rel="stylesheet" href="vendor/foundation/foundation.min.css">

  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.3/angular.min.js"></script>
  <script type="text/javascript" src="main.js"></script>
</head>
<body>

  <div ng-app="myApp">
    <div ng-controller="AvengersCtrl">
      <input type="text" ng-model="search.$">
        <div ng-repeat="actor in avengers.cast | filter: search">
            <div style="border: 1px solid lightgray;width:300px;">
                {{actor.name}}
            </div>
            <div style="border: 1px solid lightgray;width:300px;">
                {{actor.character}}
            </div>
            <form method="post">
                <input type="submit" name="choose" value='{{"Choose "+actor.name}}' onclick='alert(this.value)'/>
            </form>

            <br>
        </div>
    </div>
  </div>  


</body>
</html>