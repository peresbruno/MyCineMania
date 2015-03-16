var myCineMania = angular.module('myCineMania', 
	['ui.router',
	 'ngResource',
	 'oitozero.ngSweetAlert']);



myCineMania.config(function ($stateProvider, $urlRouterProvider) {

	$urlRouterProvider.otherwise("/inicio");

	$stateProvider.state('cadastro_participante', {
		url: "/cadastrar_participante/:id",
		controller: 'CadastrarParticipanteCtrl',
		templateUrl: "templates/participante_cadastro.html",
		resolve: {
			participante: function (ParticipantesResource, $stateParams) {
				if ($stateParams.id)
					return ParticipantesResource.get({id: $stateParams.id})
				else 
					return new ParticipantesResource;					
			}
		}
	}).state('inicio', {
		url: "/inicio",
		template: "Oi"
	});
}).run(function ($http) {
	// $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
});