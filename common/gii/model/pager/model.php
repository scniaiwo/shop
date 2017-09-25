<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($tableSchema->columns as $column): ?>
 * @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . "\n" ?>
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . ",\n        " ?>];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * @inheritdoc
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
    /**
    * Finds by the given ID.
    *
    * @param string|int $id the ID to be looked for
    * @return  <?= $className ?> || null.
    */
    public static function findById($id)
    {
         return static::findOne(['id' => $id]);
    }
    /**
    * Create a new <?= $className ?>.
    *
    * @param $args
    * @return  <?= $className ?> || null.
    */
    public static function create($args){
        $model = new <?= $className;?>();
        $model->attributes = $args;
<?php foreach ($tableSchema->columns as $column):?>
    <?php if($column->name == 'created_at'  || $column->name == 'updated_at' ):?>
        $model-><?=$column->name;?> = date('Y-m-d H:i:s');
    <?php endif?>
<?php endforeach; ?>
        $model->save();
        return $model;
    }
    /**
    * Update  by the given ID.
    *
    * @param $id
    * @param $data
    * @return bool.
    */
    public static function updateById($id,$data){
        $model = static::findById($id);
        if ($model && $model->load($data) && $model->save()) {
            return  true;
        }
        return false;
    }

    /**
    * Delete  by the given ID.
    *
    * @param $id
    * @return bool.
    */
    public static function deleteById($id){
    $model = static::findById($id);
    if ( $model &&  $model->delete() === 1) {
         return  true;
    }
        return false;
    }
    /**
    * Update  by the model.
    *
    * @param $model
    * @param $args
    * @return <?= $className ?>.
    */
    public static function updateByModel($model,$args){
        $model->attributes = $args;
<?php foreach ($tableSchema->columns as $column):?>
    <?php if($column->name == 'updated_at' ):?>
        $model-><?=$column->name;?> = date('Y-m-d H:i:s');
    <?php endif?>
<?php endforeach; ?>
        $model->save();
        return $model;
    }

    /**
    * Delete <?= $className ?> by give IDs
    *
    * @param $ids
    * @return int
    */
    public static function deleteByIDs($ids){
        $numOfDelete =  static::deleteAll(['id'=>$ids]);
        return count($ids) == $numOfDelete ? true:false;
    }
    /**
    * Get Operations
    *
    * @return array.
    */
    public static function getOperations(){
        return [
            'add'     => [
                'url'    => '',
                'width'  => 1000,
                'height' => 580
            ],
            'delete'  => [
                 'url'    => '',
            ],
            'edit'    => [
                'url'    => '',
                'width'  => 1000,
                'height' => 580
            ],
        ];
    }

        /**
        * Get table fields
        *
        * @return array.
        */
        public static function getTableFields(){
            return [
<?php foreach ($tableSchema->columns as $column):?>
                     [
                        'name'          =>  '<?= $column->name;?>',
                        'orderField'    =>  true,
                        'label'         =>  '<?= $column->comment ;?>' ,
                        'width'         =>  10 ,
                        'align'         =>  'left' ,
<?php $searchType = \helpers\CPager::getSearchType($column->type);?>
<?php  if($searchType == 'select'):?>
                        'values'         =>[
                        ]
<?php endif?>
                     ],
<?php endforeach; ?>
            ];
        }

        /**
        * Get search fields
        *
        * @return array.
        */
        public static function getSearchFields(){
            return [
<?php foreach ($tableSchema->columns as $column): ?>
<?php $searchType = \helpers\CPager::getSearchType($column->type);?>
                    [
                        'type'         =>  '<?= $searchType;?>',
                        'title'        =>  '<?= $column->comment ;?>',
                        'name'         =>  '<?= $column->name ;?>' ,
                        'columns_type' =>  '<?= \helpers\CPager::getSearchColumnType($column->type) ;?>',
<?php  if( in_array( $searchType,['select','dateRange'])):?>
                        'values'       =>[
                        ]
<?php endif?>
                     ],
<?php endforeach; ?>
            ];
      }


        /**
        * Get edit fields
        *
        * @return array.
        */
        public static function getEditFields(){
            return [
<?php foreach ($tableSchema->columns as $column): ?>
<?php $searchType = \helpers\CPager::getSearchType($column->type);?>
                    [
                        'type'         =>  '<?= $searchType;?>',
                        'label'        =>  '<?= $column->comment ;?>',
                        'name'         =>  '<?= $column->name ;?>' ,
<?php  if( in_array( $searchType,['select','dateRange'])):?>
                        'values'       =>[
                         ]
<?php endif?>
                    ],
<?php endforeach; ?>
           ];
        }

        /**
        * Get create fields
        *
        * @return array.
        */
        public static function getCreateFields(){
            return [
<?php foreach ($tableSchema->columns as $column): ?>
<?php $searchType = \helpers\CPager::getSearchType($column->type);?>
                    [
                    'type'         =>  '<?= $searchType;?>',
                    'label'        =>  '<?= $column->comment ;?>',
                    'name'         =>  '<?= $column->name ;?>' ,
<?php  if( in_array( $searchType,['select','dateRange'])):?>
                    'values'       =>[
                    ]
<?php endif?>
                   ],
<?php endforeach; ?>
             ];
        }
}
