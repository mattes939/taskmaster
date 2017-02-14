<div class="types view">
<h2><?php echo __('Type'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($type['Type']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($type['Type']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($type['Type']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($type['Type']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Type'), array('action' => 'edit', $type['Type']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Type'), array('action' => 'delete', $type['Type']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $type['Type']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Types'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Type'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Properties'), array('controller' => 'properties', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property'), array('controller' => 'properties', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Properties'); ?></h3>
	<?php if (!empty($type['Property'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Type Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($type['Property'] as $property): ?>
		<tr>
			<td><?php echo $property['id']; ?></td>
			<td><?php echo $property['name']; ?></td>
			<td><?php echo $property['type_id']; ?></td>
			<td><?php echo $property['created']; ?></td>
			<td><?php echo $property['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'properties', 'action' => 'view', $property['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'properties', 'action' => 'edit', $property['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'properties', 'action' => 'delete', $property['id']), array('confirm' => __('Are you sure you want to delete # %s?', $property['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Property'), array('controller' => 'properties', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
