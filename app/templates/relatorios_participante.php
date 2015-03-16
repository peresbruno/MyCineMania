<script src="/js/participante_cadastro.js"></script>
<div class="espaco-topo">
    <form role="form" id="participante_cadastro">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Relatório de Vouchers - Participante</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome" class="control-label">Rede de Cinema: </label>
                                <select class="form-control">
                                    <option>Rede de Exemplo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sobrenome" class="control-label">Uso entre: <?php echo  OBG ?></label>
                                <input type="text" class="form-control" required id="inicio" placeholder="Início"> e 
                                <input type="text" class="form-control" required id="sobrenome" placeholder="Fim">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">Gerar relatório</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    
                </div>
            </div>
        </div> <!-- /container -->
    </form>
</div>