<div class="espaco-topo">
    <form role="form" id="participante_cadastro">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Cadastro de Benefício</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome" class="control-label">Título: <?php echo  OBG ?></label>
                                <input type="text" class="form-control" required id="nome" placeholder="Título">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sobrenome" class="control-label">Data: <?php echo  OBG ?></label>
                                <input type="text" class="form-control" required id="sobrenome" placeholder="Data">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario" class="control-label">Descrição: <?php echo  OBG ?></label>
                                <textarea class="form-control" required id="usuario" placeholder="Descrição"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuarxio" class="control-label">Condições</label>
                                <textarea class="form-control" required id="usuarxio" placeholder="Condições"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuario" class="control-label">Imagem destaque</label>
                                <input type="file" class="form-control" required id="usuario" placeholder="Condições" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usuarxio" class="control-label">Imagem pequena</label>
                                <input type="file" class="form-control" required id="usuarxio" placeholder="Condições" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="regulamento" class="control-label">Recomendar para quem tem os interesses:</label>
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
                                        <input type="checkbox" value="" required>
                                        Estou ciente e concordo com o <a href="#">regulamento</a> do programa.
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary pull-right">Cadastrar Benefício</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div> <!-- /container -->
    </form>
</div>