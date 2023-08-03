<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserV extends Migration
{
    public function up()
    {
        $this->db->query('DROP VIEW IF EXISTS user_v');
        $this->db->query("CREATE OR REPLACE VIEW user_v 
        AS SELECT 
    users.id AS user_id,
    users.email,
    users.password,
    users.employee_id,
    employees.employee_no,
    employees.name AS employee_name,
    employees.email AS employee_email,
    employees.phone_no AS employee_phone
FROM users
LEFT JOIN employees ON users.employee_id = employees.id;
        ");
    }

    public function down()
    {
        $this->db->query('DROP VIEW IF EXISTS user_v');
    }
}
