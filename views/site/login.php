<?php
/* @var $model \models\LoginForm */
$userNameErrors = $model->getErrorsByField('user_name');
$passwordErrors = $model->getErrorsByField('password');
?><div style="height:150px;"></div>
<div class="row" id="tasks-form">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <form name="submit-task" method="post" action="">
            <div class="form-group <?= $userNameErrors ? 'has-error' : '' ?>">
                <label for="user_name">User Name</label>
                <input type="text" class="form-control" name="user_name" id="user_name" placeholder="User Name" data-required="1" value="<?= $model->getName() ?>"><?php
                foreach ($userNameErrors as $error) {
                    ?><span id="helpBlock2" class="help-block"><?= $error ?></span><?php
                }
            ?></div>
            <div class="form-group <?= $passwordErrors ? 'has-error' : '' ?>">
                <label for="email">Password</label>
                <input type="password" class="form-control" name="password" id="email" placeholder="password" data-required="1"><?php
                foreach ($passwordErrors as $error) {
                    ?><span id="helpBlock2" class="help-block"><?= $error ?></span><?php
                }
            ?></div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a class="btn btn-success" href="/" role="button">Home</a>
        </form>
    </div>
    <div class="col-md-3"></div>
</div>