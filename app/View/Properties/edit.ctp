<div class="properties form">
<?php echo $this->Form->create('Property'); ?>
	<fieldset>
		<legend><?php echo __('Edit Property'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('type_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Property.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Property.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Properties'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Types'), array('controller' => 'types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Type'), array('controller' => 'types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Values'), array('controller' => 'values', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Value'), array('controller' => 'values', 'action' => 'add')); ?> </li>
	</ul>
</div>
