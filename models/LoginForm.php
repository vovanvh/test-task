<?php

namespace models;

use db\BaseModel;

/**
 * Class Comment
 * Comment model
 *
 * @package models
 */
class LoginForm extends BaseModel
{

    public function getName()
    {
        return $this->_values['user_name'] ?? '';
    }

    protected function getValidationRules()
    {
        return [
            'user_name' => ['required', 'isAdmin'],
            'password' => ['required', 'isAdminPassword'],
        ];
    }

    protected function validateIsAdmin($field, $value)
    {
        if ($value != 'admin' && empty($this->_errors[$field])) {
            $this->_errors[$field][] = "Wrong admin name";
        }
    }

    protected function validateIsAdminPassword($field, $value)
    {
        if ($value != '123' && empty($this->_errors[$field])) {
            $this->_errors[$field][] = "Wrong admin password";
        }
    }
}