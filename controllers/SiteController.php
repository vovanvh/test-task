<?php

namespace controllers;

use base\Controller;
use helpers\DateTime;
use models\LoginForm;
use models\Task;

/**
 * Class SiteController
 * @package controllers
 */
class SiteController extends Controller
{

    use DateTime;

    /**
     * Default action
     */
    public function actionIndex()
    {
        $model = new Task();
        if ($this->getIsPostRequest()) {
            $model->setValues(
                [
                    'user_name' => $this->getPostParam('user_name'),
                    'email' => $this->getPostParam('email'),
                    'text' => $this->getPostParam('text'),
                    'flag' => $this->getPostParam('flag', 0),
                ]
            );
            if ($model->create()) {
                $this->setFlash('Created successfully');
                header("Location: /");
                exit();
            }
        }
        $this->_render(
            'index',
            [
                'model' => $model,
                'isAdmin' => $this->getIsAdmin(),
                'sort' => $this->getParam('sort'),
                'page' => (int) $this->getParam('page', 1),
                'pageSize' => 3,
                'flash' => $this->getFlash(),
            ]
        );
    }

    public function actionEdit()
    {
        if (!$this->getIsAdmin()) {
            header("Location: ?action=login");
            exit();
        }
        $id = (int) $this->getParam('id');
        if (!$id) {
            header("Location: /");
            exit();
        }
        $model = new Task();
        $task = $model->getById($id);
        $model->setValues($task);

        if ($this->getIsPostRequest()) {
            $newText = $this->getPostParam('text');
            $model->setValues(
                [
                    'user_name' => $this->getPostParam('user_name'),
                    'email' => $this->getPostParam('email'),
                    'text' => $newText,
                    'flag' => $this->getPostParam('flag', 0),
                    'updated_at' => strcmp($task['text'], $newText) !== 0 ? $this->getCurrentTimestamp() : $task['created_at']
                ]
            );
            if ($model->update()) {
                $this->setFlash('Updated successfully');
                header("Location: /");
                exit();
            }
        }

        $this->_render(
            'edit',
            [
                'model' => $model,
            ]
        );
    }

    public function actionLogin()
    {
        if ($this->getIsAdmin()) {
            header("Location: /");
            exit();
        }
        $model = new LoginForm();
        if ($this->getIsPostRequest()) {
            $isValid = $model->setValues(
                [
                    'user_name' => $this->getPostParam('user_name'),
                    'password' => $this->getPostParam('password'),
                ]
            )->validate();
            if ($isValid) {
                $_SESSION['admin'] = true;
                header("Location: /");
                exit();
            }
        }
        $this->_render(
            'login',
            [
                'model' => $model,
            ]
        );
    }

    public function actionLogout()
    {
        session_unset();
        header("Location: /");
        exit();
    }
}