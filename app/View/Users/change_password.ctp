<div class="row">
    <div class="col-sm-10 col-sm-offset-1 col-md-8">
        <?php
        echo $this->Form->create('User', ['class' => 'form-horizontal']);
        ?>
        <legend><span class="col-sm-offset-4"><?php echo __('Změna hesla'); ?></span></legend>
        <?php
        $this->Form->inputDefaults(array(
            'label' => false,
            'div' => ['class' => 'form-group'],
            'class' => 'form-control'
                )
        );
        echo $this->Form->input('id');

        echo $this->Form->input('pwd', array('type' => 'password', 'value' => '', 'autocomplete' => 'off', 'label' => ['class' => 'col-sm-4 control-label', 'text' => 'Nové heslo']));

        echo $this->Form->input('pwd_repeat', array('type' => 'password', 'value' => '', 'autocomplete' => 'off', 'label' => ['class' => 'col-sm-4 control-label', 'text' => 'Nové heslo pro kontrolu']));
        ?>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">                 
                <?php
                echo $this->Form->button('<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp;Uložit heslo', array('class' => 'btn btn-primary'));
                echo $this->Html->link('<span class="glyphicon glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>&nbsp;Zrušit', ['controller' => 'tasks', 'action' => 'index'], ['class' => 'btn btn-warning pull-right', 'escape' => false]);

                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>