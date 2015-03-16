<script src="/js/participante_cadastro.js"></script>
<div class="espaco-topo">
    <form role="form" id="participante_cadastro">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Renovar minha inscrição!</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome" class="control-label">Nome: <?php echo  OBG ?></label>
                                <input type="text" class="form-control" readonly="readonly" required id="nome" placeholder="Nome">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sobrenome" class="control-label">Sobrenome: <?php echo  OBG ?></label>
                                <input type="text" class="form-control" readonly="readonly" required id="sobrenome" placeholder="Sobrenome">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario" class="control-label">Usuário: <?php echo  OBG ?></label>
                                <input type="text" class="form-control" readonly="readonly" required id="usuario" placeholder="Usuário">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">&nbsp;</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">E-mail: <?php echo  OBG ?></label>
                                <input type="email" class="form-control" readonly="readonly" required id="email" placeholder="E-mail">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cpf" class="control-label">CPF: <?php echo  OBG ?></label>
                                <input type="text" class="form-control" readonly="readonly" required id="cpf" placeholder="CPF" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Digite o CPF no formato nnn.nnn.nnn-nn">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="regulamento" class="control-label">Interesses:</label>
                                <div>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="">
                                        Suspense
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="">
                                        Terror
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="">
                                        Ação
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="">
                                        Comédia
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="">
                                        Drama
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="">
                                        Animação
                                    </label>
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="">
                                        Ficção científica
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="regulamento">Regulamento e Termos: <?php echo  OBG ?></label>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="" checked="checked" required>
                                        Estou ciente e concordo com o <a href="#">regulamento</a> do programa.
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="" checked="checked" required>
                                        Estou ciente e concordo com a <a href="#">política de privacidade</a> do programa.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">Gerar boleto bancário e enviar por e-mail</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Informações</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Sua renovação somente será válida após a confirmação do pagamento do boleto bancário.</p>
                            <p>Caso a sua inscrição no programa tenha expirado você não terá acesso ao sistema até que esta confirmação seja feita.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /container -->
    </form>
</div>