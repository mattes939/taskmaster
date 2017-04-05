<?php

App::uses('AppModel', 'Model');

/**
 * User Model
 *
 * @property Task $Task
 * @property Task $Task
 */
class User extends AppModel {
    /**
     * Virtual fields
     *
     * @var string
     */
//    public $virtualFields = array(
//        'name' => 'CONCAT(User.first_name, " ", User.last_name, "(", User.username, ")")'
//    );

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'username';


    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Comment' => array(
            'className' => 'Comment',
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
        ),
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Task' => array(
            'className' => 'Task',
            'joinTable' => 'tasks_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'task_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = [
        'username' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
//            'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => 'Zadejte platnou emailovou adresu',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Tento email už je zaregistrován.'
            ),
        ),
    ];

//    public function getContacts($id) {
//        $contacts = [];
//        $taskIds = $this->TasksUser->find('all', [
//            'conditions' => [
//                'user_id' => $id,
////                'NOT' => [
////                    'task_id' => $currentTaskId
////                ]
//            ]
//        ]);
//        if (!empty($taskIds)) {
//            $taskIds = Hash::extract($taskIds, '{n}.TasksUser.task_id');
//
//            $userIds = $this->TasksUser->find('all', [
//                'conditions' => [
//                    'task_id' => $taskIds,
////                    'NOT' => [
////                        'user_id' => $id
////                    ]
//                ]
//            ]);
//            if (!empty($userIds)) {
//                $userIds = Hash::extract($userIds, '{n}.TasksUser.user_id');
//                $contacts = $this->find('list', [
//                    'conditions' => [
//                        'id' => $userIds
//                    ],
//                    'order' => [
//                        'username' => 'ASC'
//                    ]
//                ]);
//            }
//        }
////        debug($taskIds);
//        return $contacts;
//    }

    /**
     * Returns an array of users based on a task id
     * @param string $taskId - the id of an task
     * @return array of tasks
     */
    public function getUserIdsByTaskId($taskId = null) {
        if (empty($taskId))
            return false;
        $users = $this->find('list', array(
            'joins' => array(
                array('table' => 'tasks_users',
                    'alias' => 'TasksUser',
                    'type' => 'INNER',
                    'conditions' => array(
                        'TasksUser.task_id' => $taskId,
                        'TasksUser.user_id = User.id'
                    )
                )
            ),
            'group' => 'User.id',
            'order' => ['User.id' => 'ASC'],
            'fields' => ['User.id']
        ));
        return $users;
    }

    /**
     * Returns an array of users based on a task id
     * @param string $taskId - the id of an task
     * @return array of tasks
     */
    public function getUsersByTaskId($taskId = null) {
        if (empty($taskId))
            return false;
        $users = $this->find('list', array(
            'joins' => array(
                array('table' => 'tasks_users',
                    'alias' => 'TasksUser',
                    'type' => 'INNER',
                    'conditions' => array(
                        'TasksUser.task_id' => $taskId,
                        'TasksUser.user_id = User.id'
                    )
                )
            ),
            'group' => 'User.id',
            'order' => ['User.id' => 'ASC'],
            'fields' => ['User.id', 'User.username']
        ));
        return $users;
    }

}
