myCineMania.factory('RedesResource', function($resource) {
	var resource = $resource('/redes_cinema/:id', {id:'@id'}, {
		'update' : {'method' : 'PUT'}
	});
	return resource;  
});