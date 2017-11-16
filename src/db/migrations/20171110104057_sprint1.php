<?php


use Phinx\Migration\AbstractMigration;

class Sprint1 extends AbstractMigration
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
        $table = $this->table('marcas', ['signed' => false,'engine' => 'MyISAM']);
        $table->addColumn('marca', 'string', ['limit' => 50])
              ->addColumn('producto', 'string', ['limit' => 155])
              ->addColumn('alternativa', 'string', ['limit' => 155])
              ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP','update' => 'CURRENT_TIMESTAMP'])
              ->addIndex([ 'marca','producto'])
              ->create();
    }
}
