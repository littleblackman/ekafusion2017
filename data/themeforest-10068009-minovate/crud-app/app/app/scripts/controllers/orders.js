'use strict';

app

  .controller('OrdersCtrl', ['$scope', '$state', '$stateParams', '$firebaseArray', '$firebaseObject', '$filter', 'user',
    function($scope, $state, $stateParams, $firebaseArray, $firebaseObject, $filter, user) {

      // General database variable
      var ref = firebase.database().ref();
      $scope.orders = $firebaseArray(ref.child('orders'));
      $scope.ordersObject = $firebaseObject(ref.child('orders'));

      $scope.categories = $firebaseArray(ref.child('categories'));
      $scope.categoriesObject = $firebaseObject(ref.child('categories'));

      $scope.products = $firebaseArray(ref.child('products'));
      $scope.productsObject = $firebaseObject(ref.child('products'));
      //////////////////////////// *General database variable

      $scope.user = user;

      // get the model
      if($stateParams.id) {
        var id = $stateParams.id;
        $scope.order = $firebaseObject(ref.child('orders').child(id));
      } else {
        $scope.order = {};
      }

    }])

  .controller('OrdersListCtrl', ['$scope', '$filter', 'ngTableParams', 'toastr',
    function($scope, $filter, ngTableParams, toastr) {

      //////////////////////////////////////////
      //************ Table Settings **********//
      //////////////////////////////////////////

      // Delete CRUD operation
      $scope.delete = function (order) {
        if (confirm('Are you sure?')) {
          $scope.orders.$remove(order).then(function () {
            console.log('order deleted');
            toastr.success('Order Removed!', 'Order has been removed');
          });
        }
      };
      //////////////////////////// *Delete CRUD operation

      $scope.changeStatus = function (order, status) {
        order.status = status;
        $scope.orders.$save(order).then(function () {
          console.log('status changed');
        });
      };

      // Initialize table
      $scope.orders.$loaded().then(function() {

        // watch data in scope, if change reload table
        $scope.$watchCollection('orders', function(newVal, oldVal){
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
            id: 'asc'     // initial sorting
          }
        }, {
          total: $scope.orders.length, // length of data
          getData: function($defer, params) {
            // use build-in angular filter
            var orderedData = params.sorting() ?
              $filter('orderBy')($scope.orders, params.orderBy()) :
              $scope.orders;

            orderedData	= $filter('filter')(orderedData, $scope.searchText);
            params.total(orderedData.length);

            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
          }
        });
      });
      ////////////////////////////////////////// *Initialize table

    }])


  .controller('ShowOrderCtrl', ['$scope', '$firebaseObject', 'toastr', '$state', '$stateParams',
    function($scope, $firebaseObject, toastr, $state, $stateParams) {


    }]);
