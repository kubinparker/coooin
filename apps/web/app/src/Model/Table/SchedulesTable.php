<?php 
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SchedulesTable extends AppTable {

    // テーブルの初期値を設定する
    public $defaultValues = [
        "id" => null,
        'is_all_day' => 1
    ];

    public $attaches = array('images' =>
                            array(),
                            'files' => array(),
                            );

                            // 
    public function initialize(array $config) : void
    {
        
        parent::initialize($config);
    }

    // Validation
    public function validationDefault(Validator $validator) : Validator
    {

        
        return $validator;
    }
}