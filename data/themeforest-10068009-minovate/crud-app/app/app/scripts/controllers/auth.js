'use strict';

app.controller('AuthCtrl', ['$scope', 'Auth', '$state', '$firebaseArray', 'toastr', function($scope, Auth, $state, $firebaseArray, toastr) {

  toastr.success('demo@minovate.com, pass: minovate', 'Login default data!', {progressBar: true, timeOut: '15000'});

  //redirect if user is logged in
  if ($scope.loggedIn) {
     $state.go('app.dashboard', {}, {reload: true});
  }

  $scope.email = null;
  $scope.pass = null;
  $scope.confirm = null;
  $scope.createMode = false;

  $scope.login = function(email, pass) {
    $scope.err = null;
    Auth.$signInWithEmailAndPassword(email, pass)
      .then(function(authData) {
        console.log("Authenticated successfully with payload:", authData);
        $state.go('app.dashboard', {}, {reload: true});
      }, function(err) {
        $scope.err = errMessage(err);
        console.log("Login Failed!", err);
      });
  };

  $scope.register = function() {
    $scope.err = null;
    if( assertValidAccountProps() ) {
      var email = $scope.email;
      var pass = $scope.pass;
      // create user credentials in Firebase auth system
      Auth.$createUserWithEmailAndPassword(email, pass)
        .then(function() {
          // authenticate so we have permission to write to Firebase
          return Auth.$signInWithEmailAndPassword(email,pass);
        })
        .then(function(user) {

          var ref = firebase.database().ref();
          // create a user profile in our data store
          ref.child('users').child(user.uid).set({
            email: email,
            role: "user"
          });

        })
        .then(function(/* user */) {
          $state.go('app.dashboard', {}, {reload: true});
        }, function(err) {
          $scope.err = errMessage(err);
        });
    }
  };

  function assertValidAccountProps() {
    if( !$scope.email ) {
      $scope.err = 'Please enter an email address';
    }
    else if( !$scope.pass || !$scope.confirm ) {
      $scope.err = 'Please enter a password';
    }
    else if( $scope.createMode && $scope.pass !== $scope.confirm ) {
      $scope.err = 'Passwords do not match';
    }
    return !$scope.err;
  }

  function errMessage(err) {
    return angular.isObject(err) && err.code? err.code : err + '';
  }
}]);
