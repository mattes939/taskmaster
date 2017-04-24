<div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
        <legend><?php echo 'Obnova hesla'; ?></legend>
        <?php
        echo $this->Form->create('User');
        $this->Form->inputDefaults(array(
            'label' => false,
            'div' => ['class' => 'form-group'],
            'class' => 'form-control'
                )
        );
        echo $this->Form->input('username', array('autofocus' => 'autofocus', 'placeholder' => 'email', 'type' => 'email', 'required'));
        echo $this->Form->button('Obnovit heslo', array('class' => 'btn btn-primary'));
        echo $this->Html->link('Zpět na přihlášení', ['controller' => 'users', 'action' => 'login'], ['class' => 'btn btn-warning pull-right']);

        echo $this->Form->end();
        ?>
    </div>
</div>
