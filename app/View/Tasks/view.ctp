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
        <?php
        printf('<p>Vytvořil: %s %s (%s)</p>', $task['Author']['first_name'], $task['Author']['last_name'], $task['Author']['username']);
        echo $this->Html->link(
                '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Nový podúkol', array('controller' => 'tasks', 'action' => 'add', $task['Task']['id']), ['class' => 'btn btn-success', 'escape' => false]
        );
        echo $this->Html->link(
                '<span class="glyphicon glyphicon glyphicon-share-alt" aria-hidden="true"></span>&nbsp;Sdílet', ['controller' => 'tasks', 'action' => 'share', $task['Task']['id']], ['class' => 'btn btn-primary', 'escape' => false]
        );
        if ($canDetach) {
            echo $this->Form->postLink(
                    '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;Přestat sledovat', array('action' => 'detachUser', $task['Task']['id']), array(
                'confirm' => __('Opravdu chcete zrušit Vaše přiřazení k úkolu "%s" a všem nadřazeným a  podřazeným úkolům?', $task['Task']['name']),
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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($task['Value'] as $value): ?>
                        <tr>
                            <td><?php echo $value['Property']['name']; ?></td>
                            <td><?php echo $value['value']; ?></td>   
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php
        }
        else {
            echo '<br><br>';
        }
        echo $this->Html->link(
                '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Nový atribut', ['controller' => 'values', 'action' => 'add', $task['Task']['id']], ['class' => 'btn btn-success', 'escape' => false]
        );
        if (!empty($task['Value'])) {
            echo $this->Html->link(
                    '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;Upravit atributy', ['controller' => 'tasks', 'action' => 'edit', $task['Task']['id']], ['class' => 'btn btn-primary', 'escape' => false]
            );
        }
        ?> 

        <h3><?php echo __('Připojení uživatelé'); ?></h3>
        <?php if (!empty($task['User'])): ?>
            <table class="table table-bordered table-condensed table-responsive">
                <thead>
                    <tr>
                        <th>eEmail</th>
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
    </main>
</div>

