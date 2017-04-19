<div class="row">
    <aside class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
        <?php
        echo $this->Tree->generate($tree, [
            'class' => 'tree viewTask',
            'element' => 'task_node',
            'autoPath' => array($task['Task']['lft'], $task['Task']['rght'])
        ]);
        ?>
    </aside>
    <main class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
        <h1><?php echo h($task['Task']['name']); ?></h1>
        <p>Nadřazený úkol: 
            <?php
            if (!empty($task['ParentTask']['name'])) {
                echo '<strong style="padding-right: 15px;">' . $this->Html->link($task['ParentTask']['name'], ['controller' => 'tasks', 'action' => 'view', $task['ParentTask']['id']]) . '</strong>';
                echo $this->Html->link('<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>&nbsp;změnit', ['controller' => 'tasks', 'action' => 'changeParent', $task['Task']['id']], ['class' => 'btn btn-primary btn-xs', 'escape' => false,]);
            } else {
                echo '<i>(žádný)</i>';
            }
            ?></p>
        <?php
        printf('<p>Vytvořil: %s %s (%s)</p>', $task['Author']['first_name'], $task['Author']['last_name'], $task['Author']['username']);
        $descButton = 'Vložit popis';
        if (!empty($task['Task']['description'])) {
            echo '<p>' . $task['Task']['description'] . '</p>';
            $descButton = 'Upravit popis';
        }
        echo $this->Html->link(
                '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;' . $descButton, ['controller' => 'tasks', 'action' => 'edit', $task['Task']['id']], ['class' => 'btn btn-default', 'escape' => false]
        );
        echo $this->Html->link(
                '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Nový atribut', ['controller' => 'values', 'action' => 'add', $task['Task']['id']], ['class' => 'btn btn-success', 'escape' => false]
        );
        echo $this->Html->link(
                '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Nový podúkol', array('controller' => 'tasks', 'action' => 'add', $task['Task']['id']), ['class' => 'btn btn-success', 'escape' => false]
        );
        echo $this->Html->link(
                '<span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span>&nbsp;Sdílet', ['controller' => 'tasks', 'action' => 'share', $task['Task']['id']], ['class' => 'btn btn-primary', 'escape' => false]
        );
        if ($canDetach) {
            echo $this->Form->postLink(
                    '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;Přestat sledovat', array('action' => 'detachUser', $task['Task']['id']), array(
                'confirm' => __('Opravdu chcete zrušit Vaše přiřazení k úkolu "%s" a všem nadřazeným a podřazeným úkolům?', $task['Task']['name']),
                'class' => 'btn btn-warning', 'escape' => false
                    )
            );
        }


        if ($this->Session->read('Auth.User.id') == $task['Task']['author_id'] || count($task['User']) <= 1) {
            echo $this->Form->postLink(
                    '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;Odstranit', array('action' => 'delete', $task['Task']['id']), array(
                'confirm' => __('Opravdu chcete smazat úkol "%s" a všechny podúkoly?', $task['Task']['name']),
                'class' => 'btn btn-danger', 'escape' => false
                    )
            );
        }
        if (!empty($task['Value'])) {
            ?>
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Atribut</th>
                        <th>Hodnota</th>
                        <th>Druh zadání</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($task['Value'] as $value) {
                        $shownName = $value['Property']['name'];
                        $shownValue = $value['value'];
//                        debug($value['value']);
                        switch ($value['Property']['type_id']) {
                            case 3:
                                $shownValue = str_replace(['0', '1'], ['<span class="glyphicon glyphicon-remove text-danger"></span>', '<span class="glyphicon glyphicon-ok text-success"></span>'], $shownValue);
                                break;
                            case 4:
                                $shownValue = $this->Time->format($value['value'], '%e. %-m. %Y');
                                break;
                            case 5:
                                $shownName = unserialize($value['Property']['name'])['name'];
                                break;
                        }
                        ?>
                        <tr>
                            <td><?php echo $shownName; ?></td>
                            <td><?php echo $shownValue; ?></td>
                            <td><?php echo $value['Processing']['name']; ?></td>
                            <td class="text-right">
                                <?php
                                echo $this->Html->link('<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>', array('controller' => 'values', 'action' => 'edit', $value['id']), ['class' => 'btn btn-primary', 'escape' => false]);
                                echo $this->Form->postLink('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', array('controller' => 'properties', 'action' => 'delete', $value['Property']['id']), array('confirm' => __('Opravdu chcete odstranit atribut "%s"? Atribut bude odstraněn ze všech nadřazených a podřazených úkolů.', $shownName), 'escape' => false, 'class' => 'btn btn-danger'));
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php
        } else {
            echo '<br><br>';
        }

//        echo $this->Html->link(
//                '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Nový text', ['controller' => 'values', 'action' => 'add', $task['Task']['id'], 1], ['class' => 'btn btn-success', 'escape' => false]
//        );
//        echo $this->Html->link(
//                '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Nové číslo', ['controller' => 'values', 'action' => 'add', $task['Task']['id'], 2], ['class' => 'btn btn-success', 'escape' => false]
//        );
//        echo $this->Html->link(
//                '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Nový boolean', ['controller' => 'values', 'action' => 'add', $task['Task']['id'], 3], ['class' => 'btn btn-success', 'escape' => false]
//        );
//        echo $this->Html->link(
//                '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Nové datum', ['controller' => 'values', 'action' => 'add', $task['Task']['id'], 4], ['class' => 'btn btn-success', 'escape' => false]
//        );
//        if (!empty($task['Value'])) {
//            echo $this->Html->link(
//                    '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;Upravit atributy', ['controller' => 'tasks', 'action' => 'edit', $task['Task']['id']], ['class' => 'btn btn-primary', 'escape' => false]
//            );
//        }
        ?> 

        <h3><?php echo __('Připojení uživatelé'); ?></h3>
        <?php if (!empty($task['User'])): ?>
            <table class="table table-bordered table-condensed table-responsive">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Jméno</th>
                        <th>Příjmení</th>
                        <th>Telefon</th>                    
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($task['User'] as $user): ?>
                        <tr>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['first_name']; ?></td>
                            <td><?php echo $user['last_name']; ?></td>
                            <td><?php echo $user['telephone']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <h3>Komentáře</h3>
        <?php
        if (!empty($task['Comment'])) {
            foreach ($task['Comment'] as $comment) {
                ?>
                <div class="well well-sm bg-info">
                    <?php
                    $editButton = '';
                    if ($comment['User']['id'] == $this->Session->read('Auth.User.id')) {
                        $editButton = $this->Html->link(
                                '&nbsp;<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>', ['controller' => 'comments', 'action' => 'edit', $comment['id']], ['class' => 'btn btn-default pull-right', 'escape' => false]
                        );
                    }
                    echo '<h4>' . $comment['User']['first_name'] . ' ' . $comment['User']['last_name'] . ' (' . $this->Time->format($comment['modified'], '%e. %-m. %Y %k:%M') . ')' . $editButton . '</h4>';
                    echo '<p>' . $comment['content'] . '</p>';
                    ?></div><?php
            }
        } else {
            echo '<i>K tomuto úkolu nebyly zatím vloženy žádné komentáře.</i>';
        }
        echo $this->Form->create('Comment');
        $this->Form->inputDefaults(array(
            'div' => ['class' => 'form-group'],
            'class' => 'form-control'
                )
        );
        echo $this->Form->input('content', ['label' => 'Napsat komentář']);
        echo $this->Form->button('<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Vložit komentář', array('class' => 'btn btn-primary'));
        echo $this->Form->end();
        ?>
        <br>
    </main>
</div>

