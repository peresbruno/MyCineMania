var app = angular.module('MyCineMania', []);

function mainController($scope){
    $scope.orderBy = 'nome';
    
    $scope.redes_de_cinema = [
        {
            'id': 1,
            'rede': 'Cinemark',
            'responsavel': 3,
            'cnpj': '22.111.333/0001-96',
            'endereco': '3900 Dallas Pkwy, Plano, TX 75093, Estados Unidos',
            'status': 'Aprovado'
        },
        {
            'id': 2,
            'rede': 'Erich Gamma',
            'responsavel': 1,
            'cnpj': '12.888.774/0001-78',
            'endereco': 'Cinemas ArcoÍris',
            'status': 'Aprovado'
        },
        {
            'id': 3,
            'rede': 'GNC Cinemas',
            'responsavel': 4,
            'cnpj': '12.132.574/0001-87',
            'endereco': 'Endereço do CNC',
            'status': 'Aprovado'
        },
        {
            'id': 4,
            'rede': 'Outro Cinema',
            'responsavel': 2,
            'cnpj': '88.999.111/0001-74',
            'endereco': 'Outro Cinema Headquarters',
            'status': 'Aprovado'
        },
        {
            'id': 5,
            'rede': 'Cinema da Esquina',
            'responsavel': 5,
            'cnpj': '31.321.321/0001-88',
            'endereco': 'Esquina daqui',
            'status': 'Aprovado'
        },
        {
            'id': 6,
            'rede': 'Cine Odeon',
            'responsavel': 6,
            'cnpj': '13.132.132/0001-22',
            'endereco': 'Rio de Janeiro',
            'status': 'Pendente'
        }
    ];
}