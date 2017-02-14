<div class="values form">
<?php echo $this->Form->create('Value'); ?>
	<fieldset>
		<legend><?php echo __('Edit Value'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('task_id');
		echo $this->Form->input('property_id');
		echo $this->Form->input('value');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Value.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Value.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Values'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Tasks'), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Task'), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Properties'), array('controller' => 'properties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property'), array('controller' => 'properties', 'action' => 'add')); ?> </li>
	</ul>
</div>
