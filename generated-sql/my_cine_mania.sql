
-----------------------------------------------------------------------
-- preferencias
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "preferencias" CASCADE;

CREATE TABLE "preferencias"
(
    "id" serial NOT NULL,
    "descricao" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- usuarios
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "usuarios" CASCADE;

CREATE TABLE "usuarios"
(
    "id" serial NOT NULL,
    "data_inscricao" DATE NOT NULL,
    "email" VARCHAR(255) NOT NULL,
    "liberado" BOOLEAN DEFAULT 'f' NOT NULL,
    "nome_usuario" VARCHAR(255) NOT NULL,
    "senha" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- participantes
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "participantes" CASCADE;

CREATE TABLE "participantes"
(
    "id" serial NOT NULL,
    "usuario_id" INTEGER NOT NULL,
    "cpf" VARCHAR(50) NOT NULL,
    "fim_validade" DATE,
    "nome" VARCHAR(255),
    "sobrenome" VARCHAR(255),
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- redes_cinema
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "redes_cinema" CASCADE;

CREATE TABLE "redes_cinema"
(
    "id" serial NOT NULL,
    "cnpj" VARCHAR(50) NOT NULL,
    "nome_fantasia" VARCHAR(255) NOT NULL,
    "razao_social" VARCHAR(255) NOT NULL,
    "endereco" TEXT NOT NULL,
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- usuarios_rede_cinema
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "usuarios_rede_cinema" CASCADE;

CREATE TABLE "usuarios_rede_cinema"
(
    "id" serial NOT NULL,
    "usuario_id" INTEGER NOT NULL,
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- beneficios
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "beneficios" CASCADE;

CREATE TABLE "beneficios"
(
    "id" serial NOT NULL,
    "rede_cinema_id" INTEGER NOT NULL,
    "titulo" VARCHAR(255) NOT NULL,
    "inicio_validade" DATE NOT NULL,
    "fim_validade" DATE NOT NULL,
    "descricao" TEXT NOT NULL,
    "condicoes" TEXT NOT NULL,
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- beneficios_preferencias
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "beneficios_preferencias" CASCADE;

CREATE TABLE "beneficios_preferencias"
(
    "preferencia_id" INTEGER NOT NULL,
    "beneficio_id" INTEGER NOT NULL,
    PRIMARY KEY ("preferencia_id","beneficio_id")
);

-----------------------------------------------------------------------
-- participantes_preferencias
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "participantes_preferencias" CASCADE;

CREATE TABLE "participantes_preferencias"
(
    "participante_id" INTEGER NOT NULL,
    "beneficio_id" INTEGER NOT NULL,
    PRIMARY KEY ("participante_id","beneficio_id")
);

-----------------------------------------------------------------------
-- pagamentos
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "pagamentos" CASCADE;

CREATE TABLE "pagamentos"
(
    "id" serial NOT NULL,
    "participante_id" INTEGER NOT NULL,
    "data_pagamento" DATE,
    "data_vencimento" DATE NOT NULL,
    "numero_boleto" VARCHAR(50),
    "valor" DOUBLE PRECISION NOT NULL,
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- vouchers
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "vouchers" CASCADE;

CREATE TABLE "vouchers"
(
    "id" serial NOT NULL,
    "beneficio_id" INTEGER NOT NULL,
    "participante_id" INTEGER NOT NULL,
    "status" VARCHAR(50) NOT NULL,
    "codigo" VARCHAR(50) NOT NULL,
    "data_emissao" DATE NOT NULL,
    "hora_emissao" TIME NOT NULL,
    PRIMARY KEY ("id")
);

ALTER TABLE "participantes" ADD CONSTRAINT "participantes_fk_614747"
    FOREIGN KEY ("usuario_id")
    REFERENCES "usuarios" ("id");

ALTER TABLE "usuarios_rede_cinema" ADD CONSTRAINT "usuarios_rede_cinema_fk_614747"
    FOREIGN KEY ("usuario_id")
    REFERENCES "usuarios" ("id");

ALTER TABLE "beneficios" ADD CONSTRAINT "beneficios_fk_f9c4c1"
    FOREIGN KEY ("rede_cinema_id")
    REFERENCES "redes_cinema" ("id");

ALTER TABLE "beneficios_preferencias" ADD CONSTRAINT "beneficios_preferencias_fk_4019bf"
    FOREIGN KEY ("preferencia_id")
    REFERENCES "preferencias" ("id");

ALTER TABLE "beneficios_preferencias" ADD CONSTRAINT "beneficios_preferencias_fk_9665b2"
    FOREIGN KEY ("beneficio_id")
    REFERENCES "beneficios" ("id");

ALTER TABLE "participantes_preferencias" ADD CONSTRAINT "participantes_preferencias_fk_c65b3e"
    FOREIGN KEY ("participante_id")
    REFERENCES "participantes" ("id");

ALTER TABLE "participantes_preferencias" ADD CONSTRAINT "participantes_preferencias_fk_9665b2"
    FOREIGN KEY ("beneficio_id")
    REFERENCES "beneficios" ("id");

ALTER TABLE "pagamentos" ADD CONSTRAINT "pagamentos_fk_c65b3e"
    FOREIGN KEY ("participante_id")
    REFERENCES "participantes" ("id");

ALTER TABLE "vouchers" ADD CONSTRAINT "vouchers_fk_9665b2"
    FOREIGN KEY ("beneficio_id")
    REFERENCES "beneficios" ("id");

ALTER TABLE "vouchers" ADD CONSTRAINT "vouchers_fk_c65b3e"
    FOREIGN KEY ("participante_id")
    REFERENCES "participantes" ("id");
