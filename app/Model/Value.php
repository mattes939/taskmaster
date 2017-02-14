<?php

App::uses('AppModel', 'Model');

/**
 * Value Model
 *
 * @property Task $Task
 * @property Property $Property
 */
class Value extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'value';


    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Task' => array(
            'className' => 'Task',
            'foreignKey' => 'task_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Property' => array(
            'className' => 'Property',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function saveChildValues($taskId = NULL, $propertyId = NULL) {
        $children = $this->Task->children($taskId, false, ['id']);

        if (!empty($children)) {
            $children = Hash::extract($children, '{n}.Task.id');
            $attributes = [];
            foreach ($children as $i => $child) {
                $attributes[$i]['Value']['task_id'] = $child;
                $attributes[$i]['Value']['property_id'] = $propertyId;
            }
            $this->saveAll($attributes);
        }
    }

}
