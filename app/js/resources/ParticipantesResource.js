myCineMania.factory('ParticipantesResource', function($resource) {
	var resource = $resource('/participantes/:id', {id:'@id'});;
	return resource;  
});