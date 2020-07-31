/**
 * Created by Meral on 22.11.2014.
 */

var app = ng.module('myApp', []);

myApp.factory('Users', function(){

    var Users = {};

    Users.Info = [
        {
            name: "Murat Kaan Meral",
            id: "12"
        },
        {
            name: "Barış Demirel",
            id: "79"
        },
        {
            name: "Çetincan Önelge",
            id: "78"
        },
        {
            name: "Onur Berk Sunal",
            id: "15"
        },
        {
            name: "Bayram Sevgen",
            id: "22"
        }

    ]

    return Avengers;

});

function UserSearch($scope, Users){
    $scope.users = Users;
}

