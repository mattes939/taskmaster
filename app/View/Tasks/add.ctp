<?php 
$headline = 'Nový úkol';
$backLink = ['controller' => 'tasks', 'action' => 'index'];
if(!empty($parentTask)){
    $headline = '['. $parentTask['Task']['name'] . '] nový podúkol';
    $backLink['action'] = 'view';
    $backLink[] = $parentTask['Task']['id'];
}

?>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 col-md-offset-1">
        <h1><?php echo $headline; ?></h1>
        <?php
        echo $this->Form->create('Task');
        echo $this->Form->input('name', ['placeholder' => 'název úkolu',
            'label' => false,
            'div' => ['class' => 'form-group'],
            'class' => 'form-control']
        );

        echo $this->Form->button('<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Vytvořit úkol', array('class' => 'btn btn-primary', 'label' => 'login',));
        echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>&nbsp;Zpět', $backLink, ['class' => 'btn btn-warning pull-right', 'escape' => false]);
        echo $this->Form->end();
        ?>
    </div>
</div>
