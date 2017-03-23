'use strict';

app.
  controller('ProfileCtrl', ['$scope', '$firebaseObject', 'currentUser', 'user', 'toastr', 'uploadImage', 'Auth', function ($scope, $firebaseObject, currentUser, user, toastr, uploadImage, Auth){


    // General database variable
    var ref = firebase.database().ref();
    var profiles = ref.child('users');
    //////////////////////////// *General database variable

    // Initial model
    $scope.user = $firebaseObject(ref.child('users').child(user.uid));
    /////////////////////// *Initial model

    $scope.user.$loaded().then(function(){

      $scope.uploadImage = function (file, user, cb) {
        uploadImage.uploadToS3(file, user, cb);
      };

      $scope.oldEmail = angular.copy($scope.user.email);

    });

    $scope.user.changeEmail = false;
    $scope.user.changePass = false;

    // Submit operation
    $scope.saveUser = function(form) {

      $scope.userEntry = {
        avatar: $scope.user.avatar,
        name: $scope.user.name,
        email: $scope.user.email,
        role: $scope.user.role,
        address: {
          street: $scope.user.address.street,
          city: $scope.user.address.city,
          zip: $scope.user.address.zip,
          country: $scope.user.address.country
        },
        phone: $scope.user.phone
      };

      var updateOnSuccess = function() {

        function save(){
          profiles.child($scope.user.$id).update($scope.userEntry);
          toastr.success('Your Personal Informations has been updated', 'Saving success!');

          $scope.user.changeEmail = false;
          $scope.user.changePass = false;
        }

        var cb = function(filelink){
          $scope.userEntry.avatar = filelink;
          save();
        };

        if (form.avatar.$modelValue && form.avatar.$modelValue.$ngfDataUrl && form.avatar.$valid) {
          $scope.uploadImage($scope.userEntry.avatar, user, cb);
        } else {
          save();
        }

      };

      var changeEmail = $scope.user.changeEmail;
      var changePass = $scope.user.changePass;

      if (changeEmail === true) {
        Auth.$signInWithEmailAndPassword($scope.oldEmail, $scope.user.password).then(function(){
          Auth.$updateEmail($scope.user.email).then(function(){
            console.log("Email changed successfully");
            toastr.success('Email has been changed successfully', 'Email changed!');
            updateOnSuccess();
          }, function(error){
            toastr.error(error.message, 'Error changing email!');
            console.log("Error changing email:", error);
          });
        });
      } else if (changePass === true) {
        Auth.$signInWithEmailAndPassword($scope.user.email, $scope.user.oldpassword).then(function(){
          Auth.$updatePassword($scope.user.password).then(function(){
            console.log("Password changed successfully");
            toastr.success('Password has been changed successfully', 'Password changed!');
            updateOnSuccess();
          }, function(error){
            toastr.error(error.message, 'Error changing password!');
            console.log("Error changing password:", error);
          });
        });
      } else {
        updateOnSuccess();
      }
    };
    /////////////////////// *Submit operation

  }]);

