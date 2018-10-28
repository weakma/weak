<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181028063944 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL COMMENT \'用户id\', token VARCHAR(32) NOT NULL COMMENT \'令牌\', expired_at DATETIME NOT NULL COMMENT \'过期时间\', created_at DATETIME NOT NULL, INDEX token_index (token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, type SMALLINT DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, gender SMALLINT NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', is_active TINYINT(1) DEFAULT \'1\' NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX username (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `merchant` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(64) NOT NULL COMMENT \'商户名称\' , `opening_time` TIME NULL COMMENT \'营业开始时间\' , `closed_time` TIME NULL COMMENT \'营业结束时间\' , `week` JSON NULL COMMENT \'营业周\' , `tel` VARCHAR(12) NULL COMMENT \'商家电话\' , `brand` VARCHAR(64) NULL COMMENT \'品牌\' , `shop_logo` VARCHAR(255) NULL COMMENT \'商标\' , `province` INT NULL COMMENT \'省\' , `city` INT NULL COMMENT \'市\' , `district` INT NULL COMMENT \'区县\' , `street` VARCHAR(100) NULL COMMENT \'街道地址\' , `longitude` FLOAT NULL COMMENT \'经度\' , `latitude` FLOAT NULL COMMENT \'纬度\' , `version` SMALLINT(4) NOT NULL COMMENT \'版本\' , `expire_date` DATE NOT NULL COMMENT \'到期日期\' , `created_at` DATETIME NOT NULL COMMENT \'创建时间\' , PRIMARY KEY (`id`), INDEX `merchant_name` (`name`)) ENGINE = InnoDB COMMENT = \'商户信息表\';');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE merchant');
    }
}
