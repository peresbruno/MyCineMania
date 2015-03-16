<div class="espaco-topo">
<script src="/js/redes_de_cinema.js"></script>
<div class="container">
    <div class="modal fade" id="aprovarModal" tabindex="-1" role="dialog" aria-labelledby="aprovarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="aprovarModalLabel">Aprovar inscrição de rede de cinema</h4>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza de que deseja aprovar a inscrição da rede de cinema?</p> 
                    <p>A rede de cinema poderá cadastrar benefícios.</p>
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
    <div class="row">
        <div class="col-md-12">
            <h1>Redes de Cinema</h1>
            <div class="well well-sm">
                <form id="participantes" class="form-inline" role="form">
                    <div class="form-group">
                        <label for="rede" class="sr-only" class="control-label">Rede:</label>
                        <input type="text" class="form-control" required id="rede" placeholder="Rede" ng-model="redesFiltro.rede" >
                    </div>
                    <div class="form-group">
                        <label for="status" class="sr-only" class="control-label">Status:</label>
                        <select class="form-control" required id="status" ng-model="redesFiltro.status">
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
                        <th>CNPJ</th>
                        <th>Endereço</th>
                        <th>Status</th>
                        <th>Opções</th>
                    </tr>
                    <tr ng-repeat="rede in redes_de_cinema| filter:redesFiltro">
                        <td>{{rede.rede}}</td>
                        <td>{{rede.cnpj}}</td>
                        <td>{{rede.endereco}}</td>
                        <td>{{rede.status}}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-sm btn-default" href="?pg=administracao/rede_de_cinema_edicao&id={{rede.id}}">Editar</a>
                                <a class="btn btn-sm btn-primary" ng-show="rede.status == 'Pendente'"  data-toggle="modal" data-target="#aprovarModal">Aprovar inscrição</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div> <!-- /container -->
</div>
