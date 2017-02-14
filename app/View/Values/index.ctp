<div class="values index">
	<h2><?php echo __('Values'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('task_id'); ?></th>
			<th><?php echo $this->Paginator->sort('property_id'); ?></th>
			<th><?php echo $this->Paginator->sort('value'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($values as $value): ?>
	<tr>
		<td><?php echo h($value['Value']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($value['Task']['name'], array('controller' => 'tasks', 'action' => 'view', $value['Task']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($value['Property']['name'], array('controller' => 'properties', 'action' => 'view', $value['Property']['id'])); ?>
		</td>
		<td><?php echo h($value['Value']['value']); ?>&nbsp;</td>
		<td><?php echo h($value['Value']['created']); ?>&nbsp;</td>
		<td><?php echo h($value['Value']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $value['Value']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $value['Value']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $value['Value']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $value['Value']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Value'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Tasks'), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Task'), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Properties'), array('controller' => 'properties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property'), array('controller' => 'properties', 'action' => 'add')); ?> </li>
	</ul>
</div>
