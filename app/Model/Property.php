<?php
App::uses('AppModel', 'Model');
/**
 * Property Model
 *
 * @property Type $Type
 * @property Value $Value
 */
class Property extends AppModel {

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
		'Type' => array(
			'className' => 'Type',
			'foreignKey' => 'type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Value' => array(
			'className' => 'Value',
			'foreignKey' => 'property_id',
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

        public function saveAttribute($attribute){
//            $this->create($attribute['Property']);

            $children = $this->Value->Task->children($attribute['Value'][0]['task_id'], false, ['id']);

            if (!empty($children)) {
                $children = Hash::extract($children, '{n}.Task.id');
                foreach ($children as $i => $child) {
                    $attribute['Value'][$i + 1]['task_id'] = $child;
                }
            }
            
            return $this->saveAll($attribute, ['deep' => true]);
        }
}
