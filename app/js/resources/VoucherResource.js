myCineMania.factory('VouchersResource', function($resource) {
	var resource = $resource('/vouchers/:id', {id:'@id'});
	return resource;  
});