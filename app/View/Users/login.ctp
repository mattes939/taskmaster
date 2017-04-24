<div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
<!--<legend><?php echo 'Přihlášení'; ?></legend>-->
        <?php echo $this->Form->create('User', array('url' => 'login')); ?>
        <?php echo $this->Form->input('username', array('class' => 'form-control', 'autofocus' => 'autofocus', 'label' => false, 'placeholder' => 'email', 'type' => 'email')); ?>
        <br />
        <?php echo $this->Form->input('password', array('class' => 'form-control', 'label' => false, 'placeholder' => 'heslo')); ?>
        <br />
        <?php echo $this->Form->button('Přihlásit se', array('class' => 'btn btn-primary', 'label' => 'login'));
        echo $this->Html->link('Registrovat', ['controller' => 'users', 'action' => 'add'], ['class' => 'btn btn-success pull-right']);
        ?>
        
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
        <br>
        <?php echo $this->Html->link('Obnovit heslo', ['controller' => 'users', 'action' => 'resetPassword'], ['class' => 'btn btn-default pull-right']);?>
    </div>
</div>