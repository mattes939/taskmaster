<div class="processings view">
<h2><?php echo __('Processing'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($processing['Processing']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($processing['Processing']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Processing'), array('action' => 'edit', $processing['Processing']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Processing'), array('action' => 'delete', $processing['Processing']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $processing['Processing']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Processings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Processing'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Values'), array('controller' => 'values', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Value'), array('controller' => 'values', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Types'), array('controller' => 'types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Type'), array('controller' => 'types', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Values'); ?></h3>
	<?php if (!empty($processing['Value'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Task Id'); ?></th>
		<th><?php echo __('Property Id'); ?></th>
		<th><?php echo __('Processing Id'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($processing['Value'] as $value): ?>
		<tr>
			<td><?php echo $value['id']; ?></td>
			<td><?php echo $value['task_id']; ?></td>
			<td><?php echo $value['property_id']; ?></td>
			<td><?php echo $value['processing_id']; ?></td>
			<td><?php echo $value['value']; ?></td>
			<td><?php echo $value['created']; ?></td>
			<td><?php echo $value['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'values', 'action' => 'view', $value['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'values', 'action' => 'edit', $value['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'values', 'action' => 'delete', $value['id']), array('confirm' => __('Are you sure you want to delete # %s?', $value['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Value'), array('controller' => 'values', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Types'); ?></h3>
	<?php if (!empty($processing['Type'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($processing['Type'] as $type): ?>
		<tr>
			<td><?php echo $type['id']; ?></td>
			<td><?php echo $type['name']; ?></td>
			<td><?php echo $type['created']; ?></td>
			<td><?php echo $type['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'types', 'action' => 'view', $type['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'types', 'action' => 'edit', $type['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'types', 'action' => 'delete', $type['id']), array('confirm' => __('Are you sure you want to delete # %s?', $type['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Type'), array('controller' => 'types', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
