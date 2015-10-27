<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\mysql_close()qlAdapter;

class CreateUsersTable extends AbstractMigration {

     public function up() {
       $table = $this->table('users');
       $table->addColumn('name', 'string',['limit'=>100])
             ->addColumn('description', 'text',['null' => true])
             ->addColumn('photo', 'string',['null' => true])
             ->addColumn('email', 'string')
             ->addColumn('password', 'string',['limit'=>60])
             ->addColumn('slug', 'string',['limit'=>70])
             ->addIndex(array('slug'), array('unique' => true))
             ->addColumn('role', 'integer',   array('limit' => MysqlAdapter::INT_TINY))
             ->addColumn('status', 'integer',   array('limit' => MysqlAdapter::INT_TINY))
             ->addColumn('token', 'string',['null' => true])
             ->addColumn('created', 'datetime')
             ->create();
     }

     public function down() {
        $this->dropTable('users');
     }
}
