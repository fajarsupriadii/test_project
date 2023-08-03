<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrder extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => '255',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'office' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'order_date' => [
                'type' => 'TIMESTAMP',
            ],
            'item' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'amount' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'currency' => [
                'type' => 'BIGINT',
                'constraint' => '255',
            ],
            'employee_id' => [
                'type' => 'BIGINT',
                'constraint' => '255',
            ],
            'client_id' => [
                'type' => 'BIGINT',
                'constraint' => '255',
            ],
            'created_by' => [
                'type' => 'BIGINT',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
