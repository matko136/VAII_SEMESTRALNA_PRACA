<div class="container">
<?php /** @var \App\Models\User[] $data */
foreach ($data as $user) { ?>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">
                <?= $user->getName() ?>
                <!-- <a href="?c=blog&a=edit&id=<?= $user->getIdUser() ?>">Edit</a> &nbsp;&nbsp;&nbsp;
                <a href="?c=blog&a=delete&id=<?= $user->getIdUser() ?>">Zmazat</a>-->
            </h1>
            <p class="lead"><?= $user->getLog() ?></p>
        </div>
    </div>
<?php } ?>
</div>