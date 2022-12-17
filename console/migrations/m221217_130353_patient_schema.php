<?php

use yii\db\Migration;

/**
 * Class m221217_130353_patient_schema
 */
class m221217_130353_patient_schema extends Migration
{
    private string $tablePatient = 'patient';
    private string $tablePatientHistory = 'patient_history';
    private string $tableAppointment = 'appointment';
    private string $tableService = 'service';
    private string $tableProcedure = 'procedure';

    private int $statusActive = 1;
    private int $statusClosed = 2;

    private int $genderMale = 1;
    private int $genderFemale = 2;
    private int $genderOther = 3;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createPatientTable();
        $this->createPatientHistoryTable();
        $this->createAppointmentTable();
        $this->createProcedureTable();
        $this->createServiceTable();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableService);
        $this->dropTable($this->tableProcedure);
        $this->dropTable($this->tablePatientHistory);
        $this->dropTable($this->tablePatient);
        $this->dropTable($this->tableAppointment);
    }

    private function createPatientTable(): void
    {
        $this->createTable($this->tablePatient, [
            'id' => $this->primaryKey(),
            'personal_code' => $this->string(16)->notNull()->unique(),
            'first_name' => $this->string(64)->notNull(),
            'last_name' => $this->string(64)->notNull(),
            'email' => $this->string(64),
            'phone' => $this->string(32),
            'status' => $this->smallInteger(1)->defaultValue($this->statusActive),
            'gender' => $this->smallInteger(1),
            'passport_type' => $this->string(4),
            'passport_code' => $this->string(8),
            'passport_number' => $this->string(10),
            'passport_nationality' => $this->string(128),
            'passport_date_of_birth' => $this->string(32),
            'passport_sex' => $this->string(32),
            'passport_place_of_birth' => $this->string(128),
            'passport_date_of_issue' => $this->string(32),
            'passport_date_of_expiration' => $this->string(32),
            'passport_authority' => $this->string(32),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tablePatient}_personal_code", $this->tablePatient, 'personal_code', true);
        $this->createIndex("{$this->tablePatient}_first_name", $this->tablePatient, 'first_name', true);
        $this->createIndex("{$this->tablePatient}_last_name", $this->tablePatient, 'last_name', true);
        $this->createIndex("{$this->tablePatient}_status", $this->tablePatient, 'status', true);
    }

    private function createPatientHistoryTable(): void
    {
        $this->createTable($this->tablePatientHistory, [
            'id' => $this->primaryKey(),
            'patient_id' => $this->integer(16)->notNull(),
            'personal_code' => $this->string(16)->notNull()->unique(),
            'first_name' => $this->string(64)->notNull(),
            'last_name' => $this->string(64)->notNull(),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tablePatientHistory}_patient_id", $this->tablePatientHistory, 'patient_id', true);
    }

    private function createAppointmentTable(): void
    {
        $this->createTable($this->tableAppointment, [
            'id' => $this->primaryKey(),
            'patient_id' => $this->integer(16)->notNull(),
            'schedule_id' => $this->integer(16)->notNull(),
            'procedure_id' => $this->string(16)->notNull(),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tableAppointment}_patient_id", $this->tableAppointment, 'patient_id', true);
        $this->createIndex("{$this->tableAppointment}_schedule_id", $this->tableAppointment, 'schedule_id', true);
        $this->createIndex("{$this->tableAppointment}_procedure_id", $this->tableAppointment, 'procedure_id', true);
    }

    private function createProcedureTable(): void
    {
        $this->createTable($this->tableProcedure, [
            'id' => $this->primaryKey(),
            'name' => $this->string(256)->notNull(),
            'location' => $this->string(256),
            'type' => $this->smallInteger(1)->notNull(),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tableProcedure}_type", $this->tableProcedure, 'type', true);
        $this->createIndex("{$this->tableProcedure}_name", $this->tableProcedure, 'name', true);
    }

    private function createServiceTable(): void
    {
        $this->createTable($this->tableService, [
            'id' => $this->primaryKey(),
            'procedure_id' => $this->integer(16)->notNull(),
            'name' => $this->string(256)->notNull(),
            'time' => $this->integer(32)->notNull(),
            'practitioner_position' => $this->string(256)->notNull(),

            'created_at' => $this->integer(16),
            'created_by' => $this->integer(8),
            'updated_at' => $this->integer(16),
            'updated_by' => $this->integer(8),
        ]);

        $this->createIndex("{$this->tableService}_procedure_id", $this->tableService, 'procedure_id', true);
    }

}
