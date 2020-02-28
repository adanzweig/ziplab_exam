<?php

/**
 * Created by PhpStorm.
 * User: adanjz
 * Date: 2/27/20
 * Time: 10:31 AM
 */
class contactsModel extends Model
{
    public static $table = 'contacts';

    public static function getPhones($id){
        $contactsRet = [];
        $phones = phonesModel::find('contact_id = ?',[$id]);
        foreach($phones as $phone){
            $contactsRet[] = $phone->phone;
        }

        return $contactsRet;
    }
    public static function getEmails($id){
        $contactsRet = [];
        $emails = emailsModel::find('contact_id = ?',[$id]);
        foreach($emails as $email){
            $contactsRet[] = $email->email;
        }
        return $contactsRet;
    }
}