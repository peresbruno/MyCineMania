<div class="espaco-topo">
<script src="/js/participantes.js"></script>
<div class="container">
    <div class="modal fade" id="aprovarModal" tabindex="-1" role="dialog" aria-labelledby="aprovarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="aprovarModalLabel">Aprovar inscrição de participante</h4>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza de que deseja aprovar a inscrição do participante?</p> 
                    <p>A data de validade do cadastro será modificada.</p>
                </div>
                <div class="modal-footer">
                    <form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Aprovar inscrição</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="renovarModal" tabindex="-1" role="dialog" aria-labelledby="renovarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="renovarModalLabel">Renovar inscrição de participante</h4>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza de que deseja renovar a inscrição do participante?</p> 
                    <p>A data de validade do cadastro será modificada.</p>
                </div>
                <div class="modal-footer">
                    <form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Renovar inscrição</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="recusarModal" tabindex="-1" role="dialog" aria-labelledby="recusarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="recusarModalLabel">Recusar inscrição de participante</h4>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza de que deseja recusar a inscrição do participante?</p> 
                    <p>Este participante não poderá se inscrever novamente no programa.</p>
                </div>
                <div class="modal-footer">
                    <form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-danger">Recusar inscrição</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h1>Participantes</h1>
            <div class="well well-sm">
                <form id="participantes" class="form-inline" role="form">
                    <div class="form-group">
                        <label for="nome" class="sr-only" class="control-label">Nome:</label>
                        <input type="text" class="form-control" required id="nome" placeholder="Nome" ng-model="participantesFilter.nome" >
                    </div>
                    <div class="form-group">
                        <label for="sobrenome" class="sr-only" class="control-label">Sobrenome:</label>
                        <input type="text" class="form-control" required id="sobrenome" placeholder="Sobrenome" ng-model="participantesFilter.sobrenome" >
                    </div>
                    <div class="form-group">
                        <label for="status" class="sr-only" class="control-label">Status:</label>
                        <select class="form-control" required id="status" ng-model="participantesFilter.status">
                            <option value="">Todos</option>
                            <option value="Aprovado">Somente Aprovados</option>
                            <option value="Pendente">Somente Pendentes</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Data de Cadastro</th>
                        <th>Data de Vencimento</th>
                        <th>Status</th>
                        <th>Opções</th>
                    </tr>
                    <tr ng-repeat="participante in participantes| filter:participantesFilter">
                        <td>{{participante.nome}} {{participante.sobrenome}}</td>
                        <td>{{participante.cpf}}</td>
                        <td>{{participante.data_cadastro}}</td>
                        <td>{{participante.data_vencimento}}</td>
                        <td>{{participante.status}}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-sm btn-default" href="?pg=administracao/participante_edicao&id={{participante.id}}">Editar</a>
                                <a class="btn btn-sm btn-primary" ng-show="participante.status == 'Pendente'"  data-toggle="modal" data-target="#aprovarModal">Aprovar inscrição</a>
                                <a class="btn btn-sm btn-default" ng-show="participante.status == 'Expirado'"  data-toggle="modal" data-target="#renovarModal">Renovar inscrição</a>
                                <a class="btn btn-sm btn-danger" ng-show="participante.status == 'Pendente'"  data-toggle="modal" data-target="#recusarModal">Recusar inscrição</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div> <!-- /container -->
</div>
