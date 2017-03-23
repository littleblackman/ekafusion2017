'use strict';

var securedRoutes = [];

app

/**
 * Adds a special `whenAuthenticated` method onto $routeProvider. This special method,
 * when called, waits for auth status to be resolved asynchronously, and then fails/redirects
 * if the user is not properly authenticated.
 *
 * The promise either resolves to the authenticated user object and makes it available to
 * dependency injection (see AuthCtrl), or rejects the promise if user is not logged in,
 * forcing a redirect to the /login page
 */

  .config(['$stateProvider', function($stateProvider) {
    // credits for this idea: https://groups.google.com/forum/#!msg/angular/dPr9BpIZID0/MgWVluo_Tg8J
    // unfortunately, a decorator cannot be use here because they are not applied until after
    // the .config calls resolve, so they can't be used during route configuration, so we have
    // to hack it directly onto the $routeProvider object
    $stateProvider.whenAuthenticated = function(path, route) {
      securedRoutes.push(path); // store all secured routes for use with authRequired() below
      route.resolve = route.resolve || {};
      route.resolve.user = ["Auth", function(Auth) {
        // $requireSignIn returns a promise so the resolve waits for it to complete
        // If the promise is rejected, it will throw a $stateChangeError (see above)
        return Auth.$requireSignIn();
      }];
      route.resolve.currentUser = ['Auth', 'user', '$q', function (Auth, user, $q) {
        var deferred = $q.defer();
        var ref = firebase.database().ref();

        ref.child('users').child(user.uid).on('value', function(snapshot) {
          deferred.resolve(snapshot.val());
        });
        return deferred.promise;
      }];
      $stateProvider.state(path, route);
    };
  }])


// configure views; the authRequired parameter is used for specifying pages
// which should only be available while logged in
  .config(['$stateProvider', '$urlRouterProvider', 'ROUTES', function($stateProvider, $urlRouterProvider, ROUTES) {
    angular.forEach(ROUTES, function(route, path) {
      if( route.authRequired ) {
        // adds a {resolve: user: {...}} promise which is rejected if
        // the user is not authenticated or fulfills with the user object
        // on success (the user object is then available to dependency injection)
        $stateProvider.whenAuthenticated(path, route);
      }
      else {
        // all other routes are added normally
        $stateProvider.state(path, route);
      }
    });
    // routes which are not in our map are redirected to /home
    $urlRouterProvider.otherwise('/app/dashboard');
  }])


/**
 * Apply some route security. Any route's resolve method can reject the promise with
 * { authRequired: true } to force a redirect. This method enforces that and also watches
 * for changes in auth status which might require us to navigate away from a path
 * that we can no longer view.
 */
  .run(['$rootScope', '$state', '$location', 'ROUTES', 'loginRedirectPath', '$stateParams', 'Auth',
    function($rootScope, $state, $location, ROUTES, loginRedirectPath, $stateParams, Auth) {
      $rootScope.$state = $state;
      $rootScope.$stateParams = $stateParams;

      $rootScope.$on('$stateChangeSuccess', function(event, toState) {

        // track status of authentication
        Auth.$onAuthStateChanged(function(firebaseUser) {
          $rootScope.loggedIn = !!firebaseUser;
          if ($state.current.authRequired && !firebaseUser) {
            $state.go(loginRedirectPath);
          }
        });

        event.targetScope.$watch('$viewContentLoaded', function () {

          angular.element('html, body, #content').animate({ scrollTop: 0 }, 200);

          setTimeout(function () {
            angular.element('#wrap').css('visibility','visible');

            if (!angular.element('.dropdown').hasClass('open')) {
              angular.element('.dropdown').find('>ul').slideUp();
            }
          }, 200);
        });
        $rootScope.containerClass = toState.containerClass;
      });

      // some of our routes may reject resolve promises with the special {authRequired: true} error
      // this redirects to the login page whenever that is encountered
      $rootScope.$on("$stateChangeError", function(event, toState, toParams, fromState, fromParams, error) {
        // We can catch the error thrown when the $requireSignIn promise is rejected
        // and redirect the user back to the home page
        if (error === "AUTH_REQUIRED") {
          $state.go(loginRedirectPath);
        }
      });

    }
  ]);
