var myCineMania = angular.module('myCineMania', 
	['ui.router',
	 'ngResource',
	 'oitozero.ngSweetAlert',
	 'ng.httpLoader',
	 'LocalStorageModule'
	]);

myCineMania.config(function ($stateProvider, $urlRouterProvider, httpMethodInterceptorProvider) {

	$urlRouterProvider.otherwise("/login");

	httpMethodInterceptorProvider.whitelistDomain('mycinemania');

	$stateProvider
	.state('cadastro_participante', {
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
	})
	.state('cadastro_rede', {
		url: "/cadastrar_rede/:id",
		controller: 'CadastrarRedeCtrl',
		templateUrl: "templates/rede_cinema_cadastro.html",
		resolve: {
			rede: function (RedesResource, $stateParams) {
				if ($stateParams.id)
					return RedesResource.get({id: $stateParams.id})
				else 
					return new RedesResource;					
			}
		}
	})
	.state('cadastrar_beneficio', {
		url: "/cadastrar_beneficio",
		templateUrl: 'templates/beneficio_cadastro.html',
		controller: 'CadastrarBeneficioCtrl',
		resolve : {
			beneficio : function (BeneficiosResource) {
				return new BeneficiosResource;
			}
		}
	})
	.state('login', {
		url: "/login",
		templateUrl: "templates/login.html",
		controller: 'LoginCtrl'
	})

	/* Rotas administrador */
	.state('admin', {
		url: "/admin",
		abstract: true,
		template: "<div ui-view></div>"
	})
	.state('listar_redes', {
		url: "/listar_redes",
		controller: "ListarRedesCtrl",
		templateUrl: "templates/admin/listar_redes.html",
		parent: "admin",
		resolve: {
			redes: function (RedesResource) {
				return RedesResource.query();
			}
		}
	})
	.state('listar_participantes', {
		url: "/listar_participantes",
		controller: "ListarParticipantesCtrl",
		templateUrl: "templates/admin/listar_participantes.html",
		parent: "admin",
		resolve: {
			participantes: function (ParticipantesResource) {
				return ParticipantesResource.query();
			}
		}
	})
	;
	

}).run(
	function ($http, localStorageService) {
		$http.defaults.headers.common['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
		if (localStorageService.get('auth') !== null)
			$http.defaults.headers.common.Authorization = 'Basic ' + localStorageService.get('auth');


	}
);