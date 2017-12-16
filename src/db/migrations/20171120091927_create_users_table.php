<?php


use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('accounts', ['signed' => false,'engine' => 'MyISAM']);
        $table->addColumn('username', 'string', ['limit' => 50])
              ->addColumn('hashed', 'string', ['limit' => 255])
              ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP','update' => 'CURRENT_TIMESTAMP'])
              ->addIndex(['username', 'hashed'], ['unique' => true])
              ->create();
     
      $table = $this->table('accounts_info', ['signed' => false,'engine' => 'MyISAM']);
      $table->addColumn('accounts_id', 'integer')
              ->addColumn('iat', 'string', ['limit' => 255])
              ->addColumn('exp', 'string', ['limit' => 255])
              ->addColumn('jti', 'string', ['limit' => 255])
              ->addColumn('scope', 'string', ['limit' => 350])
              ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP','update' => 'CURRENT_TIMESTAMP'])
              ->create();

    }
}
