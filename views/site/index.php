<?php
/* @var array $tasks */
/* @var \models\Task $model */
/* @var bool $isAdmin */
/* @var string $sort */
/* @var string $flash */
$userNameErrors = $model->getErrorsByField('user_name');
$emailErrors = $model->getErrorsByField('email');
$textErrors = $model->getErrorsByField('text');
$hasErrors = !empty($userNameErrors) || !empty($emailErrors) || !empty($textErrors);

/* @var int $page */
/* @var int $pageSize */
$count = $model->getCount();
$pagesCount = ceil($count/$pageSize);
?><div style="height:50px;"></div>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <a class="btn btn-primary" href="<?= $isAdmin ? '?action=logout' : '?action=login' ?>" role="button"><?= $isAdmin ? 'Logout' : 'Login' ?></a>
    </div>
    <div class="col-md-1"></div>
</div><?php
$linkPagePart = $page > 1 ? 'page=' . $page : '';
$linkSortPart = $sort === null ? '' : 'sort=' . $sort;
$nameSortLink = http_build_query(
    [
        'page' => $page > 1 ? $page : null,
        'sort' => $sort == 'user_name ASC' ? 'user_name DESC' : 'user_name ASC',
    ]
);
$emailSortLink = http_build_query(
    [
        'page' => $page > 1 ? $page : null,
        'sort' => $sort == 'email ASC' ? 'email DESC' : 'email ASC',
    ]
);
$statusSortLink = http_build_query(
    [
        'page' => $page > 1 ? $page : null,
        'sort' => $sort == 'flag ASC' ? 'flag DESC' : 'flag ASC',
    ]
);
?><div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10"><?php
        if (!empty($flash)) {
            ?><div class="alert alert-success" role="alert"><?= $flash ?></div><?php
        }
        ?><table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th><a href="?<?= $nameSortLink ?>">User Name</a></th>
                <th><a href="?<?= $emailSortLink ?>">Email</a></th>
                <th>Text</th>
                <th><a href="?<?= $statusSortLink ?>">Status</a></th><?php
                if ($isAdmin) {
                ?><th>Action</th><?php
                }
            ?></tr>
            </thead>
            <tbody><?php
            foreach ($model->getAll($page, $sort) as $task) {
                ?><tr>
                    <th scope="row"><?= $task['id'] ?></th>
                    <td><?= $task['user_name'] ?></td>
                    <td><?= $task['email'] ?></td>
                    <td><?= $task['text'] ?></td>
                    <td><?php
                        $flagTitle = $model->getFlagTitle((int) $task['flag']);
                        if ((int) $task['flag'] === \models\Task::FLAG_TODO) {
                            $class = 'label-warning';
                        } elseif ((int) $task['flag'] === \models\Task::FLAG_DONE) {
                            $class = 'label-success';
                        }
                        ?><span class="label <?= $class ?>"><?= $flagTitle ?></span><?php
                        if ((int) $task['updated_at'] > (int) $task['created_at']) {
                            ?><span class="label label-danger">Edited by admin</span><?php
                        }
                    ?></td><?php
                    if ($isAdmin) {
                    ?><td>
                        <a href="?action=edit&id=<?= $task['id'] ?>">Edit</a>
                    </td><?php
                    }
                ?></tr><?php
            }
            ?></tbody>
        </table>

        <?php
        $i = 1;
        ?><nav aria-label="Page navigation">
            <ul class="pagination"><?php
                if ($page !== 1) {
                ?><li>
                    <a href="<?= empty($linkSortPart) ? '/' : '?' . $linkSortPart ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li><?php
                }
                while ($i <= $pagesCount) {
                    if ($i === $page) {
                        ?><li><span><?= $i ?></span></li><?php
                    } else {
                        $link = http_build_query(
                            [
                                'page' => $i > 1 ? $i : null,
                                'sort' => $sort,
                            ]
                        );
                        ?><li><a href="<?= empty($link) ? '/' : '?' . $link ?>"><?= $i ?></a></li><?php
                    }
                    $i++;
                }
                ?><?php
                if ($page < $pagesCount) {
                ?><li>
                    <a href="?page=<?= $pagesCount . (!empty($linkSortPart) ? '&' . $linkSortPart : '') ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li><?php
                }
            ?></ul>
        </nav>

        <div style="height:20px;"></div>
        <a class="btn btn-danger" href="#" role="button" onclick="showAddTaskForm()">Add task</a>
        <div class="row" id="tasks-form" style="<?= $hasErrors ? '' : 'display: none;' ?>">
            <div class="col-md-6">
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
                    <button type="submit" class="btn btn-default">Create</button>
                </form>
            </div>
            <div class="col-md-6"></div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>

<script type="application/javascript">
    function showAddTaskForm() {
        if ($('#tasks-form').is(":visible")) {
            $('#tasks-form').hide();
        } else {
            $('#tasks-form').show();
        }
    }
</script>