<li class="list-group-item">
    <div class="row">
        <div class="col-xs-2 col-md-1 col-lg-1 text-right"><?php echo $this->Time->format($data['Task']['created'], '%e. %-m.') ;?></div>
        <div class="col-xs-6 col-sm-7 col-md-5 col-lg-6">
            <?php
            
            echo $this->Html->link($data['Task']['name'], ['controller' => 'tasks', 'action' => 'view', $data['Task']['id']], ['class' => '']);
            ?>
        </div>
        <div class="col-xs-4 col-sm-3 col-md-6 col-lg-4 text-right pull-right">
            <?php
            echo $this->Html->link(
                    '<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span><span class="hidden-xs hidden-sm">&nbsp;otevřit</span>', ['controller' => 'tasks', 'action' => 'view', $data['Task']['id']], ['class' => 'btn btn-info btn-xs', 'escape' => false]
            );
            if (count($data['User']) > 1) {
                echo $this->Form->postLink(
                        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span><span class="hidden-xs hidden-sm">&nbsp;přestat sledovat</span>', array('action' => 'detachUser', $data['Task']['id']), array(
                    'confirm' => __('Opravdu chcete zrušit Vaše přiřazení k úkolu "%s" a všem podúkolům?', $data['Task']['name']),
                    'class' => 'btn btn-warning btn-xs', 'escape' => false
                        )
                );
            } else {
                echo $this->Html->link(
                        '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span><span class="hidden-xs hidden-sm">&nbsp;přestat sledovat</span>', ['#'], ['class' => 'btn btn-warning btn-xs disabled', 'escape' => false, 'title' => 'Nemáte oprávnění ke smazání tohoto úkolu.']
                );
            }

            if ($this->Session->read('Auth.User.id') == $data['Task']['author_id']) {
                echo $this->Form->postLink(
                        '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span><span class="hidden-xs hidden-sm">&nbsp;odstranit</span>', array('action' => 'delete', $data['Task']['id']), array(
                    'confirm' => __('Opravdu chcete smazat úkol "%s" a všechny podúkoly?', $data['Task']['name']),
                    'class' => 'btn btn-danger btn-xs', 'escape' => false
                        )
                );
            } else {
                echo $this->Html->link(
                        '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span><span class="hidden-xs hidden-sm">&nbsp;odstranit</span>', ['#'], ['class' => 'btn btn-danger btn-xs disabled', 'escape' => false, 'title' => 'Nemáte oprávnění ke smazání tohoto úkolu.']
                );
            }
            ?>
        </div>
    </div>
</li>