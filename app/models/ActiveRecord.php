<?php
abstract class ActiveRecord
{
    /** @type DB $db */
    protected $db;

    public function __construct(DB $db) {
        $this->db = $db;
    }

    /**
     * Insert record into DB
     */
    abstract function insert();

    /**
     * Update record in DB
     */
    abstract function update();

    /**
     * Delete record from DB
     */
    abstract function delete();

    /**
     * Checks if field is empty
     *
     * @param mixed $field
     * @throws Exception
     */
    protected function checkIfEmpty($field) {
        if (empty($field)) {
            throw new Exception('All form fields must be filled in');
        }
    }
}