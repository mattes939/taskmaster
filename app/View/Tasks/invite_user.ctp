<?php echo $this->Form->create('Task'); ?>
	<fieldset>
		<legend><?php echo __('Edit Task'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('User', ['multiple' => 'checkbox', 'label' => 'Uživatelé spojení s Vašimi úkoly']);
                echo $this->Form->input('emails', ['type' => 'textarea', 'label' => 'Pozvat nové uživatele']);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
