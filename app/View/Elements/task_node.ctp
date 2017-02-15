<?php
echo $this->Html->link(mb_strimwidth($data['Task']['name'], 0, 20, '...'), ['controller' => 'tasks', 'action' => 'view', $data['Task']['id']], ['class' => 'btn btn-xs btn-primary']);

