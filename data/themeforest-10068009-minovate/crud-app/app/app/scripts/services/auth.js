'use strict';
app.factory('Auth', ['$firebaseAuth', function($firebaseAuth) {
  return $firebaseAuth();
}]);
