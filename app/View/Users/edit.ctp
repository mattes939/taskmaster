<div class="row">
    <div class="col-sm-6 col-sm-offset-2 col-md-4">
        <?php
        echo $this->Form->create('User', ['class' => ['form-horizontal']]);
        ?>
            <legend><?php echo __('Nastavení účtu'); ?></legend>
            <?php
            $this->Form->inputDefaults(array(
                'label' => false,
                'div' => ['class' => 'form-group'],
                'class' => 'form-control'
                    )
            );
            echo $this->Form->input('id');
            echo $this->Form->input('username', ['label' => ['class' => 'col-sm-2 control-label', 'text' => 'email'], 'disabled']);
            echo $this->Form->input('first_name', ['label' => ['class' => 'col-sm-2 control-label', 'text' => 'jméno']]);
            echo $this->Form->input('last_name', ['label' => ['class' => 'col-sm-2 control-label', 'text' => 'příjmení']]);
            echo $this->Form->input('telephone', ['label' => ['class' => 'col-sm-2 control-label', 'text' => 'telefon'], 'type' => 'text']);
            ?>
        <?php
        echo $this->Form->button('<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Uložit změny', array('class' => 'btn btn-primary'));
        echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>&nbsp;Zrušit', ['controller' => 'tasks', 'action' => 'index'], ['class' => 'btn btn-warning pull-right', 'escape' => false]);

        echo $this->Form->end();
        ?>

    </div>   
</div>
<div class="row">
    <div class="col-sm-6 col-sm-offset-2 col-md-4">
        <br>
        <?php
        echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-wrench" aria-hidden="true"></span>&nbsp;Změnit heslo', ['controller' => 'users', 'action' => 'changePassword'], ['class' => 'btn btn-success', 'escape' => false]);
        ?>
    </div>
</div>