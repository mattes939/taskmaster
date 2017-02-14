<?php

App::uses('AppModel', 'Model');

/**
 * Task Model
 *
 * @property Task $ParentTask
 * @property Author $Author
 * @property Task $ChildTask
 * @property Value $Value
 * @property User $User
 */
class Task extends AppModel {

    public $actsAs = array('Tree');

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';


    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'ParentTask' => array(
            'className' => 'Task',
            'foreignKey' => 'parent_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Author' => array(
            'className' => 'User',
            'foreignKey' => 'author_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'ChildTask' => array(
            'className' => 'Task',
            'foreignKey' => 'parent_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Value' => array(
            'className' => 'Value',
            'foreignKey' => 'task_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'User' => array(
            'className' => 'User',
            'joinTable' => 'tasks_users',
            'foreignKey' => 'task_id',
            'associationForeignKey' => 'user_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

    public function getRoot($id = NULL) {
//        while($parent != null){
//            $this->find('first')
//        }
    }

    /**
     * Returns an array of tasks based on a user id
     * @param string $userId - the id of an user
     * @return array of tasks
     */
    public function getTasksByUserId($userId = null) {
        if (empty($userId))
            return false;
        $tasks = $this->find('threaded', array(
            'joins' => array(
                array('table' => 'tasks_users',
                    'alias' => 'TasksUser',
                    'type' => 'INNER',
                    'conditions' => array(
                        'TasksUser.user_id' => $userId,
                        'TasksUser.task_id = Task.id'
                    )
                )
            ),
            'group' => 'Task.id',
            'contain' => [
                'Value' => [
                    'Property'
                ]
            ],
            'order' => ['Task.lft' => 'ASC']
        ));
        return $tasks;
    }

    public function saveChild($task, $parentId) {
        $task['Task']['parent_id'] = $parentId;
        $properties = $this->Value->find('list', [
            'conditions' => [
                'Value.task_id' => $parentId
            ],
            'fields' => ['id', 'property_id']
        ]);
        foreach($properties as $i => $property){
            $task['Value'][]['property_id'] = $property;
        }
        return $this->saveAll($task);
        
    }

}
