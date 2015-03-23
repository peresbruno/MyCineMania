myCineMania.factory('BeneficiosResource', function($resource) {
	var resource = $resource('/beneficios/:id', {id:'@id'});;
	return resource;  
});