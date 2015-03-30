myCineMania.factory('PreferenciasResource', function($resource) {
    var resource = $resource('/preferencias/:id', {id:'@id'});
    return resource;  
});