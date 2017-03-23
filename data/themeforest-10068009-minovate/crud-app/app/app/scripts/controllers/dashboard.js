'use strict';

app
  .controller('DashboardCtrl', ['$scope', '$state', '$stateParams', '$firebaseArray', '$firebaseObject', '$filter', 'uploadImage', 'user', 'toastr',
    function($scope, $state, $stateParams, $firebaseArray, $firebaseObject, $filter, uploadImage, user, toastr) {

      toastr.success('All crud operations are disabled for demo purposes on firebase db level, but will be functional on your own firebase database', 'CRUD Operations Disabled!', {progressBar: true, timeOut: '30000'});
      toastr.warning('Set-up s3upload.js service to use proper data for uploading, for help read <a href="http://beckcd.com/nashville/software/school/2014/11/29/file-uploading-with-angular/" target="_blank">this article</a>', 'Amazon S3 Upload!', {progressBar: true, timeOut: '30000', allowHtml: true});

      $scope.page = {
        title: 'Dashboard'
      };

      // General database variable
      var ref = firebase.database().ref();
      $scope.products = $firebaseArray(ref.child('products'));
      $scope.orders = $firebaseArray(ref.child('orders'));
      $scope.users = $firebaseArray(ref.child('users'));
      $scope.categories = $firebaseArray(ref.child('categories'));

      $scope.categoriesObject = $firebaseObject(ref.child('categories'));
      //////////////////////////// *General database variable

      $scope.users.$loaded(function(){
        $scope.activeUsers = $filter('filter')($scope.users, {blocked: false});
      });

      $scope.ordersValue = 0;

      $scope.orders.$loaded(function(){
        angular.forEach($scope.orders, function(val, key) {
          $scope.ordersValue += val.subTotal;
        });
      });

    }])

  .controller('OrdersChartCtrl', ['$scope', '$filter', '$http',
    function($scope, $filter, $http) {

      $scope.range = '7d';

      $scope.options = {
        scaleShowVerticalLines: false,
        barValueSpacing : 20
      };

      function fetchOrders(){
        $scope.orders.$ref()
          .orderByChild('created_at')
          .limitToLast(1)
          .once('value', function(snapshot){
            snapshot.forEach(function(data) {

              var lastOrder = data.val();
              var lastDate = moment(lastOrder.created_at).startOf('day').format('x');
              var x;
              var dayDuration = 86400000;

              $scope.chart = {
                labels : [],
                datasets : [
                  {
                    fillColor : "#45ccce",
                    strokeColor : "rgba(0,0,0,0)",
                    data : []
                  }
                ]
              };
              $scope.options.tooltipTemplate = "<%if (label){%><%=label%>: <%}%> $<%= value %>";

              if ($scope.range === '7d') {
                x = 7;
                lastDate -= 6*dayDuration;
              } else if ($scope.range === '31d') {
                x = 31;
                lastDate -= 30*dayDuration;
              }

              for(var i = 0; i < x; i++) {
                $scope.chart.labels.push($filter('date')(lastDate, 'dd MMM'));
                lastDate += dayDuration;
              }

              $scope.orders.$loaded(function(){
                angular.forEach($scope.chart.labels, function(date){
                  var dayValue = 0;
                  angular.forEach($scope.orders, function(order){
                    var orderDate = $filter('date')(order.created_at, 'dd MMM');
                    if (orderDate === date) {
                      dayValue += order.subTotal;
                    }
                  });
                  $scope.chart.datasets[0].data.push(dayValue);
                });
              });

            });
          });
      }
      fetchOrders();

      $scope.$watch('range', function(newVal, oldVal){
        if (newVal !== oldVal){

          if (newVal === '7d') {
            $scope.options.barValueSpacing = 20;
          }

          if (newVal === '31d') {
            $scope.options.barValueSpacing = 5;
          }

          fetchOrders();

        }
      });

    }
  ])

  .controller('ProductsChartCtrl', ['$scope', '$filter', '$http',
    function($scope, $filter, $http) {

      $scope.chart = [
        {
          value: 0,
          color:"#F7464A",
          highlight: "#FF5A5E",
          label: ""
        },
        {
          value: 0,
          color: "#46BFBD",
          highlight: "#5AD3D1",
          label: ""
        },
        {
          value: 0,
          color: "#FDB45C",
          highlight: "#FFC870",
          label: ""
        }
      ];

      $scope.categories.$loaded(function(){
        $scope.products.$loaded(function(){

          var parentCategories = $filter('filter')($scope.categories, {parent: true});
          var childCategories = $filter('filter')($scope.categories, {parent: false});

          angular.forEach(parentCategories, function(val, key){
            var quantity = 0;

            angular.forEach(childCategories, function(category){
              var x = 0;
              angular.forEach($scope.products, function(product){
                if (product.categoryId === category.$id) {
                  x++;
                }
              });
              if (category.parentId === val.$id && x > 0) {
                quantity++;
              }
            });

            $scope.chart[key].label = val.name;
            $scope.chart[key].value = quantity;
          });

        });
      });

    }
  ]);
