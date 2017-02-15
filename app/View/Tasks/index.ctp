<div class="row">
    <main class="col-xs-12 col-md-12 col-lg-12">
        <h1>Moje úkoly&nbsp;
        <?php echo $this->Html->link('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Nový úkol', ['controller' => 'tasks', 'action' => 'add'], ['escape' => false, 'class' => 'btn btn-success']); ?>
        </h1>
                    <?php
        if (!empty($tasks)) {
            echo $this->Tree->generate($tasks, [
                'element' => 'tasklist_node',
                'class' => 'tree tasklist list-group',
            ]);
        } else{
            echo 'Momentálně nemáte žádné úkoly. ';
            echo $this->Html->link('Vytvořit nový', ['controller' => 'tasks', 'action' => 'add']);
        }
        ?>   
    </main>
</div>

