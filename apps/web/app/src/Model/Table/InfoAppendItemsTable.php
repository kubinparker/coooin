<?php 
namespace App\Model\Table;

use App\Model\Entity\AppendItem;
use Cake\ORM\Table;
use Cake\Database\Query;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;

class InfoAppendItemsTable extends AppTable {

    // テーブルの初期値を設定する
    public $defaultValues = [
        "id" => null,
    ];

    public $attaches = array('images' =>array(
                                'image' => array('extensions' => array('jpg', 'jpeg', 'gif', 'png'),
                                'width' => 1920,
                                'height' => 1920,
                                'file_name' => 'append_img_%d_%s',
                                'thumbnails' => array(
                                    's' => array(
                                        'prefix' => 's_',
                                        'width' => 320,
                                        'height' => 240
                                        )
                                    ),
                                )
                            ),
                            'files' => array(
                                'file' => array(
                                    'extensions' => array('pdf'),
                                    'file_name' => 'ap_file_%d_%s',
                                    'prefix' => 'n3'
                                    )
                                ),
                            );


                            // 
    public function initialize(array $config) : void
    {

        $this->addBehavior('FileAttache');

        $this->belongsTo('AppendItems')
             ->setDependent(true);
        $this->belongsTo('Infos')
             ->setDependent(true);

        parent::initialize($config);
        
    }
    // Validation
    public function validationDefault(Validator $validator): Validator
    {

        // $validator
        //     ->allowEmpty('is_required');
        
        return $validator;
    }

    public function checkKana($value) {
        if(preg_match("/^[ァ-ヾ0-9０-９ー、。 　]+$/u",$value)){
            return true;
        }else{
            return false;
        }
    }
    public function beforeMarshal(EventInterface $event, \ArrayObject $data, $options)
    {
        if ($data->offsetExists('_multiple')) {
            $data['value_int'] = $this->optSum('_multiple', $data, 0, true);
        }
        if (empty($data->value_datetime)) {
            $data['value_datetime'] = DATETIME_ZERO;
        }
        if (empty($data->value_date)) {
            $data['value_date'] = DATE_ZERO;
        }
    }
    public function findMyFormat(Query $query, $options = [])
    {
        $options = array_merge([], $options);

        return $query->formatResults(function ($data) use ($options) {
            $data->each(function ($row) use ($options) {
                if ($row->append_item->value_type == AppendItem::TYPE_CHECK && !empty($row->append_item->mst_list_slug)) {
                    $row->_multiple = $this->_getMultiples($row->value_int, 4);
                }

            });
            return $data;
        });
    }

        
}