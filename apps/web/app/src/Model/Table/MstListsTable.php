<?php 
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class MstListsTable extends AppTable {


    // テーブルの初期値を設定する
    public $defaultValues = [
        "id" => null,
        'position' => 0
    ];

    public $attaches = array('images' =>
                            array(),
                            'files' => array(),
                            );
    
    // 
    public function initialize(array $config) : void
    {
        // 添付ファイル
//        $this->addBehavior('FileAttache');

        $this->addBehavior('Position', [
                'group' => ['sys_cd', 'slug'],
                'groupMove' => true,
                'order' => 'DESC'
            ]);

        parent::initialize($config);

    }
    // Validation
    public function validationDefault(Validator $validator) : Validator
    {
        $validator->setProvider('App', 'App\Validator\AppValidation');
        $validator
            ->notEmpty('name','リスト名を入力してください')

            ->notEmpty('slug', '識別子を入力してください')
//            ->add('slug', 'isUnique', ['rule' => ['isUnique'], 'provider' => 'App', 'message' => 'この単語は既に使用されています'])

            ->notEmpty('ltrl_val', '入力してください')
            ->notEmpty('ltrl_cd', '入力してください')
        ;
        return $validator;
    }

    static public function getList($slug)
    {
        $list = [];
        $obj = new MstListsTable();
        $mst_lists = $obj->find('list', ['keyField' => 'ltrl_cd', 'valueField' => 'ltrl_val'])->where(['MstLists.slug' => $slug])->order(['MstLists.position' => 'ASC'])->all();
        if (!$mst_lists->isEmpty()) {
            $list = $mst_lists->toArray();
        }

        return $list;
    }

    /**
     * @param $slugs
     * @return void
     * ['slug名', 'slug名]
     * ['エイリアス' => 'slug名]
     */
    static public function getLists($slugs = [])
    {
        $lists = [];

        foreach ($slugs as $alias => $slug) {
            if (is_numeric($alias)) {
                $alias = $slug;
            }
            $lists[$alias] = self::getList($slug);
        }

        return $lists;
    }
}