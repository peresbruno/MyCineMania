<?php include_once('partes/topo.php'); ?>
<script src="js/rede_cinema_cadastro.js"></script>
<form role="form" id="rede_cinema_cadastro">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Desejo inscrever minha rede!</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome" class="control-label">Nome: <?= OBG ?></label>
                            <input type="text" class="form-control" required id="nome" placeholder="Nome">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sobrenome" class="control-label">Sobrenome: <?= OBG ?></label>
                            <input type="text" class="form-control" required id="sobrenome" placeholder="Sobrenome">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usuario" class="control-label">Usuário: <?= OBG ?></label>
                            <input type="text" class="form-control" required id="usuario" placeholder="Usuário">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <div>[verificando...]</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="senha">Senha: <?= OBG ?></label>
                            <input type="password" class="form-control" required id="senha" placeholder="Senha">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="senha_confirmacao">Repetir Senha: <?= OBG ?></label>
                            <input type="password" class="form-control" required id="senha_confirmacao" placeholder="Repetir Senha">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">E-mail: <?= OBG ?></label>
                            <input type="email" class="form-control" required id="email" placeholder="E-mail">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email_confirmacao">Repetir e-mail: <?= OBG ?></label>
                            <input type="email" class="form-control" required id="email_confirmacao" placeholder="Repetir e-mail">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cpf" class="control-label">CPF: <?= OBG ?></label>
                            <input type="text" class="form-control" required id="cpf" placeholder="CPF" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Digite o CPF no formato nnn.nnn.nnn-nn">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <div>[verificando...]</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="razao_social" class="control-label">Razão Social: <?= OBG ?></label>
                                    <input type="text" class="form-control" required id="razao_social" placeholder="Razão Social">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cnpj" class="control-label">CNPJ: <?= OBG ?></label>
                                    <input type="text" class="form-control" required id="cnpj" placeholder="CPF" pattern="\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2}" title="Digite o CPF no formato nn.nnn.nnn/nnnn-nn">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="endereco" class="control-label">Endereço da sede: <?= OBG ?></label>
                            <textarea id="endereco" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="regulamento">Regulamento e Termos: <?= OBG ?></label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" required>
                                    Estou ciente e concordo com o <a href="#">regulamento</a> do programa.
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="" required>
                                    Estou ciente e concordo com a <a href="#">política de privacidade</a> do programa.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">Cadastrar</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Rede já cadastrada</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="login.php">Faça login</a> para acessar a área privativa.
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /container -->
</form>
<?php include_once('partes/base.php'); ?>