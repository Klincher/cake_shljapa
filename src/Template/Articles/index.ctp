<h1>Статьи блога</h1>
<?= $this->Html->link('Добавить статью', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Заголовок</th>
        <th>Дата создания</th>
        <th>Action</th>
    </tr>

    <!-- Здесь мы проходимся в цикле по объекту запроса $articles, выводя данные статьи -->

    <?php foreach ($articles as $article) : ?>
        <tr>
            <td><?= $article->id ?></td>
            <td>
                <?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?>
            </td>
            <td>
                <?= $article->created->format(DATE_RFC850) ?>
            </td>
            <td>
                <?= $this->Form->postLink(
                    'Удалить',
                    ['action' => 'delete', $article->id],
                    ['confirm' => 'Вы уверены?']
                )
                ?>
                <?= $this->Html->link('Изменить', ['action' => 'edit', $article->id]) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="d-flex justify-content-end">
    <button class="btn btn-primary">Test btn</button>
</div>

<table class="table">
        <tr>
            <th scope="col">id</th>
            <th scope="col">title</th>
            <th scope="col">body</th>
            <th scope="col">created</th>
        </tr>
    <?php foreach ($articles as $article) : ?>
        <tr>
            <td><?= $article->id ?></td>
            <td><?= $article->title ?></td>
            <td><?= $article->body ?></td>
            <td><?= $article->created ?></td>
        </tr>
    <?php endforeach; ?>
</table>