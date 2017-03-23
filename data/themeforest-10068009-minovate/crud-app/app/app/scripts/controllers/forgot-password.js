'use strict';

app
  .controller('ForgotPasswordCtrl', ['$scope', '$firebase', 'Auth', '$state', 'toastr', function ($scope, $firebase, Auth, $state, toastr){

    $scope.email = null;

    $scope.ok = function(){

      Auth.$sendPasswordResetEmail($scope.email)
        .then(function() {
          console.log("Password reset email sent successfully");
          toastr.success('Your password has been reseted, check your email', 'Password reset!');
          $state.go('core.login', {}, {reload: true});
        }, function(error) {
          console.log("Error sending password reset email:", error);
          toastr.error(error.code, 'Reset Error!');
        });

    };

  }]);
