<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180214185713 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tarefa DROP FOREIGN KEY tarefa_ibfk_1');
        $this->addSql('DROP INDEX caminho ON tarefa');
        $this->addSql('DROP INDEX id_usuario ON tarefa');
        $this->addSql('ALTER TABLE tarefa DROP id_usuario, CHANGE descricao descricao VARCHAR(255) NOT NULL, CHANGE ativo ativo INT NOT NULL, CHANGE data_criacao data_criacao DATETIME NOT NULL');
        $this->addSql('ALTER TABLE agendamento DROP FOREIGN KEY agendamento_ibfk_1');
        $this->addSql('ALTER TABLE agendamento DROP FOREIGN KEY agendamento_ibfk_2');
        $this->addSql('DROP INDEX id_tarefa ON agendamento');
        $this->addSql('DROP INDEX id_usuario ON agendamento');
        $this->addSql('ALTER TABLE agendamento CHANGE id_usuario usuario INT NOT NULL');
        $this->addSql('ALTER TABLE log_tarefa DROP FOREIGN KEY log_tarefa_ibfk_1');
        $this->addSql('DROP INDEX id_agendamento ON log_tarefa');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agendamento CHANGE usuario id_usuario INT NOT NULL');
        $this->addSql('ALTER TABLE agendamento ADD CONSTRAINT agendamento_ibfk_1 FOREIGN KEY (id_tarefa) REFERENCES tarefa (id)');
        $this->addSql('ALTER TABLE agendamento ADD CONSTRAINT agendamento_ibfk_2 FOREIGN KEY (id_usuario) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX id_tarefa ON agendamento (id_tarefa)');
        $this->addSql('CREATE INDEX id_usuario ON agendamento (id_usuario)');
        $this->addSql('ALTER TABLE log_tarefa ADD CONSTRAINT log_tarefa_ibfk_1 FOREIGN KEY (id_agendamento) REFERENCES agendamento (id)');
        $this->addSql('CREATE INDEX id_agendamento ON log_tarefa (id_agendamento)');
        $this->addSql('ALTER TABLE tarefa ADD id_usuario INT NOT NULL, CHANGE descricao descricao VARCHAR(100) NOT NULL COLLATE utf8_bin, CHANGE ativo ativo INT DEFAULT 1 NOT NULL, CHANGE data_criacao data_criacao DATETIME DEFAULT \'current_timestamp()\' NOT NULL');
        $this->addSql('ALTER TABLE tarefa ADD CONSTRAINT tarefa_ibfk_1 FOREIGN KEY (id_usuario) REFERENCES usuario (id)');
        $this->addSql('CREATE UNIQUE INDEX caminho ON tarefa (caminho)');
        $this->addSql('CREATE INDEX id_usuario ON tarefa (id_usuario)');
    }
}
