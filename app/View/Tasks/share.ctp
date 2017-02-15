<?php 
$label = 'Pozvat nové uživatele<br><small>vložte platné emailové adresy oddělené čárkou</small>'
?>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 col-md-offset-1">
        <h1><?php echo $this->request->data['Task']['name'];?></h1>
        <?php
        echo $this->Form->create('Task');
//        echo $this->Form->input('name', ['disabled',
//            'label' => false,
//            'div' => ['class' => 'form-group'],
//            'class' => 'form-control']
//        );
        echo $this->Form->input('emails', ['type' => 'textarea', 'label' => $label, 'class' => 'form-control', 'div' => ['class' => 'form-group']]);
        echo $this->Form->button('<span class="glyphicon glyphicon glyphicon-share-alt" aria-hidden="true"></span>&nbsp;Sdílet', array('class' => 'btn btn-primary', 'label' => 'login',));
        echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>&nbsp;Zpět', ['controller' => 'tasks', 'action' => 'view', $this->request->data['Task']['id']], ['class' => 'btn btn-warning pull-right', 'escape' => false]);
        echo $this->Form->end();
        ?>
    </div>
</div>