'use strict';


app
// where to redirect users if they need to authenticate (see routeSecurity.js)
  .constant('loginRedirectPath', 'core.login')

  // main app settings
  .controller('MainCtrl', ['$scope', 'Auth', '$state', 'loginRedirectPath', '$firebaseObject', '$window', function($scope, Auth, $state, loginRedirectPath, $firebaseObject, $window) {

    $scope.main = {
      title: 'Minovate CRUD App',
      appName: 'minovateApp',
      settings: {
        navbarHeaderColor: 'scheme-default',
        sidebarColor: 'scheme-default',
        brandingColor: 'scheme-default',
        activeColor: 'default-scheme-color',
        headerFixed: true,
        asideFixed: true,
        rightbarShow: false
      }
    };

    $scope.settings = $firebaseObject(firebase.database().ref().child('settings'));

    Auth.$onAuthStateChanged(function(user) {
      if(user) {
        var ref = firebase.database().ref();
        // create a 3-way binding with the user profile object in Firebase
        $scope.profile = $firebaseObject(ref.child('users').child(user.uid));

        $scope.logout = function() {
          // destroy all firebase refs
          angular.forEach($window.openFirebaseConnections, function (item) {
            item.$destroy();
          });
          $scope.profile.$destroy();
          Auth.$signOut();
          $state.go(loginRedirectPath, {}, {reload: true});
        };

      }
    });
  }])

  .config(['$provide', function($provide) {
    // inject the $delegate dependency into our decorator method
    firebaseDecorator.$inject = ['$delegate'];

    // Whenever $firebaseArray's and $firebaseObjects are created,
    // they'll now be tracked by window.openFirebaseConnections
    $provide.decorator("$firebaseArray", firebaseDecorator);
    $provide.decorator("$firebaseObject", firebaseDecorator);

    function firebaseDecorator ($delegate) {
      return function (ref) {
        var list = $delegate(ref);
        window.openFirebaseConnections.push(list);
        return list;
      };
    }
  }]);
