<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username', ['type' => 'email', 'label' => 'Email']);
		echo $this->Form->input('pwd', ['type' => 'password']);
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('telephone');		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));