<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderV extends Migration
{
    public function up()
    {
        $this->db->query('DROP VIEW IF EXISTS order_v');
        $this->db->query("CREATE OR REPLACE VIEW order_v 
        AS SELECT 
    orders.id AS order_id,
    orders.office,
    orders.order_date,
    orders.item,
    orders.amount,
    currency.code AS currency,
    orders.employee_id,
    employees.employee_no,
    employees.name AS employee_name,
    employees.email AS employee_email,
    employees.phone_no AS employee_phone,
    orders.client_id,
    clients.client_no,
    clients.name AS client_name,
    clients.email AS client_email,
    clients.phone_no AS client_phone
FROM orders
LEFT JOIN employees ON orders.employee_id = employees.id
LEFT JOIN clients ON orders.client_id = clients.id
LEFT JOIN lookups currency ON orders.currency = currency.id;
        ");
    }

    public function down()
    {
        $this->db->query('DROP VIEW IF EXISTS order_v');
    }
}
