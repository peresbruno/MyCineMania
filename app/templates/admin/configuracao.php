<div class="espaco-topo">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Configurações</h1>
            <form id="configuracoes">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="taxa_adesao" class="control-label">Valor da Taxa de Adesão ao Programa: <?= OBG ?></label>
                            <input type="number" step="0.01" class="form-control" required id="taxa_adesao" placeholder="Valor da Taxa de Adesão ao Programa">
                        </div>                    
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="aceitando_inscricoes" class="control-label">Aceitando Inscrições:</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Aceitando Inscrições de Participantes
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="">
                                    Aceitando Inscrições de Redes de Cinema
                                </label>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">Salvar configurações</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> <!-- /container -->
</div>
