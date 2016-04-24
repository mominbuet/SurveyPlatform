<?php

App::uses('AppModel', 'Model');

/**
 * UsersQuestionData Model
 *
 * @property User $User
 * @property QsnSetMaster $QsnSetMaster
 */
class UsersQuestionData extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
//    public $actsAs = array(
//        'Search.Searchable'
//    );
    public $displayField = 'water_code';
    var $actsAs = array(
        'FileModel' => array(
            'file_field' => array('image'),
            'file_db_file' => array('image_url'),
            'custom_dir' => array('image'),
            'use_model_name' => true
        )
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
//    public $filterArgs = array(
//        'water_code' => array(
//            'type' => 'like'
//        ),
//        'username' => array(
//            'type' => 'like', 'field' => array(
//                'User.user_name',
//                'User.first_name'
//            )
//        )
//    );
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'QuestionSet' => array(
            'className' => 'QuestionSet',
            'foreignKey' => 'qsn_set_master_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SelectWaterPointType' => array(
            'className' => 'SelectWaterPointType',
            'foreignKey' => 'water_point_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SelectLandType' => array(
            'className' => 'SelectLandType',
            'foreignKey' => 'land_use_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SelectOwnership' => array(
            'className' => 'SelectOwnership',
            'foreignKey' => 'owner_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SelectDistrict' => array(
            'className' => 'SelectDistrict',
            'foreignKey' => 'district_id',
            
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SelectUnion' => array(
            'className' => 'SelectUnion',
            'foreignKey' => 'union_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SelectUpzilla' => array(
            'className' => 'SelectUpzilla',
            'foreignKey' => 'upzilla_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'SelectVillage' => array(
            'className' => 'SelectVillage',
            'foreignKey' => 'village_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );
    public $hasMany = array(
        'QuestionAnswer' => array(
            'className' => 'QuestionAnswer',
            'foreignKey' => 'user_qsn_data_id',
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
//    public function dateFrom($data = array()) {
//        if (strpos($data['year'], ' - ') !== false){
//            $tmp = explode(' - ', $data['year']);
//            $tmp[0] = $tmp[0] . '-01-01';
//            $tmp[1] = $tmp[1] . '-12-31';
//            return $tmp;
//        } else {
//            return array($data['year'] . '-01-01', $data['year']."-12-31");
//        }
//    }
}