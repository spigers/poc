<?php

use yii\db\Migration;

/**
 * Class m221217_121734_employee_schema
 */
class m221217_121734_employee_schema extends Migration
{
    private string $tableEmployee = 'employee';
    private string $tableAttendant = 'attendant';
    private string $tableRole = 'role';
    private string $tableEmployeeRole = 'employee_role';
    private string $tableSchedule = 'schedule';
    private string $tableOffice = 'office';
    private string $tableTimeTable = 'time_table';

    private int $statusActive = 1;
    private int $statusClosed = 2;

    private int $employmentFullTime = 1;
    private int $employmentPartTime = 2;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createEmployeeTable();
        $this->createRoleTable();
        $this->createEmployeeRoleTable();
        $this->createAttendantTable();
        $this->createScheduleTable();
        $this->createOfficeTable();
        $this->createTimeTable();
        $this->createFk();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableTimeTable);
        $this->dropTable($this->tableOffice);
        $this->dropTable($this->tableSchedule);
        $this->dropTable($this->tableAttendant);
        $this->dropTable($this->tableRole);
        $this->dropTable($this->tableEmployee);
        $this->dropTable($this->tableEmployeeRole);
    }

    private function createEmployeeTable(): void
    {
        $this->createTable($this->tableEmployee, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(16),
            'personal_code' => $this->string(16)->notNull()->unique(),
            'first_name' => $this->string(64)->notNull(),
            'last_name' => $this->string(64)->notNull(),
            'email' => $this->string(64),
            'phone' => $this->string(32),
            'status' => $this->smallInteger(1)->defaultValue($this->statusActive),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tableEmployee}_user_id", $this->tableEmployee, 'id', true);
        $this->createIndex("{$this->tableEmployee}_personal_code", $this->tableEmployee, 'personal_code', true);
        $this->createIndex("{$this->tableEmployee}_first_name", $this->tableEmployee, 'first_name', true);
        $this->createIndex("{$this->tableEmployee}_last_name", $this->tableEmployee, 'last_name', true);
        $this->createIndex("{$this->tableEmployee}_status", $this->tableEmployee, 'status', true);
    }

    private function createAttendantTable(): void
    {
        $this->createTable($this->tableAttendant, [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer(16),
            'schedule_id' => $this->integer(16),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tableAttendant}_employee_id", $this->tableAttendant, 'employee_id', true);
        $this->createIndex("{$this->tableAttendant}_schedule_id", $this->tableAttendant, 'schedule_id', true);
    }

    private function createEmployeeRoleTable(): void
    {
        $this->createTable($this->tableEmployeeRole, [
            'id' => $this->primaryKey(),
            'employee_id' => $this->integer(16)->notNull(),
            'role_id' => $this->integer(16)->notNull(),
            'time_start' => $this->integer(16)->notNull(),
            'time_end' => $this->integer(16),
            'status' => $this->smallInteger(1)->defaultValue($this->statusActive),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tableEmployeeRole}_employee_id", $this->tableEmployeeRole, 'employee_id', true);
        $this->createIndex("{$this->tableEmployeeRole}_role_id", $this->tableEmployeeRole, 'role_id', true);
        $this->createIndex("{$this->tableEmployeeRole}_status", $this->tableEmployeeRole, 'status', true);
    }

    private function createRoleTable(): void
    {
        $this->createTable($this->tableRole, [
            'id' => $this->primaryKey(),
            'role_name' => $this->string(256)->notNull(),
            'employment_type' => $this->smallInteger(1)->defaultValue($this->employmentFullTime),
            'status' => $this->smallInteger(1)->defaultValue($this->statusActive),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tableRole}_role_name", $this->tableRole, 'role_name', true);
        $this->createIndex("{$this->tableRole}_employment_type", $this->tableRole, 'employment_type', true);
        $this->createIndex("{$this->tableRole}_status", $this->tableRole, 'status', true);
    }

    private function createScheduleTable(): void
    {
        $this->createTable($this->tableSchedule, [
            'id' => $this->primaryKey(),
            'office_id' => $this->integer(16)->notNull(),
            'attendant_id' => $this->integer(16)->notNull(),
            'status' => $this->smallInteger(1)->defaultValue($this->statusActive),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tableSchedule}_office_id", $this->tableSchedule, 'office_id', true);
        $this->createIndex("{$this->tableSchedule}_attendant_id", $this->tableSchedule, 'attendant_id', true);
        $this->createIndex("{$this->tableSchedule}_status", $this->tableSchedule, 'status', true);
    }

    private function createOfficeTable(): void
    {
        $this->createTable($this->tableOffice, [
            'id' => $this->primaryKey(),
            'time_table_id' => $this->integer(16),
            'name' => $this->string(128),
            'number' => $this->string(16),
            'floor' => $this->string(16),
            'address' => $this->string(256),
            'status' => $this->smallInteger(1)->defaultValue($this->statusActive),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tableOffice}_time_table_id", $this->tableOffice, 'time_table_id', true);
        $this->createIndex("{$this->tableOffice}_status", $this->tableOffice, 'status', true);
    }

    private function createTimeTable(): void
    {
        $this->createTable($this->tableTimeTable, [
            'id' => $this->primaryKey(),
            'time_start' => $this->integer(16)->notNull(),
            'time_end' => $this->integer(16),
            'status' => $this->smallInteger(1)->defaultValue($this->statusActive),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tableTimeTable}_status", $this->tableTimeTable, 'status', true);
    }

    private function createFk(): void
    {
        // employee_role FKs
        $this->addForeignKey('fk-employee_role-employee_id', $this->tableEmployeeRole, 'employee_id', $this->tableEmployee, 'id', 'CASCADE');
        $this->addForeignKey('fk-employee_role-role_id', $this->tableEmployeeRole, 'role_id', $this->tableRole, 'id', 'CASCADE');

        // attendant FKs
        $this->addForeignKey('fk-attendant-employee_id', $this->tableAttendant, 'employee_id', $this->tableEmployee, 'id', 'CASCADE');
        $this->addForeignKey('fk-attendant-schedule_id', $this->tableAttendant, 'schedule_id', $this->tableSchedule, 'id', 'CASCADE');

        // schedule FKs
        $this->addForeignKey('fk-schedule-office_id', $this->tableSchedule, 'office_id', $this->tableOffice, 'id', 'CASCADE');
        $this->addForeignKey('fk-schedule-attendant_id', $this->tableSchedule, 'attendant_id', $this->tableAttendant, 'id', 'CASCADE');

        // office FKs
        $this->addForeignKey('fk-office-time_table_id', $this->tableOffice, 'time_table_id', $this->tableTimeTable, 'id', 'CASCADE');
    }
}
