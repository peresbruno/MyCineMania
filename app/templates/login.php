
<div class="espaco-topo">
    <form role="form" id="participante_cadastro">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Entrar!</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div style="height: 1px; background:#cdcdcd; margin: 20px 0px 20px 0px"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario" class="control-label">Usuário: <?php echo  OBG ?></label>
                                <input type="text" class="form-control" required id="usuario" placeholder="Usuário">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="senha">Senha: <?php echo  OBG ?></label>
                                <input type="password" class="form-control" required id="senha" placeholder="Senha">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="checkbox" class="" required id="manter_conectado">
                                Manter conectado
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <a href="?pg=login&senha=new">
                                   Esqueci minha senha
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($_GET['senha'])){ ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                   Basta informar seu endereço de e-mail que você usou no cadastro que enviaremos a você uma nova senha:
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                   <input type="text" class="form-control" required id="recupera_senha" placeholder="Endereço de e-mail">
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary pull-right">Enviar</button>
                        </div>
                    </div>
                    <?php }else{ ?>
                    
                    
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary pull-right">Entrar</button>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Ainda não é cadastrado?</h2>
                             <p>Faça seu cadastro como <a href="participante_cadastro.php">participante do programa</a> ou <a href="rede_cinema_cadastro.php">rede de cinema</a>.</p>
                            <div class="well well-sm">
                                <h4>Ajuda</h4>
                                <dl>
                                    <dt>Adminisitrador</dt>
                                    <dd>Use <kbd>administrador</kbd> como usuário e <kbd>administrador</kbd> como senha para acessar a área do administrador.</dd>
                                    <dt>Participante do Programa</dt>
                                    <dd>Use <kbd>participante</kbd> como usuário e <kbd>participante</kbd> como senha para acessar a área do participante.</dd>
                                    <dt>Adminisitrador da rede de cinema</dt>
                                    <dd>Use <kbd>cinema</kbd> como usuário e <kbd>cinema</kbd> como senha para acessar a área do administrador da rede de cinema.</dd>
                                    <dt>Atendente do Guichê do Cinema</dt>
                                    <dd>Use <kbd>caixa</kbd> como usuário e <kbd>caixa</kbd> como senha para acessar a área do atendente do guichê do cinema.</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /container -->
    </form>
</div>