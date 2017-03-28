<?php

/**
 * This is the model class for table "dom_statisztika_cache".
 *
 * The followings are the available columns in table 'dom_statisztika_cache':
 * @property integer $id
 * @property string $statisztika_nev
 * @property string $datum_mettol
 * @property string $datum_meddig
 * @property string $parameterek
 * @property string $eredmeny
 * @property integer $torolt
 */
class StatisztikaCache extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dom_statisztika_cache';
    }

    public function getClassName ()
    {
        return "Statisztika cache";
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('statisztika_nev, eredmeny', 'required'),
            array('torolt', 'numerical', 'integerOnly'=>true),
            array('id, statisztika_nev, datum_mettol, datum_meddig, parameterek, torolt', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    public function behaviors() {
        return array( 'LoggableBehavior'=> 'application.modules.auditTrail.behaviors.LoggableBehavior', );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        //
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('statisztika_nev',$this->statisztika_nev, true);
        $criteria->compare('parameterek',$this->parameterek, true);
        $criteria->compare('datum_mettol',$this->datum_mettol, true);
        $criteria->compare('datum_meddig',$this->datum_meddig, true);

        // LI: logikailag törölt sorok ne jelenjenek meg
        if (!Yii::app()->user->checkAccess('Admin'))
            $criteria->compare('torolt', 0, false);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Cegformak the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
