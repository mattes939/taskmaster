<div class="row">
    <div class="col-xs-12 ">
        <h1>[<?php echo $this->request->data['Task']['name'] . '] - změna mateřského úkolu'; ?></h1>

    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-8 col-md-offset-1"><?php
        echo $this->Form->create('Task');
        $this->Form->inputDefaults(array(
            'div' => ['class' => 'form-group'],
            'class' => 'form-control'
                )
        );
        echo $this->Form->input('id');
        echo $this->Form->input('parent_id', ['label' => 'Nadřazený úkol']);
        echo $this->Form->button('<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Uložit', array('class' => 'btn btn-primary', 'label' => 'login',));
        echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>&nbsp;Zpět', ['controller' => 'tasks', 'action' => 'view', $this->request->data['Task']['id']], ['class' => 'btn btn-warning ', 'escape' => false]);
        echo $this->Form->end();
        ?> </div>
</div>