var app = angular.module('MyCineMania', []);

function mainController($scope){
    $scope.orderBy = 'nome';
    
    $scope.participantes = [
        {
            'id': 1,
            'nome': 'Joaquim José',
            'sobrenome': 'da Silva Xavier',
            'cpf': '000.000.001-01',
            'data_cadastro': '16/08/1746',
            'data_vencimento': '21/04/2014',
            'status': 'Pendente'
        },
        {
            'id': 2,
            'nome': 'Ada Augusta',
            'sobrenome': 'Byron King',
            'cpf': '000.888.999-01',
            'data_cadastro': '10/12/1815',
            'data_vencimento': '27/11/2014',
            'status': 'Aprovado'
        },
        {
            'id': 3,
            'nome': 'Alan',
            'sobrenome': 'Mathison Turing',
            'cpf': '111.999.888-42',
            'data_cadastro': '23/06/1912',
            'data_vencimento': '07/06/2014',
            'status': 'Aprovado'
        },
        {
            'id': 4,
            'nome': 'Erich',
            'sobrenome': 'Gamma',
            'cpf': '145.125.112-11',
            'data_cadastro': '31/03/1961',
            'data_vencimento': '25/12/2014',
            'status': 'Aprovado'
        },
        {
            'id': 5,
            'nome': 'Dennis',
            'sobrenome': 'Ritchie',
            'cpf': '555.555.555-88',
            'data_cadastro': '09/07/1941',
            'data_vencimento': '12/10/2011',
            'status': 'Expirado'
        },
        {
            'id': 6,
            'nome': 'Ken',
            'sobrenome': 'Thompson',
            'cpf': '555.333.999-88',
            'data_cadastro': '04/02/1943',
            'data_vencimento': '11/03/2015',
            'status': 'Aprovado'
        },
        {
            'id': 7,
            'nome': 'Barbara',
            'sobrenome': 'Liskov',
            'cpf': '132.123.132-22',
            'data_cadastro': '07/11/1939',
            'data_vencimento': '11/07/2015',
            'status': 'Pendente'
        }
    ];
}