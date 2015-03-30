var myCineMania = angular.module('myCineMania', 
	[
		'ui.router',
		'ngResource',
		'oitozero.ngSweetAlert',
		'ng.httpLoader',
		'LocalStorageModule',
		'ui.utils',
		'checklist-model',
		'ngDialog'
	]);

myCineMania.config(function ($stateProvider, $urlRouterProvider, httpMethodInterceptorProvider) {

	$urlRouterProvider.otherwise("/beneficios");

	httpMethodInterceptorProvider.whitelistDomain('mycinemania');

	$stateProvider
	.state('cadastro_participante', {
		url: "/cadastrar_participante",
		controller: 'CadastrarParticipanteCtrl',
		templateUrl: "templates/participante_cadastro.html",
		resolve: {
			participante: function (ParticipantesResource, $stateParams) {
				if ($stateParams.id)
					return ParticipantesResource.get({id: $stateParams.id})
				else 
					return new ParticipantesResource;					
			},
			preferencias : function (PreferenciasResource) {
				return PreferenciasResource.query();
			}
		}
	})
	.state('cadastro_rede', {
		url: "/cadastrar_rede",
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
			},
			preferencias: function (PreferenciasResource) {
				return PreferenciasResource.query();
			}
		}
	})
	.state('beneficios', {
		url: '/beneficios',
		templateUrl: 'templates/beneficios.html',
		controller: 'ListarBeneficiosCtrl',
		resolve : {
			beneficios : function (BeneficiosResource) {
				return BeneficiosResource.query();
			}
		}
	})
	.state('detalhes_beneficio', {
		url: '/beneficios/:id',
		templateUrl: 'templates/beneficio_detalhes.html',
		controller: 'DetalhesBeneficioCtrl',
		resolve : {
			beneficio : function (BeneficiosResource, $stateParams) {
				return BeneficiosResource.get({id : $stateParams.id});
			}
		}
	})
	.state('voucher', {
		url: '/vouchers/:codigo',
		templateUrl: 'templates/voucher_view.html',
		controller: 'VoucherCtrl',
		resolve: {
			voucher : function (VouchersResource, $stateParams) {
				return VouchersResource.get({codigo : $stateParams.codigo});
			}
		}
	})
	.state('validar_voucher', {
		url: '/validar_voucher',
		templateUrl: 'templates/valida_voucher.html',
		controller: 'ValidarVoucherCtrl'
	})
	.state('login', {
		url: "/login",
		templateUrl: "templates/login.html",
		controller: 'LoginCtrl'
	})

	/* Rotas administrador */
	.state('admin', {
		url: "/admin",
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
	.state('configuracoes', {
		url: "/configuracoes",
		templateUrl: "templates/admin/configuracoes.html",
		controller: "ConfiguracoesCtrl",
		resolve : {
			configuracoes : function (ConfiguracoesResource) {
				return ConfiguracoesResource.get();
			},
			preferencias: function (PreferenciasResource) {
				return PreferenciasResource.query();
			}
		},
		parent: "admin"
	})
	;
	

}).run(
	function ($http, localStorageService) {
		
		if (localStorageService.get('auth') !== null)
			$http.defaults.headers.common.Authorization = 'Basic ' + localStorageService.get('auth');


	}
);