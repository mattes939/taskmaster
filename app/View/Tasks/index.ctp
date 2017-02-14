<h2>Moje úkoly</h2>
<?php
    echo $this->Tree->generate($tasks, [
        'element' => 'task_node',
//        'autoPath' => array($task['Task']['lft'], $task['Task']['rght'])
    ]);