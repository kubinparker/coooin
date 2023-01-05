<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class LoginForm extends AppForm
{
    protected function _buildSchema(Schema $schema): Schema
    {
        return $schema
            ->addField('username', 'string')
            ->addField('password', 'string')
            ;
    }

    public function validationDefault(Validator $validator): Validator
    {
//        $validator->setProvider('App', 'App\Validator\AppValidation');


        return $validator;
    }

}
