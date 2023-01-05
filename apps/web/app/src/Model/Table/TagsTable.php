<?php 
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TagsTable extends AppTable {

    // テーブルの初期値を設定する
    public $defaultValues = [
        "id" => null,
        "position" => 0
    ];

    public $attaches = array('images' =>
                            array(),
                            'files' => array(),
                            );

                            // 
    public function initialize(array $config) : void
    {
        $this->addBehavior('Position', [
            'group' => ['page_config_id'],
            'order' => 'DESC'
        ]);

        $this->hasMany('InfoTags');

        parent::initialize($config);
        
    }
    // Validation
    public function validationDefault(Validator $validator): Validator
    {


        $validator
            ->notEmpty('tag', '入力してください')
            // ->add('title', 'maxLength', [
            //     'rule' => ['maxLength', 100],
            //     'message' => __('100字以内で入力してください')
            // ])
            ;
        
        return $validator;
    }
}