<?php

namespace models;

use db\Model;

/**
 * Class Comment
 * Comment model
 *
 * @package models
 */
class Task extends Model
{

    const FLAG_DEFAULT = 0;
    const FLAG_TODO = 0;
    const FLAG_DONE = 1;

    public function getName()
    {
        return $this->_values['user_name'] ?? '';
    }

    public function getEmail()
    {
        return $this->_values['email'] ?? '';
    }

    public function getText()
    {
        return $this->_values['text'] ?? '';
    }

    public function getFlag()
    {
        return (int) $this->_values['flag'] ?? '';
    }

    public function getFlagTitle(int $flag)
    {
        $titles = [
            self::FLAG_TODO => 'Todo',
            self::FLAG_DONE => 'Done',
        ];
        return $titles[$flag];
    }

    /**
     * Get model table name
     * @return string
     */
    protected function _getTableName()
    {
        return 'tasks';
    }

    protected function getValidationRules()
    {
        return [
            'user_name' => ['required'],
            'email' => ['required', 'email', 'unique'],
            'text' => ['required'],
        ];
    }
}