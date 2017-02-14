<?php
echo $this->Html->link($data['Task']['name'], ['controller' => 'tasks', 'action' => 'view', $data['Task']['id']]);

