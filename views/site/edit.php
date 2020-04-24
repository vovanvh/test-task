<?php
/* @var \models\Task $model */
/* @var bool $isAdmin */

$userNameErrors = $model->getErrorsByField('user_name');
$emailErrors = $model->getErrorsByField('email');
$textErrors = $model->getErrorsByField('text');
$hasErrors = !empty($userNameErrors) || !empty($emailErrors) || !empty($textErrors);
?><div style="height:150px;"></div>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form name="submit-task" method="post">
            <div class="form-group <?= $userNameErrors ? 'has-error' : '' ?>">
                <label for="user_name">User Name</label>
                <input value="<?= $model->getName() ?>" type="text" class="form-control" name="user_name" id="user_name" placeholder="User Name" data-required="1"><?php
                foreach ($userNameErrors as $error) {
                    ?><span id="helpBlock2" class="help-block"><?= $error ?></span><?php
                }
            ?></div>
            <div class="form-group <?= $emailErrors ? 'has-error' : '' ?>">
                <label for="email">Email</label>
                <input value="<?= $model->getEmail() ?>" type="text" class="form-control" name="email" id="email" placeholder="Email" data-required="1"><?php
                foreach ($emailErrors as $error) {
                    ?><span id="helpBlock2" class="help-block"><?= $error ?></span><?php
                }
            ?></div>
            <div class="form-group <?= $textErrors ? 'has-error' : '' ?>">
                <label for="task-text">Text</label>
                <textarea name="text" class="form-control" rows="5"><?= htmlspecialchars_decode($model->getText()) ?></textarea><?php
                foreach ($textErrors as $error) {
                    ?><span id="helpBlock2" class="help-block"><?= $error ?></span><?php
                }
            ?></div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="flag" <?= $model->getFlag() === \models\Task::FLAG_DONE ? 'checked' : '' ?> value="<?= \models\Task::FLAG_DONE ?>"> Done
                </label>
            </div>
            <button type="submit" class="btn btn-default">Update</button>
            <a class="btn btn-success" href="/" role="button">Home</a>
        </form>
    </div>
    <div class="col-md-1"></div>
</div>
