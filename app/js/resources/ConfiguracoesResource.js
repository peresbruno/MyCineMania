myCineMania.factory('ConfiguracoesResource', function($resource) {
	var resource = $resource('/configuracoes', {}, {
		'update' : {'method' : 'PUT'}
	});
	return resource;  
});