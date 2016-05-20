<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::uses('ConnectionManager', 'Model');

class SurveyAPIController extends AppController {

    public $components = array('RequestHandler');

    public function beforeFilter() {

        parent::beforeFilter();
        $this->Auth->allow();
        $this->autoLayout = FALSE;
        $this->autoRender = FALSE;
    }

    public function save_directory() {

        $this->loadModel('UserDirectory');
        $this->UserDirectory->create();
        echo json_encode($this->UserDirectory->save($this->request->data));
    }

    public function save_directories() {


        $contact_id = array();
        $this->loadModel('UserDirectory');

        $data = $this->request->input('json_decode');
        foreach ($data->Directory as $user_contact) {
            $this->UserDirectory->create();
            //echo json_encode($user_contact);echo '======';
            $contact_id[] = $this->UserDirectory->save($user_contact);
        }

        if (count($contact_id) > 0) {
            echo json_encode(array("Status" => "true", "Directory" => $contact_id));
        } else {
            echo json_encode(array("Status" => "false", "Directory" => $contact_id));
        }
    }

    public function getFile($type = null) {
        if ($type) {
            $this->loadModel('AndroidApp');

            $this->AndroidApp->recursive = -1;
//            debug($id);
            $options = array(
                'conditions' => array('type' => $type),
                'orders' => array('AndroidApp.inserted desc'));
            $track_here = $this->AndroidApp->find('first', $options);
//debug($track_here);
            $path = UPLOADS . $this->
                    AndroidApp->alias . DS . $track_here['AndroidApp']['id'] . DS . $track_here['AndroidApp']['android'];

            $this->response->file($path);
            return $this->response;
        }
    }

    public function generate_table_PSU($survey_id = null) {
        if ($survey_id) {

            $q = "CREATE TABLE IF NOT EXISTS pmtc_" . $survey_id . "s ("
                    . "`id` int(11) NOT NULL PRIMARY KEY, 
                        `user_name` varchar(150) not null,
  `Latitude` varchar(20) DEFAULT NULL,
  `Longitude` varchar(20) DEFAULT NULL,
  `DistrictName` varchar(75) DEFAULT NULL,
  `UpzillaName` varchar(75) DEFAULT NULL,
  `UnionName` varchar(75) DEFAULT NULL,
  `Inserted` DATETIME NOT NULL,
  `Insertedby` varchar(75) NOT NULL,
  `Verified` tinyint(4) DEFAULT '0',
  `Verifytime` datetime DEFAULT NULL,
  `Year` varchar(4) DEFAULT NULL,
  `insert_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ";
            $this->loadModel("Question");
            $this->loadModel("UsersQuestionData");
            $this->loadModel("QuestionAnswer");
            $this->loadModel("SelectUnion");
            $this->loadModel("SelectUpzilla");
            $qsns = array("");
            $questions = $this->Question->find("list", array(
                "conditions" => array("qsn_set_id" => $survey_id),
                "order" => array("id")));
            foreach ($questions as $key => $value) {
                $value = str_replace("?", "", $value);
                $value = str_replace(",", "_", $value);
//                $value = str_replace(" ", "", $value);

                $value = str_replace("(", "_", $value); //added on 5th may
                $value = str_replace(")", "_", $value);
                $newVal = "";
//                $values=;
                foreach (explode(" ", $value) as $val) {
                    debug($val);
                    $newVal.= strtoupper($val[0]) + substr($val, 1, strlen($val));
                }
                $value = $newVal;
                if (!in_array($value, $qsns)) {
                    $qsns[] = $value;
                    $q.=", `" . $value . "` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci";
                }
            }
            $q.="  );";

            $db = ConnectionManager::getDataSource('default');
//            echo $q;
            $db->query($q);
            $db->query('alter table pmtc_' . $survey_id . 's convert to character set utf8 collate utf8_unicode_ci;');
            $last_updated = $db->query("select inserted from pmtc_" . $survey_id . "s order by inserted desc limit 1; ");
            $answers = array();
            $fields = array('DISTINCT UsersQuestionData.id', 'SelectDistrict.district_name', 'UsersQuestionData.district_id',
                'UsersQuestionData.geo_lat', 'UsersQuestionData.union_id', 'SelectUpzilla.Upzilla_name', 'SelectUnion.Union_name',
                'UsersQuestionData.geo_lon', 'UsersQuestionData.insert_time', 'UsersQuestionData.water_code',
                'User.user_name', 'UsersQuestionData.is_verify', 'UsersQuestionData.year',
                'UsersQuestionData.upzilla_id', 'SelectLandType.land_use_name', 'SelectOwnership.ownership_name',
                'SelectWaterPointType.water_point_type_name', 'UsersQuestionData.verify_time');
//            $answers = $this->UsersQuestionData->find("all", array(
//                'fields' => $fields,
//                'order'=>array('UsersQuestionData.id desc'),
//                "conditions" => array("qsn_set_master_id" => $survey_id,
//                    )));
            if (sizeof($last_updated) == 0) {
                $answers = $this->UsersQuestionData->find("all", array(
                    'fields' => $fields,
                    "conditions" => array("qsn_set_master_id" => $survey_id)));
            } else {
                $answers = $this->UsersQuestionData->find("all", array('recursion' => 0,
                    'fields' => $fields,
                    "conditions" => array("qsn_set_master_id" => $survey_id,
                        'UsersQuestionData.insert_time > ' => $last_updated[0]['pmtc_' . $survey_id . 's']['inserted'])));
            }
            debug($answers);
            if (sizeof($answers) != 0) {
                try {
                    foreach ($answers as $key => $value) {
                        //echo ('upzilla '.$value['UsersQuestionData']['upzilla_id'].'district '.$value['UsersQuestionData']['district_id']);
                        $upzilla = $this->SelectUpzilla->find("first", array(
                            "fields" => array('upzilla_name', 'upzilla_id'),
                            "conditions" => array("upzilla_code" => $value['UsersQuestionData']['upzilla_id'], //bad soln, check later
                                "SelectDistrict.district_code" => $value['UsersQuestionData']['district_id'])));
                        debug($upzilla);
                        $union = $this->SelectUnion->find("first", array(
                            'fields' => array('SelectUnion.union_name'),
                            "conditions" => array("union_code" => $value['UsersQuestionData']['union_id'], //here code works, check wid mama
                                "SelectUnion.upzilla_id" => $upzilla['SelectUpzilla']['upzilla_id'],)));
                        $district = $this->UsersQuestionData->SelectDistrict->find("first", array(
                            "fields" => array('district_name'),
                            "conditions" => array("district_code" => $value['UsersQuestionData']['district_id'])));
                        $dis = str_replace("'", "&#39;", (sizeof($district) > 0 ? $district['SelectDistrict']['district_name'] : ""));
                        $insQ = "insert into pmtc_" . $survey_id . "s values('" . $value['UsersQuestionData']['id'] . "','"
                                . $value['User']['user_name'] . "','"
                                . $value['UsersQuestionData']['geo_lat'] . "','"
                                . $value['UsersQuestionData']['geo_lon'] . "','"
//                            . $value['SelectVillage']['village_name'] . "','"
                                . $dis . "','"
                                . (sizeof($upzilla) > 0 ? $upzilla['SelectUpzilla']['upzilla_name'] : '') . "','"
                                . (sizeof($union) > 0 ? $union['SelectUnion']['union_name'] : '') . "','"
                                . $value['UsersQuestionData']['insert_time'] . "','"
                                . $value['User']['user_name'] . "','"
//                                . $value['UsersQuestionData']['water_code'] . "','"
//                            . $value['UsersQuestionData']['image_url'] . "','"
                                . $value['UsersQuestionData']['is_verify'] . "','"
                                . $value['UsersQuestionData']['verify_time'] . "','"
//                                . $value['SelectLandType']['land_use_name'] . "','"
//                                . $value['SelectOwnership']['ownership_name'] . "','"
//                                . $value['SelectWaterPointType']['water_point_type_name'] . "','"
                                . $value['UsersQuestionData']['year'] . "',now()";
                        foreach ($questions as $quesKey => $qVal) {
                            $qsnAns = ($this->QuestionAnswer->find("first", array("recursive" => -1,
                                        "order" => array('QuestionAnswer.question_id'),
                                        "conditions" => array(
                                            'question_id' => $quesKey,
                                            "user_qsn_data_id" => $value['UsersQuestionData']['id']))));

                            if (sizeof($qsnAns) <= 0)
                                $insQ.=",null";
                            else {
//                                if (strpos($qsnAns['QuestionAnswer']['qsn_answer'], 'image/') === false)
                                $t = str_replace("'", "&#39;", $qsnAns['QuestionAnswer']['qsn_answer']);
//                                else {
//                                    $t = "http://182.48.87.66:8080/PSU/SurveyAPI/get_image_answer_id/" . $qsnAns['QuestionAnswer']['qsn_answer'];
//                                    
//                                }
                                $insQ.=",'" . $t . "'";
                            }
                        }
//                    break;
                        //echo $insQ . ");";
                        $db->query($insQ . ");");
                    }
                } catch (Exception $ex) {
                    debug($ex->getMessage());
                }
            }
            if ($this->Session->read('Auth.User.User.id')) {
                $this->loadModel("UserHistory");
                $this->UserHistory->create();
                $this->UserHistory->save(array('user_id' => $this->Session->read('Auth.User.User.id'),
                    'event_details' => "Generated Survey Report" . $this->request->header('User-Agent'),
                    'ipaddress' => $this->request->clientIp(),
                    'event_time' => $this->UserHistory->getDataSource()->expression('NOW()'),
                    'user_event' => 'Generated Survey Report',
                ));
            }
            echo json_encode(sizeof($answers) . " rows inserted");
        }
    }

    public function chartdata2($survey = null, $col = null, $func = 'count') {
        $this->response->disableCache();
        $col = '`' . $col . '`';
        if ($col && $survey) {
            $this->loadModel($survey);
            if ($func != 'perc')
                $data = ($this->$survey->find("all", array('fields' => array("$col as col1, $func($col) as cnt"), 'recursive' => 0, 'group' => 'col1')));
            else {
                $tmp = $this->$survey->find("all", array("fields" => array("sum($col) as smtmp")));
//                debug($tmp);
                $data = $this->$survey->find("all", array('fields' => array("$col as col1, "
                        . "round(( sum($col)/" . $tmp[0][0]['smtmp'] . " * 100 ),2) as cnt"),
//                   . "(count($group_by)*100.0/sum($group_by)) as cnt"),
                    'recursive' => 0,
                    'group' => 'col1'));
            }
            $retdata = array();
//            debug($data);
//            if (is_int($col)) {
//                $qsn = $this->Question->find('list', array('recursive' => -1, 'conditions' => array("id" => $value)));
//                foreach ($data as $key => $value) {
////                debug($value);
//                    $retdata[] = array("key" => $qsn[$value[0]['col1']],
//                        "value" => $value[0]['cnt']);
//                }
//            } else {
            foreach ($data as $key => $value) {
//                debug($value);
                $retdata[] = array("key" => $value[$survey]['col1'],
                    "value" => $value[0]['cnt']);
            }
        }
        echo json_encode($retdata);
//        }
    }

    public function generate_table($survey_id = null) {
        if ($survey_id) {

            $q = "CREATE TABLE IF NOT EXISTS pmtc_" . $survey_id . "s ("
                    . "`id` int(11) NOT NULL PRIMARY KEY, 
                        `user_name` varchar(150) not null,
  `Latitude` varchar(20) DEFAULT NULL,
  `Longitude` varchar(20) DEFAULT NULL,
  `DistrictName` varchar(75) DEFAULT NULL,
  `UpzillaName` varchar(75) DEFAULT NULL,
  `UnionName` varchar(75) DEFAULT NULL,
  `Inserted` DATETIME NOT NULL,
  `Insertedby` varchar(75) NOT NULL,
  `Verified` tinyint(4) DEFAULT '0',
  `Verifytime` datetime DEFAULT NULL,
  `Year` varchar(4) DEFAULT NULL,
  `insert_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ";
            $this->loadModel("Question");
            $this->loadModel("UsersQuestionData");
            $this->loadModel("QuestionAnswer");
            $this->loadModel("SelectUnion");
            $this->loadModel("SelectUpzilla");
            $questions = $this->Question->find("list", array(
//                "fields"=>array(" DISTINCT  qsn_desc","id"),
                "conditions" => array("qsn_set_id" => $survey_id),
                "order" => array("id")));
//            debug($questions);
            $tmp_unique = array();
            foreach ($questions as $key => $value) {
                $q.=", `" . $key . "` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci";
//                $value = str_replace("?", "", $value);
//                $value = str_replace(",", "_", $value);
////                $value = str_replace(" ", "", $value);
//
//                $value = str_replace("(", "_", $value); //added on 5th may
//                $value = str_replace(")", "_", $value);
//                $newVal="";
////                $values=;
//                foreach (explode(" ", $value) as $val){
//                    if(strlen($val)>0)
//                    $newVal.= strtoupper($val[0]).substr($val,1,strlen($val));
//                    else
//                    $newVal.= strtoupper($val);   
//                }
////                debug($newVal);
//                $value=$newVal;
//                if (!in_array($value, $tmp_unique)) {
//                    array_push($tmp_unique, $value);
//                    $q.=", `" . $value . "` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci";
//                } else {
//                    $q.=", `2" . $value . "` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci";
//                }
            }
            $q.="  );";

            $db = ConnectionManager::getDataSource('default');
//            echo $q;
            $db->query($q);
            $db->query('alter table pmtc_' . $survey_id . 's convert to character set utf8 collate utf8_unicode_ci;');
            $last_updated = $db->query("select inserted from pmtc_" . $survey_id . "s order by inserted desc limit 1; ");
            $answers = array();
            $fields = array('DISTINCT UsersQuestionData.id', 'SelectDistrict.district_name', 'UsersQuestionData.district_id',
                'UsersQuestionData.geo_lat', 'UsersQuestionData.union_id', 'SelectUpzilla.Upzilla_name', 'SelectUnion.Union_name',
                'UsersQuestionData.geo_lon', 'UsersQuestionData.insert_time', 'UsersQuestionData.water_code',
                'User.user_name', 'UsersQuestionData.is_verify', 'UsersQuestionData.year',
                'UsersQuestionData.upzilla_id', 'SelectLandType.land_use_name', 'SelectOwnership.ownership_name',
                'SelectWaterPointType.water_point_type_name', 'UsersQuestionData.verify_time');
//            $answers = $this->UsersQuestionData->find("all", array(
//                'fields' => $fields,
//                'order'=>array('UsersQuestionData.id desc'),
//                "conditions" => array("qsn_set_master_id" => $survey_id,
//                    )));
            if (sizeof($last_updated) == 0) {
                $answers = $this->UsersQuestionData->find("all", array(
                    'fields' => $fields,'limit'=>200,'offset'=>0,
                    "conditions" => array("qsn_set_master_id" => $survey_id)));
            } else {
                $answers = $this->UsersQuestionData->find("all", array('recursion' => 0,
                    'fields' => $fields,'limit'=>200,'offset'=>0,
                    "conditions" => array("qsn_set_master_id" => $survey_id,
                        'UsersQuestionData.insert_time > ' => $last_updated[0]['pmtc_' . $survey_id . 's']['inserted'])));
//                
            }
//            debug($answers);
            if (sizeof($answers) != 0) {
//                try {
                foreach ($answers as $key => $value) {
                    try {
                        //echo ('upzilla '.$value['UsersQuestionData']['upzilla_id'].'district '.$value['UsersQuestionData']['district_id']);
                        $upzilla = array("SelectUpzilla" => array("upzilla_name" => ""));
                        $district = array("SelectDistrict" => array("district_name" => ""));
                        $union = array("SelectUnion" => array("union_name" => ""));
                        if ($value["UsersQuestionData"]["upzilla_id"])
                            $upzilla = $this->SelectUpzilla->find("first", array(
                                "fields" => array('upzilla_name', 'upzilla_id'),
                                "conditions" => array("upzilla_code" => $value['UsersQuestionData']['upzilla_id'], //bad soln, check later
                                    "SelectDistrict.district_code" => $value['UsersQuestionData']['district_id'])));
                        if ($value["UsersQuestionData"]["union_id"])
                            $union = $this->SelectUnion->find("first", array(
                                'fields' => array('SelectUnion.union_name'),
                                "conditions" => array("union_code" => $value['UsersQuestionData']['union_id'], //here code works, check wid mama
                                    "SelectUnion.upzilla_id" => $upzilla['SelectUpzilla']['upzilla_id'],)));
                        if ($value["UsersQuestionData"]["district_id"])
                            $district = $this->UsersQuestionData->SelectDistrict->find("first", array(
                                "fields" => array('district_name'),
                                "conditions" => array("district_code" => $value['UsersQuestionData']['district_id'])));

                        $dis = str_replace("'", "&#39;", (sizeof($district) > 0 ? $district['SelectDistrict']['district_name'] : ""));

                        $insQ = "insert into pmtc_" . $survey_id . "s values('" . $value['UsersQuestionData']['id'] . "','"
                                . $value['User']['user_name'] . "','"
                                . $value['UsersQuestionData']['geo_lat'] . "','"
                                . $value['UsersQuestionData']['geo_lon'] . "','"
//                            . $value['SelectVillage']['village_name'] . "','"
                                . $dis . "','"
                                . (sizeof($upzilla) > 0 ? $upzilla['SelectUpzilla']['upzilla_name'] : '') . "','"
                                . (sizeof($union) > 0 ? $union['SelectUnion']['union_name'] : '') . "','"
                                . $value['UsersQuestionData']['insert_time'] . "','"
                                . $value['User']['user_name'] . "','"
//                                . $value['UsersQuestionData']['water_code'] . "','"
//                            . $value['UsersQuestionData']['image_url'] . "','"
                                . $value['UsersQuestionData']['is_verify'] . "','"
                                . $value['UsersQuestionData']['verify_time'] . "','"
//                                . $value['SelectLandType']['land_use_name'] . "','"
//                                . $value['SelectOwnership']['ownership_name'] . "','"
//                                . $value['SelectWaterPointType']['water_point_type_name'] . "','"
                                . $value['UsersQuestionData']['year'] . "',now()";
                        foreach ($questions as $quesKey => $qVal) {
                            $qsnAns = ($this->QuestionAnswer->find("all", array("recursive" => -1,
                                        "order" => array('QuestionAnswer.question_id'),
                                        "conditions" => array(
                                            'question_id' => $quesKey,
                                            "user_qsn_data_id" => $value['UsersQuestionData']['id']))));
//debug($qsnAns);
                            if (sizeof($qsnAns) <= 0)
                                $insQ.=",null";
                            else {
                                $t = "";
                                foreach ($qsnAns as $vqsnAns) {
                                    $t .= str_replace("'", "&#39;", $vqsnAns['QuestionAnswer']['qsn_answer']) .
                                            ((sizeof($qsnAns) > 1) ? "," : "");
                                }
//                                debug($t);
                                $insQ.=",'" . $t . "'";
                            }
                        }
//                    break;
//                        debug($insQ . ");");
//                        
                        $db->query($insQ . ");");
                    } catch (Exception $ex) {
                        debug($ex->getMessage());
                    }
                }
            }
            $this->loadModel("UserHistory");
            $this->UserHistory->create();
            $this->UserHistory->save(array('user_id' => $this->Session->read('Auth.User.User.id'),
                'event_details' => "Generated Survey Report" . $this->request->header('User-Agent'),
                'ipaddress' => $this->request->clientIp(),
                'event_time' => $this->UserHistory->getDataSource()->expression('NOW()'),
                'user_event' => 'Generated Survey Report',
            ));
            echo json_encode(sizeof($answers) . " rows inserted");
        }
    }

//    public function chartdata2($survey = null, $col = null, $group_by = null, $func = 'count') {
//        $this->response->disableCache();
//        if ($col && $survey && $group_by) {
//            $this->loadModel($survey);
//            if ($func != 'perc')
//                $data = ($this->$survey->find("all", array('fields' => array("$col as col1, $func($group_by) as cnt"),
//                            'recursive' => 0,
//                            'group' => $col)));
//            else {
//                $tmp = $this->$survey->find("all", array("fields" => array("sum($group_by) as smtmp")));
////                debug($tmp);
//                $data = $this->$survey->find("all", array('fields' => array("$col as col1, "
//                        . "round(( sum($group_by)/" . $tmp[0][0]['smtmp'] . " * 100 ),2) as cnt"),
////                   . "(count($group_by)*100.0/sum($group_by)) as cnt"),
//                    'recursive' => 0,
//                    'group' => $col));
//            }
//            $retdata = array();
////            debug($data);
//            foreach ($data as $key => $value) {
////                debug($value);
//                $retdata[] = array("key" => $value[$survey]['col1'],
//                    "value" => $value[0]['cnt']);
//            }
//            echo json_encode($retdata);
//        }
//    }

    public function chartdata($col = null, $group_by = null) {
        $this->response->disableCache();

        if ($col) {

            $this->loadModel('UsersQuestionData');
//            debug($this->UsersQuestionData->schema());
            if ($group_by == "")
                $group_by = "*";
//            $this->UsersQuestionData->virtualFields['cnt'] = "COUNT(`UsersQuestionData`.`$group_by`)";
//            debug($this->UsersQuestionData->virtualFields);
            $retdata;
            if ($col == "user_id") {
                $data = $this->UsersQuestionData->find("all", array('fields' => array("User.user_name as col, count($group_by) as cnt"),
                    'recursive' => 0,
                    'group' => $col));
//                debug ($data);
                foreach ($data as $value) {
                    $retdata[] = array("key" => $value['User']['col'],
                        "value" => $value[0]['cnt']);
                }
            } else if ($col == "qsn_set_master_id") {
                $data = $this->UsersQuestionData->find("all", array('fields' => array("QuestionSet.qsn_set_name as col, count($group_by) as cnt"),
                    'recursive' => 0,
                    'group' => $col));
                foreach ($data as $value) {
                    $retdata[] = array("key" => $value['QuestionSet']['col'], "value" => $value[0]['cnt']);
                }
            } else if ($col == "water_code") {
                $data = $this->UsersQuestionData->find("all", array('fields' => array(" UsersQuestionData.water_code as col, count($group_by) as cnt"),
                    'recursive' => 0,
                    'group' => $col));
                foreach ($data as $value) {
                    $retdata[] = array("key" => $value['UsersQuestionData']['col'],
                        "value" => $value[0]['cnt']);
                }
            } else {
                $data = $this->UsersQuestionData->find("all", array('field s' => array("UsersQuestionData.$col, count($group_by) as cnt"),
                    'recursive' => 0,
                    'group' => $col));
                foreach ($data as $value) {
                    $retdata[] = array("key" => $value[
                        'UsersQuestionData']['col'],
                        "value" => $value[0]['cnt']);
                }
            }

            echo json_encode($retdata);
        }
    }

    public function get_file_information() {
        $this->loadModel('AndroidApp');
        $qs = $this->AndroidApp->find('all', array('fields' => array('app_name', 'id', 'version', 'inserted', 'comment', 'type', 'android')));
        if ($qs) {
            echo json_encode(array(
                'status' => 'SUCCESS', "result" => $qs));
        } else {
            echo json_encode(array('status' => 'ERROR', 'message' => 'File information cannot be loaded'));
        }
    }

    public function get_question_types() {
        $this->loadModel('QuestionType');
        $qs = $this->QuestionType->find('all');
        if ($qs) {
            echo json_encode(array(
                'status' => 'SUCCESS', "result" => $qs));
        } else {
            echo json_encode(array('status' => 'ERROR', 'message' => 'Survey cannot be loaded'));
        }
    }

    public function get_image_id($id = null) {
        if ($id) {
            $this->loadModel('QuestionAnswer');
            $this->QuestionAnswer->recursive = -1;
            $options = array('fields' => array('qsn_answer'),
                'conditions' => array('QuestionAnswer.' . $this->QuestionAnswer->primaryKey => $id));
            $track_here = $this->QuestionAnswer->find('first', $options);
//debug($track_here);
            $path = UPLOADS . $this->
                    QuestionAnswer->alias . DS . $id . DS . $track_here['QuestionAnswer']['qsn_answer'];

            $this->response->file($path);
            return $this->response;
        }
    }

    public function get_db_backup() {
        $dir = new Folder(UPLOADS . 'dbbackups/');
//        $path = UPLOADS . 'dbbackups/';
//        debug($dir->find('.*\.sql'));
        $this->response->file(UPLOADS . 'dbbackups/psu.sql');
        return $this->response;
    }

    public function get_uploaded_file_id($id = null) {
        if ($id) {
            $this->loadModel('AndroidApp');

            $this->AndroidApp->recursive = -1;
            $options = array(
                'conditions' => array('AndroidApp.id' => $id));
            $track_here = $this->AndroidApp->find('first', $options);
//            debug($track_here);
            $path = UPLOADS . $this->
                    AndroidApp->alias . DS . $track_here['AndroidApp']['id'] . DS . $track_here['AndroidApp']['android'];

            $this->response->file($path);
            return $this->response;
        }
    }

    public function get_image_answer_id($image = null, $name = null) {
        if ($name) {
            $this->loadModel('QuestionAnswer');

            $this->QuestionAnswer->recursive = -1;
            $options = array('fields' => array('id'),
                'conditions' => array('QuestionAnswer.qsn_answer' => $image . DS . $name));
            $track_here = $this->QuestionAnswer->find('first', $options);
//debug($track_here);
            $path = UPLOADS . $this->
                    QuestionAnswer->alias . DS . $track_here['QuestionAnswer']['id'] . DS . $image . DS . $name;

            $this->response->file($path);
//            return $this->response;
        }
    }

    public function get_main_answers_of_users($user_id = null, $limit = 10, $offset = 0) {
        if ($user_id) {
            $this->loadModel('UsersQuestionData');
            $this->UsersQuestionData->recursive = -1;
            $qs = $this->UsersQuestionData->find('all', array('limit' => $limit, 'offset' => $offset,
                'fields' => array('UsersQuestionData.id', 'UsersQuestionData.geo_lat', 'UsersQuestionData.geo_lon', 'UsersQuestionData.insert_time',
                    'UsersQuestionData.qsn_set_master_id', 'UsersQuestionData.insert_user_id', 'UsersQuestionData.user_form_id'),
                'conditions' => array('UsersQuestionData.user_id' => $user_id)));
            echo json_encode($qs);
        }
    }

    public function get_answers($questionID = null) {
        if ($questionID) {
            $this->loadModel('QuestionAnswer');
//            $this->QuestionAnswer->recursive = 2;
            $qs = $this->QuestionAnswer->find('all', array(
                'fields' => array('QuestionAnswer.qsn_answer', 'QuestionAnswer.id', 'QuestionAnswer.user_qsn_data_id',
                    'UsersQuestionData.geo_lat', 'UsersQuestionData.geo_lon',
                    'UsersQuestionData.id',
                    'Question.qsn_desc'),
                'conditions' => array('QuestionAnswer.user_qsn_data_id' => $questionID,
                    'Question.qsn_desc is not null'),
                'order' => array('Question.id' => 'Asc')));
            echo json_encode($qs);
        }
    }

//    public function upload_answer_pictures() {
//        echo json_encode(array("status" => "ERROR", "message" => "picture did not get uploaded, please try later."));
//    }

    public function upload_answer_picture() {

        $this->loadModel('QuestionAnswer');
//        if (!$this->UsersQuestionData->exists($this->request->data['UsersQuestionData']['id'])) {
//            throw new NotFoundException(__('Invalid select district'));
//        }
        $this->QuestionAnswer->create();
//            $this->UsersQuestionData->read(null, $insert_id);
//            $this->UsersQuestionData->save(array('picture' => $this->request->data));
        if ($this->QuestionAnswer->save($this->request->data)) {
            echo json_encode(array("status" => "SUCCESS", "message" => "picture uploaded successfully")
            );
        } else {
            echo json_encode(array("status" => "ERROR", "message" => "picture did not get uploaded, please try later."));
        }
//        }
    }

//    public function upload_answer_picture() {
//
//        $this->loadModel('UsersQuestionData');
//        if (!$this->UsersQuestionData->exists($this->request->data['UsersQuestionData']['id'])) {
//            throw new NotFoundException(__('Invalid select district'));
//        }
//        $this->UsersQuestionData->create();
////            $this->UsersQuestionData->read(null, $insert_id);
//        //            $this->UsersQuestionData->save(array('picture' => $this->request->data));
//        if ($this->UsersQuestionData->save($this->request->data)) {
//            echo json_encode(array("status" => "SUCCESS", "message" => "picture uploaded successfully")
//            );
//        } else {
//            echo json_encode(array("status" => "ERROR", "message" => "picture did not get uploaded, please try later."));
//        }
////        }
//    }

    public function deleteAjax($id = null) {
        $this->loadModel("QuestionSet");
        $this->QuestionSet->id = $id;
        if (!$this->QuestionSet->exists()) {
            throw new NotFoundException(__('Invalid question set'));
        }
//        if ($this->QuestionSet->find('count', array('conditions' => array('QuestionSet.parent_id' => $id)) != 0))
//            $this->QuestionSet->deleteAll(array('QuestionSet.parent_id' => $id), false);
//        $this->request->all
//        $this->request->allowMethod('post', 'delete');
//        if ($this->QuestionSet->deleteAll(array('QuestionSet.parent_id' => $id), false)) {
        if ($this->QuestionSet->delete())
            echo "Success";
        else {
            $this->Session->setFlash(__('The question set could not be deleted. Please, try again.'));
        }

//        } else {
//            $this->Session->setFlash(__('The question set\'s childs could not be deleted. Please, try again.'));
//        }
//return $this->redirect(array('action' => 'index'));
    }

    public function upload_answer($from_user_id = null) {
        if ($from_user_id) {
            $ret_res = array();

            $data = $this->request->input('json_decode');
            $user_id = $data->user_id;
            $ret_res;
            foreach ($data->result as $result) {
                try {
                    $this->loadModel('UsersQuestionData');
                    $this->loadModel('QuestionAnswer');
                    $this->UsersQuestionData->create();
                    if (array_key_exists("water_code", $result)) {
                        $this->UsersQuestionData->save(array('user_id' => $user_id,
                            'qsn_set_master_id' => $result->qsn_set_id,
                            'geo_lat' => $result->location->latitude,
                            'geo_lon' => $result->location->longitude,
                            'water_code' => $result->water_code,
                            'insert_user_id' => $from_user_id,
                            'visible_name_by_user' => $result->visible_name_by_user,
                            'is_supervisor' => $result->is_supervisor,
                            'user_form_id' => $result->user_form_id,
                            'year' => substr($result->water_code, 0, 4),
                            'land_use_type_id' => substr($result->water_code, 4, 1),
                            'owner_type_id' => substr($result->water_code, 5, 2),
                            'water_point_type_id' => substr($result->water_code, 7, 2),
                            'district_id' => (substr($result->water_code, 9, 2) != "00") ? substr($result->water_code, 9, 2) : NULL,
                            'upzilla_id' => (substr($result->water_code, 11, 2) != "00") ? substr($result->water_code, 11, 2) : NULL,
                            'union_id' => (substr($result->water_code, 13, 2) != "00") ? substr($result->water_code, 13, 2) : NULL,
                            'village_id' => (substr($result->water_code, 15, 2) != "00") ? substr($result->water_code, 15, 2) : NULL,
                        ));
                    } else {
                        $this->UsersQuestionData->save(array('user_id' => $user_id,
                            'qsn_set_master_id' => $result->qsn_set_id,
                            'geo_lat' => $result->location->latitude,
                            'geo_lon' => $result->location->longitude,
                            'insert_user_id' => $from_user_id,
                            'is_supervisor' => $result->is_supervisor,
                            'visible_name_by_user' => $result->visible_name_by_user,
                            'user_form_id' => $result->user_form_id,
                            //'child_ref_survey_id' => $result->child_ref_survey_id// child_survey_data_id 
                        ));
                    }
                    $qsndataID = $this->UsersQuestionData->getLastInsertId();
                    if ($result->is_supervisor == 1 && $qsndataID > 0) {
                        if (isset($result->user_survey_id)) {
                            $this->UsersQuestionData->query(" UPDATE pmtc_users_question_data SET is_audit_done = 'Y' WHERE id = " . $result->user_survey_id);
                        }
                    }
                    $qsn_lists = $result->qsn_lists;
                    foreach ($qsn_lists as $qsn_ans) {
                        $qsn_id = $qsn_ans->qsn_id;
                        $qsn_answers = $qsn_ans->answer;
                        $qsn_answers = explode('#', $qsn_answers);
                        foreach ($qsn_answers as $qsnanswer) {
                            if ($qsnanswer != "") {
                                $this->QuestionAnswer->create();
                                $this->QuestionAnswer->save(array('user_qsn_data_id' => $qsndataID,
                                    'qsn_answer' => $qsnanswer,
                                    'question_id' => $qsn_id
                                ));
                            }
                        }
                    }
                    $ret_res[] = array('user_form_id' => $result->user_form_id,
                        'insert_id' => $qsndataID);
                } catch (Exception $ex) {
                    $this->log("***********\r\nError in uploading answer \r\n water code"
                            . $result->water_code . " \r\n" . $ex->getMessage());
                }
            }
        }
        echo json_encode($ret_res);
    }

    public function get_survey_selection_options($questionID = null) {
        if ($questionID) {
            $this->loadModel('SelectMisc');
            $qs = $this->SelectMisc->find('list', array('fields' => array('SelectMisc.misc_id', 'SelectMisc.misc_option'),
                'conditions' => array('SelectMisc.question_id' => $questionID)));
            if ($qs) {
                echo json_encode(array('status' => 'SUCCESS', "result" => $qs));
            } else {
                echo json_encode(array('status' => 'ERROR', 'message' => 'Question selection option is not present'));
            }
        }
    }

    public function get_setup_data($type = null, $limit = 10000, $offset = null) { // set limit to 5000 from null
        if ($type) {
            if (!$limit)
                $limit = 30;
            if (!$offset)
                $offset = 0;
            if ($type == 'division') {
                $this->loadModel('SelectDivision');
                $qs = $this->SelectDivision->find('all', array('limit' => $limit, //int
                    'offset' => $offset));
            } else if ($type == 'district') {
                $this->loadModel('SelectDistrict');
                $this->SelectDistrict->recursive = -1;
                $qs = $this->SelectDistrict->find('all', array('limit' => $limit,
                    //'conditions'=>array('is_active'=>1),
                    'offset' => $offset));
            } else if ($type == 'upzilla') {
                $this->loadModel('SelectUpzilla');
                $this->SelectUpzilla->recursive = -1;
                $qs = $this->SelectUpzilla->find('all', array('limit' => $limit, //int
                    'offset' => $offset));
            } else if ($type == 'union') {
                $this->loadModel('SelectUnion');
                $this->SelectUnion->recursive = -1;
                $qs = $this->SelectUnion->find('all', array('limit' => $limit, //int
                    'offset' => $offset));
            } else if ($type == 'village') {
                $this->loadModel('SelectVillage');
                $this->SelectVillage->recursive = -1;
                $qs = $this->SelectVillage->find('all', array('limit' => $limit, //int
                    'offset' => $offset));
            } else if ($type == 'land_type') {
                $this->loadModel('SelectLandType');
                $this->SelectLandType->recursive = -1;
                $qs = $this->SelectLandType->find('all', array('limit' => $limit, //int
                    'offset' => $offset));
            } else if ($type == 'ownership') {
                $this->loadModel('SelectOwnership');
                $this->SelectOwnership->recursive = -1;
                $qs = $this->SelectOwnership->find('all', array('limit' => $limit, //int
                    'offset' => $offset));
            } else {
                $this->loadModel('SelectWaterPointType');
                $this->SelectWaterPointType->recursive = -1;
                $qs = $this->SelectWaterPointType->find('all', array('limit' => $limit, //int
                    'offset' => $offset));
            }


            if ($qs) {
                echo json_encode(array('status' => 'SUCCESS',
                    "result" => $qs));
            } else {
                echo json_encode(array('status' => 'ERROR', 'message' => 'No data can be loaded'));
            }
        }
    }

    public function get_questions($surveyID = null) {
        if ($surveyID) {
            $this->loadModel('Question');
            $this->loadModel('QuestionSet');

            $qset = $this->QuestionSet->query("select master_id from pmtc_question_sets where id = $surveyID");

            $qs = $this->Question->query(" SELECT questions.id,questions.qsn_desc,questions.rownames,questions.answer_length,questions.section_name "
                    . " from pmtc_questions as questions "
                    . " where questions.qsn_set_id  = $surveyID ");
//                    . ((is_null($qset[0]['pmtc_question_sets']['master_id'])) ? "" :
//                            " OR questions.qsn_set_id=" . $qset[0]['pmtc_question_sets']['master_id'] . " "));
            if ($qs) {
                echo json_encode(array('status' => 'SUCCESS',
                    "result" => $qs));
            } else {
                echo json_encode(array('status' => 'ERROR', 'message' => 'No questions'));
            }
        }
    }

    public function get_only_survey($userId = null) {
        if ($userId) {
            $this->loadModel('QuestionSet');
            $qs = $this->QuestionSet->query(" SELECT qsets.id,qsets.qsn_set_name,qsets.need_water_point_identification,qsets.geolocation "
                    . " from pmtc_question_sets as qsets "
                    . " INNER JOIN pmtc_question_group as qgrps on qgrps.question_set_id = qsets.id"
                    . " INNER JOIN pmtc_groups as grps on grps.id = qgrps.group_id"
                    . " INNER JOIN pmtc_user_groups as ugrps on ugrps.group_id = grps.id"
                    . " INNER JOIN pmtc_users as userss on userss.id = ugrps.user_id"
                    . " where userss.id = $userId"
                    . " order by qsets.id asc");
            if ($qs) {
                echo json_encode(array('status' => 'SUCCESS',
                    "result" => $qs));
            } else {
                echo json_encode(array('status' => 'ERROR', 'message' => 'Survey cannot be loaded'));
            }
        }
    }

    public function get_survey($userId = null) {
        if ($userId) {
            $this->loadModel('Question');
            $qs = $this->Question->query(" SELECT questions.*,vrules.rule_name,smisc.misc_option,smisc.next_section_id, "
                    . "qsections.section_name, qsets.qsn_set_name,qsets.need_water_point_identification,qsets.geolocation,qtypes.qsn_type as question_type"
                    . " from pmtc_questions as questions "
                    . " INNER JOIN pmtc_question_sets as qsets on qsets.id = questions.qsn_set_id "
                    . " INNER JOIN pmtc_question_group as qgrps on qgrps.question_set_id = qsets.id"
                    . " INNER JOIN pmtc_groups as grps on grps.id = qgrps.group_id"
                    . " INNER JOIN pmtc_user_groups as ugrps on ugrps.group_id = grps.id"
                    . " INNER JOIN pmtc_users as userss on userss.id = ugrps.user_id"
                    . " LEFT JOIN pmtc_question_types as qtypes on qtypes.id = questions.qsn_type_id"
                    . " LEFT JOIN pmtc_validation_rules as vrules on vrules.id = questions.validity_rule_id"
                    . " LEFT JOIN pmtc_select_misc as smisc on smisc.question_id = questions.id"
                    . " LEFT JOIN pmtc_question_sections as qsections on smisc.next_section_id = qsections.section_id"
                    . " where userss.id = $userId"
                    . " order by questions.qsu_order asc");
//$this->QuestionGroup->recursive = 2;
//$qs = $this->QuestionGroup->find('all');
            if ($qs) {

                echo json_encode(array('status' => 'SUCCESS',
                    "result" => $qs));
            } else {
                echo json_encode(array('status' => 'ERROR', 'message' => 'Survey cannot be loaded'));
            }
        }
    }

    public function get_survey_details($id = null) {
        if ($id != null) {
            $this->loadModel('Question');
//            $this->loadModel('SelectMisc');
            $qs = $this->Question->query(" SELECT questions.*,vrules.rule_name,"
                    . "qsections.section_name, qsets.qsn_set_name,qsets.need_water_point_identification,qsets.geolocation,qtypes.qsn_type as question_type"
                    . " from pmtc_questions as questions "
                    . " INNER JOIN pmtc_question_sets as qsets on qsets.id = questions.qsn_set_id "
//                    . " INNER JOIN pmtc_question_group as qgrps on qgrps.question_set_id = qsets.id"
//                    . " INNER JOIN pmtc_groups as grps on grps.id = qgrps.group_id"
//                    . " INNER JOIN pmtc_user_groups as ugrps on ugrps.group_id = grps.id"
//                    . " INNER JOIN pmtc_users as userss on userss.id = ugrps.user_id"
                    . " LEFT JOIN pmtc_question_types as qtypes on qtypes.id = questions.qsn_type_id"
                    . " LEFT JOIN pmtc_validation_rules as vrules on vrules.id = questions.validity_rule_id"
                    . " LEFT JOIN pmtc_select_misc as smisc on smisc.question_id = questions.id"
                    . " LEFT JOIN pmtc_question_sections as qsections on smisc.next_section_id = qsections.section_id"
                    . " where qsets.id = $id"
                    . " order by questions.qsu_order asc");
//$this->QuestionGroup->recursive = 2;
//$qs = $this->QuestionGroup->find('all');

            foreach ($qs as &$questions) {
                $questions['qoptions'] = ($this->Question->SelectMisc->find('all', array('fields' => array('misc_option', 'misc_option_bangla', 'next_section_id'), 'recursive' => -1, 'conditions' => array('question_id' => $questions['questions']['id']))));
            }
//            debug($qs);
            if ($qs) {

                echo json_encode(array('status' => 'SUCCESS',
                    "result" => $qs));
            } else {
                echo json_encode(array('status' => 'ERROR', 'message' => 'Survey cannot be loaded'));
            }
//            $this->loadModel('QuestionSet');
//            $this->QuestionSet->recursive = 1;
//            $qs = $this->QuestionSet->find('all');
//            if ($qs) {
//                echo json_encode(array('status' => 'SUCCESS',
//                    "result" => $qs));
//            } else {
//                echo json_encode(array('status' => 'ERROR', 'message' => 'Survey cannot be loaded'));
//            }
        }
    }

    public function add_survey() {
        $this->loadModel('QuestionSet');
        $qs = $this->QuestionSet->save(array(
            'qsn_set_name' => $this->request->data['name'],
            'qsn_set_description' => $this->request->data['description']
        ));

        $this->response->disableCache();
        if ($qs) {
            echo json_encode(array('status' => 'SUCCESS', "result" => $qs));
        } else {
            echo json_encode(array('status' => 'ERROR', 'message' => 'Survey cannot be saved'));
        }
    }

    public function edit_survey_master() {
        if ($this->request->is('post')) {
            $this->loadModel('UsersQuestionData');
//            debug($this->request->data);
            $this->UsersQuestionData->save($this->request->data);
            $tmp = $this->UsersQuestionData->find('first', array('conditions' => array('UsersQuestionData.id' => $this->request->data['UsersQuestionData']['id'])));
            echo json_encode($tmp);
        }
    }

    public function send_msg() {
        if ($this->request->is('post')) {
            $this->loadModel('UserMessage');
            $this->UserMessage->create();

            echo json_encode($this->UserMessage->save($this->request->data));
        }
    }

    public function set_viewed($msgid = null) {
        if ($msgid) {
            $this->loadModel('UserMessage');
            $tmp['UserMessage']['id'] = $msgid;
            $tmp['UserMessage']['viewed'] = 1;
            echo json_encode($this->UserMessage->save($tmp));
        }
    }

    public function get_messages($userid = null) {
        if ($userid) {
            $this->loadModel('UserMessage');

            echo json_encode(array('result' => $this->UserMessage->find('all', array('recursive' => -1,
                    'conditions' => array('user_id' => $userid),
                    'fields' => array('UserMessage.id as id', 'UserMessage.question_set_id as question_set_id',
                        'UserMessage.message_text as message_text', 'UserMessage.full_message as full_message', 'UserMessage.optional_data as optional_data')))));
        }
    }

    public function get_child_users($userid = null) {
        if ($userid) {
            $this->loadModel('User');
            /* $qs = $this->User->query(" SELECT User.id,User.user_name,User.last_name,User.first_name,count(UsersQuestionData.id) as countsurvey,count(UsersQuestionData2.id) as auditedsurvey "
              . " from pmtc_users as User "
              . " LEFT JOIN pmtc_users_question_data as UsersQuestionData on UsersQuestionData.user_id = User.id"
              . " Left JOIN pmtc_users_question_data as UsersQuestionData2 on UsersQuestionData2.user_id = User.id and UsersQuestionData2.is_audit_done='Y' "
              . " where  User.parent_id = $userid"); */
//changed by Riad as it shows only data from survey done result....
//Very good, I forgot all these dada level query you know :(
            $qs = $this->User->query(" SELECT User.user_id as id, user_name, first_name, last_name, IFNULL(countsurvey,0) as countsurvey, IFNULL(auditedsurvey,0) as auditedsurvey FROM 
(SELECT User.id as user_id,User.user_name,User.last_name,User.first_name from pmtc_users as User where  User.parent_id = $userid) User LEFT JOIN 
(SELECT user_id, count(UsersQuestionData.id) as countsurvey from pmtc_users_question_data as UsersQuestionData group by user_id ) BB 
ON BB.user_id = User.user_id LEFT JOIN
(SELECT user_id, count(UsersQuestionData.id) as auditedsurvey from pmtc_users_question_data as UsersQuestionData where is_audit_done = 'Y' group by user_id ) CC ON CC.user_id = User.user_id 
ORDER BY user_name ");
            echo json_encode($qs);
        }
    }

    public function get_child_users_survey($userid = null) {
        if ($userid) {
            $this->loadModel('QuestionSet');
            /* $qs = $this->QuestionSet->query(" SELECT qsets.id as Survey_Id, qsets.qsn_set_name, count(UsersQuestionData.id) as countsurvey,count(UsersQuestionData2.id) as auditedsurvey "
              . " from pmtc_question_sets as qsets"
              . " INNER JOIN pmtc_users_question_data as UsersQuestionData on UsersQuestionData.qsn_set_master_id = qsets.id"
              . " INNER JOIN  pmtc_users as User  on UsersQuestionData.user_id = User.id"
              . " Left JOIN pmtc_users_question_data as UsersQuestionData2 on UsersQuestionData2.qsn_set_master_id = qsets.id and UsersQuestionData2.is_audit_done='Y' "
              . " where  User.id = $userid"); */
            $qs = $this->QuestionSet->query(" SELECT Survey_Id, qsn_set_name, IFNULL(countsurvey, 0) countsurvey, IFNULL(auditedsurvey,0) auditedsurvey FROM (
				SELECT qsets.id as Survey_Id, qsets.qsn_set_name, count(UsersQuestionData.id) as countsurvey "
                    . " from pmtc_question_sets as qsets"
                    . " LEFT JOIN pmtc_users_question_data as UsersQuestionData on UsersQuestionData.qsn_set_master_id = qsets.id where UsersQuestionData.user_id = $userid GROUP BY Survey_Id "
                    . "  ) qsets "
                    . " Left JOIN ( SELECT qsn_set_master_id, count(id) as auditedsurvey FROM pmtc_users_question_data WHERE is_audit_done='Y' and user_id = $userid GROUP BY qsn_set_master_id 
					) UQ ON UQ.qsn_set_master_id = qsets.Survey_Id ");
            echo json_encode($qs);
        }
    }

    public function get_main_answers_of_user_by_Survey($user_id = null, $survey_id = null, $limit = 10, $offset = 0) {
        if ($user_id && $survey_id) {
            $this->loadModel('UsersQuestionData');
            $this->UsersQuestionData->recursive = -1;
            $qs = $this->UsersQuestionData->find('all', array('limit' => $limit, 'offset' => $offset,
                'fields' => array('UsersQuestionData.id AS user_survey_id', 'UsersQuestionData.geo_lat', 'UsersQuestionData.geo_lon', 'UsersQuestionData.insert_time',
                    'UsersQuestionData.visible_name_by_user', 'UsersQuestionData.insert_user_id', 'UsersQuestionData.is_audit_done'),
                'conditions' => array('UsersQuestionData.user_id' => $user_id, 'UsersQuestionData.qsn_set_master_id' => $survey_id)));
            echo json_encode($qs);
        } else {
            echo "No record";
        }
    }

    public function get_visible_answers_of_user($user_survey_id = null, $survey_id = null) {
        if ($survey_id && $user_survey_id) {
            $this->loadModel('QuestionAnswers');
            $this->loadModel('Question');
            $this->QuestionAnswers->recursive = -1;
            $this->Question->recursive = -1;

            /* $qs = $this->Question->find('all', array(
              'fileds' => array('Question_Answers.id AS ans_id', 'Question_Answers.qsn_answer', 'Question.qsn_desc'),
              'conditions' => array(

              'Question.qsn_set_id' => $survey_id,
              'Question.is_answer_visible' => 'Y'
              ),
              'joins' => array(
              'table' => ' pmtc_question_answers',
              'alias' => 'Question_Answers',
              'type' => 'INNER',
              'conditions' => array(
              'Question.id = Question_Answers.question_id',
              'Question_Answers.user_qsn_data_id' => $user_survey_id,
              )
              )
              )); */

            $qs = $this->Question->query(" SELECT Question.id as qsn_id, Question_Answers.id AS qsn_ans_id, Question_Answers.qsn_answer, Question.qsn_desc FROM pmtc_questions Question INNER JOIN pmtc_question_answers Question_Answers ON Question.id = Question_Answers.question_id WHERE Question_Answers.user_qsn_data_id = $user_survey_id AND Question.qsn_set_id = $survey_id AND Question.is_answer_visible ='Y' ");

            echo json_encode($qs);
        }
    }

}
