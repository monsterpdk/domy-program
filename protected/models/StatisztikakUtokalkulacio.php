<?php

/**
 * Utókalkuláció statisztika 'kereső' modelje.
 */
class StatisztikakUtokalkulacio extends CFormModel
{
    public $megrendeles_tipus;      //Lehet eladas, illetve nyomas
    public $statisztika_mettol;
    public $statisztika_meddig;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('statisztika_mettol, statisztika_meddig, megrendeles_tipus', 'required'),
            array('statisztika_meddig', 'checkDates'),
        );
    }

    // a végdátum nagyobb kell legyen, mint a kezdődátum
    public function checkDates($attribute,$params)
    {
        if ($this->statisztika_mettol != null && $this->statisztika_meddig != null) {
            if (!($this->statisztika_mettol <= $this->statisztika_meddig))
                $this->addError('statisztika_mettol', 'A végdátum nagyobb kell legyen, mint a kezdődátum.');
        }
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'statisztika_mettol' => 'Mettől:',
            'statisztika_meddig' => 'Meddig:',
            'megrendeles_tipus' => 'Megrendelés típus',
        );
    }
    public function save() {
        return true;
    }

}