'use strict';

app

  .controller('CategoriesCtrl', ['$scope', '$state', '$stateParams', '$firebaseArray', '$firebaseObject',
    function($scope, $state, $stateParams, $firebaseArray, $firebaseObject) {

      // General database variable
      var ref = firebase.database().ref();
      $scope.categories = $firebaseArray(ref.child('categories'));
      $scope.categoriesObject = $firebaseObject(ref.child('categories'));
      //////////////////////////// *General database variable

      // get the model
      if($stateParams.id) {
        var id = $stateParams.id;
        $scope.category = $firebaseObject(ref.child('categories').child(id));
      } else {
        $scope.category = {};
      }

    }])

  .controller('CategoriesListCtrl', ['$scope', '$filter', 'ngTableParams', 'toastr',
    function($scope, $filter, ngTableParams, toastr) {

      //////////////////////////////////////////
      //************ Table Settings **********//
      //////////////////////////////////////////

      // Delete CRUD operation
      $scope.delete = function (category) {
        if (confirm('Are you sure?')) {
          $scope.categories.$remove(category).then(function () {
            console.log('category deleted');
            toastr.success('Category Removed!', 'Category has been removed');
          });
        }
      };
      //////////////////////////// *Delete CRUD operation


      // Initialize table
      $scope.categories.$loaded().then(function() {

        //extend array
        angular.forEach($scope.categories, function(value, key){
          if (value.parentId && $scope.categoriesObject[value.parentId]) {
            value.parentName = $scope.categoriesObject[value.parentId].name;
          }
        });
        ///////////////////////////////////////////// *extend array


        // watch data in scope, if change reload table
        $scope.$watchCollection('categories', function(newVal, oldVal){
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
          total: $scope.categories.length, // length of data
          getData: function($defer, params) {
            // use build-in angular filter
            var orderedData = params.sorting() ?
              $filter('orderBy')($scope.categories, params.orderBy()) :
              $scope.categories;

            orderedData	= $filter('filter')(orderedData, $scope.searchText);
            params.total(orderedData.length);

            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
          }
        });
      });
      ////////////////////////////////////////// *Initialize table

    }])

  .controller('NewCategoryCtrl', ['$scope', 'toastr', '$state', '$filter',
    function($scope, toastr, $state, $filter) {

      var ref = firebase.database().ref();

      // Submit operation
      $scope.ok = function() {
        if (!$scope.category.parentId) {
          $scope.category.parent = true;
        } else {
          $scope.category.parent = false;
        }
        $scope.categories.$add($scope.category).then(function (categoryRef) {
          ref.child('categories').child(categoryRef.key)
            .update({created_at: firebase.database.ServerValue.TIMESTAMP});
          toastr.success('Category Added!', 'Category has been created');
          $state.go('app.categories.list', {}, {reload: true});
        });
      };
      /////////////////////// *Submit operation

    }])

  .controller('EditCategoryCtrl', ['$scope', '$firebaseObject', 'toastr', '$state', '$filter',
    function($scope, $firebaseObject, toastr, $state, $filter) {

      var ref = firebase.database().ref();

      $scope.categories.$loaded(function(){
        // Submit operation
        $scope.ok = function() {
          if (!$scope.category.parentId) {
            $scope.category.parent = true;
          } else {
            $scope.category.parent = false;
          }
          $scope.category.$save().then(function (categoryRef) {
            ref.child('categories').child(categoryRef.key)
              .update({updated_at: firebase.database.ServerValue.TIMESTAMP});
            toastr.success('Category Saved!', 'Category has been saved');
            $state.go('app.categories.list', {}, {reload: true});
          });
        };
        /////////////////////// *Submit operation
      });


    }])

  .controller('ShowCategoryCtrl', ['$scope', '$firebaseObject', 'toastr', '$state', 'FBURL', '$stateParams',
    function($scope, $firebaseObject, toastr, $state, FBURL, $stateParams) {


    }]);
