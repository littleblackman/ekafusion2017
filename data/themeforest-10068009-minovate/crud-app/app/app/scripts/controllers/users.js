'use strict';

app

  .controller('UsersCtrl', ['$scope', '$state', '$stateParams', '$firebaseArray', '$firebaseObject', 'currentUser', 'Auth',
    function($scope, $state, $stateParams, $firebaseArray, $firebaseObject, currentUser, Auth) {

      // General database variable
      var ref = firebase.database().ref();
      $scope.users = $firebaseArray(ref.child('users'));
      $scope.blockedUsers = ref.child('blockedUsers');
      //////////////////////////// *General database variable

      // get the model
      if($stateParams.id) {
        var id = $stateParams.id;
        $scope.user = $firebaseObject(ref.child('users').child(id));
      } else {
        $scope.user = {};
      }

      if (currentUser.role === 'admin'){
        $scope.roles = {
          admin: "admin",
          superuser: "superuser",
          user: "user"
        };
      } else {
        $scope.roles = {
          superuser: "superuser",
          user: "user"
        };
      }

    }])

  .controller('UsersListCtrl', ['$scope', '$filter', 'ngTableParams', 'toastr', 'Auth',
    function($scope, $filter, ngTableParams, toastr, Auth) {

      var ref = firebase.database().ref();

      // Delete CRUD operation
      $scope.delete = function (user) {
        if (confirm('Are you sure?')) {
          $scope.users.$ref().child(user.$id).child('blocked').set(true);
          $scope.blockedUsers.child(user.$id).set({blocked: true});
          $scope.tableParams.reload();
        }
      };
      //////////////////////////// *Delete CRUD operation

      // password reset operation
      $scope.passReset = function (user) {
        if (confirm('Are you sure?')) {
          Auth.$sendPasswordResetEmail(user.email).then(function(){
            toastr.success('We have sent an email with new password', 'Password reset!');
            console.log("Password reset email sent successfully");
          }, function(error){
            console.log("Error sending password reset email:", error);
          });
        }
      };
      //////////////////////////// *password reset operation

      //////////////////////////////////////////
      //************ Table Settings **********//
      //////////////////////////////////////////

      // Initialize table
      $scope.users.$loaded().then(function() {

        // watch data in scope, if change reload table
        $scope.$watchCollection('users', function(newVal, oldVal){
          if (newVal !== oldVal) {
            $scope.tableParams.reload();
          }
        });

        $scope.$watch('searchText', function(newVal, oldVal){
          if (newVal !== oldVal) {
            $scope.tableParams.reload();
          }
        });
        ///////////////////////////////////////////// *watch data in scope, if change reload table

        $scope.tableParams = new ngTableParams({
          page: 1,            // show first page
          count: 10,          // count per page
          sorting: {
            name: 'asc'     // initial sorting
          }
        }, {
          total: $scope.users.length, // length of data
          getData: function($defer, params) {
            // use build-in angular filter
            var orderedData = params.sorting() ?
              $filter('orderBy')($scope.users, params.orderBy()) :
              $scope.users;

            orderedData	= $filter('filter')(orderedData, {blocked: false});
            orderedData	= $filter('filter')(orderedData, $scope.searchText);
            params.total(orderedData.length);

            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
          }
        });
      });
      ////////////////////////////////////////// *Initialize table

    }])

  .controller('NewUserCtrl', ['$scope', 'toastr', '$state', '$filter', 'Auth',
    function($scope, toastr, $state, $filter, Auth) {

      var ref = firebase.database().ref();
      var profiles = ref.child('users');

      $scope.editing = false;

      // Submit operation
      $scope.ok = function() {

        $scope.userEntry = {
          name: $scope.user.name,
          email: $scope.user.email,
          role: $scope.user.role,
          address: {
            street: $scope.user.address.street,
            city: $scope.user.address.city,
            zip: $scope.user.address.zip,
            country: $scope.user.address.country
          },
          phone: $scope.user.phone,
          blocked: false
        };

        secondaryApp.auth().createUserWithEmailAndPassword($scope.user.email, $scope.user.password)
          .then(function(userData) {
            profiles.child(userData.uid).set($scope.userEntry);
            secondaryApp.auth().signOut();
            secondaryApp.delete();
            console.log("Successfully created user account with uid:", userData.uid);
            toastr.success('User has been created', 'User Added!');
            $state.go('app.users.list', {}, {reload: true});
          }, function(error) {
            console.log("Error creating user:", error);
            toastr.error(error.message, 'Adding User Error!');
          }); /////////////////////// *Create CRUD operation

      };
      /////////////////////// *Submit operation

    }])

  .controller('EditUserCtrl', ['$scope', '$firebaseObject', 'toastr', '$state', '$filter', 'Auth',
    function($scope, $firebaseObject, toastr, $state, $filter, Auth) {

      $scope.editing = true;

      var ref = firebase.database().ref();
      var profiles = ref.child('users');

      $scope.users.$loaded(function(){

        // Submit operation
        $scope.ok = function() {

          $scope.userEntry = {
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
            profiles.child($scope.user.$id).update($scope.userEntry, function() {
              toastr.success('User has been saved', 'User Saved!');
              $state.go('app.users.list', {}, {reload: true});
            });
          };

          updateOnSuccess();

        };
        /////////////////////// *Submit operation
      });


    }])

  .controller('ShowUserCtrl', ['$scope', '$firebaseObject', 'toastr', '$state', '$stateParams',
    function($scope, $firebaseObject, toastr, $state, $stateParams) {


    }]);
