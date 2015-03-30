myCineMania.factory('VouchersResource', function($resource) {
	var resource = $resource('/vouchers/:codigo', {codigo:'@codigo'}, {
		'update' : {'method' : 'PUT'}
	});
	return resource;  
});