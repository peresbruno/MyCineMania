myCineMania.factory('ParticipantesResource', function($resource) {
	var resource = $resource('/participantes/:id', {id:'@id'}, {
		'update' : {'method' : 'PUT'}
	});
	return resource;  
});