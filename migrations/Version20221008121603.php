<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221008121603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alergeno (id INT AUTO_INCREMENT NOT NULL, alergeno VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cantidad_platos_pedido (id INT AUTO_INCREMENT NOT NULL, pedido_id INT NOT NULL, plato_id INT NOT NULL, cantidad INT NOT NULL, INDEX IDX_411A751E4854653A (pedido_id), INDEX IDX_411A751EB0DB09EF (plato_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, categoria VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) NOT NULL, telefono VARCHAR(12) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comentario (id INT AUTO_INCREMENT NOT NULL, restaurante_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, comentario VARCHAR(255) DEFAULT NULL, puntos DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_4B91E70238B81E49 (restaurante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE direccion (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, municipio_id INT NOT NULL, provincia_id INT NOT NULL, calle VARCHAR(255) NOT NULL, numero VARCHAR(50) DEFAULT NULL, puerta_piso_escalera VARCHAR(255) DEFAULT NULL, cod_postal INT NOT NULL, INDEX IDX_F384BE95DE734E51 (cliente_id), INDEX IDX_F384BE9558BC1BE0 (municipio_id), INDEX IDX_F384BE954E7121AF (provincia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado (id INT AUTO_INCREMENT NOT NULL, estado VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horario_restaurante (id INT AUTO_INCREMENT NOT NULL, restaurante_id INT NOT NULL, dia INT NOT NULL, apertura TIME NOT NULL, cierre TIME NOT NULL, INDEX IDX_57DDC29738B81E49 (restaurante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedido (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, estado_id INT NOT NULL, restaurante_id INT NOT NULL, direccion_id INT NOT NULL, total DOUBLE PRECISION NOT NULL, fecha_entrega DATETIME NOT NULL, INDEX IDX_C4EC16CEDE734E51 (cliente_id), INDEX IDX_C4EC16CE9F5A440B (estado_id), INDEX IDX_C4EC16CE38B81E49 (restaurante_id), INDEX IDX_C4EC16CED0A7BD7 (direccion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plato (id INT AUTO_INCREMENT NOT NULL, restaurante_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, descripcion VARCHAR(255) DEFAULT NULL, imagen_url VARCHAR(255) DEFAULT NULL, INDEX IDX_914B3E4538B81E49 (restaurante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plato_alergeno (plato_id INT NOT NULL, alergeno_id INT NOT NULL, INDEX IDX_9A742E08B0DB09EF (plato_id), INDEX IDX_9A742E083E89035 (alergeno_id), PRIMARY KEY(plato_id, alergeno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurante (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, logo_url VARCHAR(255) NOT NULL, imagen_url VARCHAR(255) DEFAULT NULL, descripcion VARCHAR(255) DEFAULT NULL, destacado TINYINT(1) NOT NULL, valoracion_media DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurante_municipios (restaurante_id INT NOT NULL, municipios_id INT NOT NULL, INDEX IDX_77D4A18138B81E49 (restaurante_id), INDEX IDX_77D4A1814723E346 (municipios_id), PRIMARY KEY(restaurante_id, municipios_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurante_categoria (restaurante_id INT NOT NULL, categoria_id INT NOT NULL, INDEX IDX_6C73809938B81E49 (restaurante_id), INDEX IDX_6C7380993397707A (categoria_id), PRIMARY KEY(restaurante_id, categoria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cantidad_platos_pedido ADD CONSTRAINT FK_411A751E4854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id)');
        $this->addSql('ALTER TABLE cantidad_platos_pedido ADD CONSTRAINT FK_411A751EB0DB09EF FOREIGN KEY (plato_id) REFERENCES plato (id)');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E70238B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id)');
        $this->addSql('ALTER TABLE direccion ADD CONSTRAINT FK_F384BE95DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE direccion ADD CONSTRAINT FK_F384BE9558BC1BE0 FOREIGN KEY (municipio_id) REFERENCES municipios (id)');
        $this->addSql('ALTER TABLE direccion ADD CONSTRAINT FK_F384BE954E7121AF FOREIGN KEY (provincia_id) REFERENCES provincias (id)');
        $this->addSql('ALTER TABLE horario_restaurante ADD CONSTRAINT FK_57DDC29738B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id)');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CEDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE9F5A440B FOREIGN KEY (estado_id) REFERENCES estado (id)');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE38B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id)');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CED0A7BD7 FOREIGN KEY (direccion_id) REFERENCES direccion (id)');
        $this->addSql('ALTER TABLE plato ADD CONSTRAINT FK_914B3E4538B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id)');
        $this->addSql('ALTER TABLE plato_alergeno ADD CONSTRAINT FK_9A742E08B0DB09EF FOREIGN KEY (plato_id) REFERENCES plato (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plato_alergeno ADD CONSTRAINT FK_9A742E083E89035 FOREIGN KEY (alergeno_id) REFERENCES alergeno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurante_municipios ADD CONSTRAINT FK_77D4A18138B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurante_municipios ADD CONSTRAINT FK_77D4A1814723E346 FOREIGN KEY (municipios_id) REFERENCES municipios (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurante_categoria ADD CONSTRAINT FK_6C73809938B81E49 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurante_categoria ADD CONSTRAINT FK_6C7380993397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cantidad_platos_pedido DROP FOREIGN KEY FK_411A751E4854653A');
        $this->addSql('ALTER TABLE cantidad_platos_pedido DROP FOREIGN KEY FK_411A751EB0DB09EF');
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E70238B81E49');
        $this->addSql('ALTER TABLE direccion DROP FOREIGN KEY FK_F384BE95DE734E51');
        $this->addSql('ALTER TABLE direccion DROP FOREIGN KEY FK_F384BE9558BC1BE0');
        $this->addSql('ALTER TABLE direccion DROP FOREIGN KEY FK_F384BE954E7121AF');
        $this->addSql('ALTER TABLE horario_restaurante DROP FOREIGN KEY FK_57DDC29738B81E49');
        $this->addSql('ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CEDE734E51');
        $this->addSql('ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE9F5A440B');
        $this->addSql('ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE38B81E49');
        $this->addSql('ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CED0A7BD7');
        $this->addSql('ALTER TABLE plato DROP FOREIGN KEY FK_914B3E4538B81E49');
        $this->addSql('ALTER TABLE plato_alergeno DROP FOREIGN KEY FK_9A742E08B0DB09EF');
        $this->addSql('ALTER TABLE plato_alergeno DROP FOREIGN KEY FK_9A742E083E89035');
        $this->addSql('ALTER TABLE restaurante_municipios DROP FOREIGN KEY FK_77D4A18138B81E49');
        $this->addSql('ALTER TABLE restaurante_municipios DROP FOREIGN KEY FK_77D4A1814723E346');
        $this->addSql('ALTER TABLE restaurante_categoria DROP FOREIGN KEY FK_6C73809938B81E49');
        $this->addSql('ALTER TABLE restaurante_categoria DROP FOREIGN KEY FK_6C7380993397707A');
        $this->addSql('DROP TABLE alergeno');
        $this->addSql('DROP TABLE cantidad_platos_pedido');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE comentario');
        $this->addSql('DROP TABLE direccion');
        $this->addSql('DROP TABLE estado');
        $this->addSql('DROP TABLE horario_restaurante');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('DROP TABLE plato');
        $this->addSql('DROP TABLE plato_alergeno');
        $this->addSql('DROP TABLE restaurante');
        $this->addSql('DROP TABLE restaurante_municipios');
        $this->addSql('DROP TABLE restaurante_categoria');
    }
}
