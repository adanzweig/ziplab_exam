<?php

/**
 * Created by PhpStorm.
 * User: adanjz
 * Date: 2/27/20
 * Time: 10:29 AM
 */

class Contacts extends Controller{

    public function __construct()
    {
        parent::__construct();
        if($this->router->method != 'photos') {
            if (empty($_SERVER['HTTP_AUTHORIZATION'])) {
                http_response_code(401);

                echo json_encode(array(
                    "message" => "Access denied.",
                ));
                die();
            }

            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];


            $arr = explode(" ", $authHeader);

            $jwt = $arr[1];

            if ($jwt) {

                try {

                    $decoded = \Firebase\JWT\JWT::decode($jwt, 'adanzweig', array('HS256'));

                } catch (Exception $e) {

                    http_response_code(401);

                    echo json_encode(array(
                        "message" => "Access denied.",
                        "error" => $e->getMessage()
                    ));
                    die();
                }

            }
        }
    }

    public function index(){
        $contacts = contactsModel::findAll();
        foreach($contacts as $k=>$contact){
            $contactsRet[$k] = $contact->export();
            $contactsRet[$k]['photo'] = $_SERVER['HTTP_HOST'].'/contacts/photos/'.$contactsRet[$k]['id'];
            $contactsRet[$k]['phones'] = contactsModel::getPhones($contact->id);
            $contactsRet[$k]['emails'] = contactsModel::getEmails($contact->id);
        }
        echo json_encode(['success'=>true,'data'=>$contactsRet]);
    }
    public function search($params){
        $q = $params[0] ?? 0;
        if(empty($q)){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid id"
            ));
            die();
        }
        $contacts = contactsModel::rawQuery('SELECT distinct contacts.id 
FROM contacts 
LEFT JOIN emails ON emails.contact_id = contacts.id 
LEFT JOIN phones ON phones.contact_id = contacts.id
WHERE phone LIKE "%'.htmlentities($q).'%" 
OR first_name LIKE "%'.htmlentities($q).'%" 
OR last_name LIKE "%'.htmlentities($q).'%" 
OR email LIKE "%'.htmlentities($q).'%"');
        foreach($contacts as $k=>$contact){
            $contactsRet[$k] = $contact->export();
            $contactsRet[$k]['photo'] = $_SERVER['HTTP_HOST'].'/contacts/photos/'.$contactsRet[$k]['id'];
            $contactsRet[$k]['phones'] = $contact->phones();
            $contactsRet[$k]['emails'] = $contact->emails();
        }

        echo json_encode(['success'=>true,'data'=>$contactsRet]);
    }
    public function getOne($data){
        $id = $data[0] ?? 0;
        if(empty($id)){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid id"
            ));
            die();
        }
        $contact = contactsModel::findOne('id = ?',[$id]);

        if(empty($contact)){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid id"
            ));
            die();
        }
        $contactRet = $contact->export();
        $contactRet['photo'] = $_SERVER['HTTP_HOST'].'/contacts/photos/'.$contact->id;
        $contactRet['phones'] = $contact->phones();
        $contactRet['emails'] = $contact->emails();
        echo json_encode(['success'=>true,'data'=>$contactRet]);
    }


    public function create(){
        $data = $this->request;
        if(empty($data) || empty($data['first_name']) || empty($data['last_name'])){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid data"
            ));
            die();
        }
        $contact = new contactsModel();
        $contact->object->first_name = $data['first_name']??'';
        $contact->object->last_name = $data['last_name']??'';
        $contact->object->photo = $data['image'] ?? '' ;
        $contact->save();
        if(!empty($data['phones'])){
            foreach($data['phones'] as $phoneNumber){
                $phone = new PhonesModel();
                $phone->object->phone = $phoneNumber;
                $phone->object->contact_id = $contact->object->id;
                $phone->save();
            }
        }
        if(!empty($data['emails'])){
            foreach($data['emails'] as $emails){
                $email = new emailsModel();
                $email->object->email = $emails;
                $email->object->contact_id = $contact->object->id;
                $email->save();
            }
        }
        echo json_encode(['success'=>true,'message'=>'Contact has been created']);
    }
    public function photos($params){

        $id = $params[0] ?? 0;
        $data = $this->request;
        if(empty($id)){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid id"
            ));
            die();
        }
        $contact = new contactsModel($id);
        if(empty($contact)){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid id"
            ));
            die();
        }
        if(empty($contact->object->photo)){
            echo json_encode(array(
                "success" => false,
                "error" => "There is no photo for contact"
            ));
            die();
        }
        echo '<img src="' . $contact->object->photo . '" />';
    }
    public function update($params){

        $id = $params[0] ?? 0;
        if(empty($id)){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid id"
            ));
            die();
        }

        $contact = new contactsModel($id);
        if(empty($contact)){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid id"
            ));
            die();
        }
        $data = $this->request;
        if(empty($data) || empty($data['first_name']) || empty($data['last_name'])){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid data"
            ));
            die();
        }
        $contact->object->first_name = $data['first_name']??'';
        $contact->object->last_name = $data['last_name']??'';
        $contact->object->photo = $data['image'] ?? '' ;
        $contact->save();
        echo json_encode(['success'=>true,'message'=>'Contact have been updated']);
    }
    public function addPE($params){
        $id = $params[0] ?? 0;
        if(empty($id)){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid id"
            ));
            die();
        }
        $data = $this->request;
        if(!empty($data['phones'])){
            foreach($data['phones'] as $phoneNumber){
                $phone = new phonesModel();
                $phone->object->phone = $phoneNumber;
                $phone->object->contact_id = $id;
                $phone->save();

            }
        }
        if(!empty($data['emails'])){
            foreach($data['emails'] as $emails){
                $email = new emailsModel();
                $email->object->email = $emails;
                $email->object->contact_id = $id;
                $email->save();
            }
        }
        echo json_encode(['success'=>true,'message'=>'Contact has been edited']);
    }
    public function delete($params){
        $id = $params[0] ?? 0;
        if(empty($id)){
            echo json_encode(array(
                "success" => false,
                "error" => "Invalid id"
            ));
            die();
        }


        $phones = phonesModel::find('contact_id = ?',[$id]);
        R::trashAll($phones);

        $emails = emailsModel::find('contact_id = ?',[$id]);
        R::trashAll($emails);

        $contact = new contactsModel($id);
        $contact->delete();

        echo json_encode(['success'=>true,'message'=>'Contact has been deleted']);
    }

}