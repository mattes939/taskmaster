<h2><?php echo 'přihlášení do administrace'; ?></h2>


<div class="row">
    <div class="col-sm-3">

        <?php echo $this->Form->create('User', array('url' => 'login')); ?>
        <?php echo $this->Form->input('username', array('class' => 'form-control', 'autofocus' => 'autofocus', 'label' => 'login')); ?>
        <br />
        <?php echo $this->Form->input('password', array('class' => 'form-control', 'label' => 'heslo')); ?>
        <br />
        <?php echo $this->Form->button('Login', array('class' => 'btn btn-primary', 'label' => 'login')); ?>
        <?php echo $this->Form->end(); ?>
        <br />
        <br />
        <br />

    </div>
</div>