<div class="row">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 col-md-offset-1">
        <h1><?php echo '[' . $task['Task']['name'] . '] nový atribut'; ?></h1>
        <?php
        echo $this->Form->create('Value', ['class' => 'form-horizontal']);
        $this->Form->inputDefaults(array(
            'div' => ['class' => 'form-group'],
            'class' => 'form-control'
                )
        );
        echo $this->Form->input('Property.name', ['label' => ['class' => 'col-sm-2 control-label', 'text' => 'název']]);
        echo $this->Form->input('value', ['label' => ['class' => 'col-sm-2 control-label', 'text' => 'hodnota']]);
        ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php
                echo $this->Form->button('<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Sdílet', array('class' => 'btn btn-primary', 'label' => 'login',));
                echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>&nbsp;Zpět', ['controller' => 'tasks', 'action' => 'view', $task['Task']['id']], ['class' => 'btn btn-warning pull-right', 'escape' => false]);
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
