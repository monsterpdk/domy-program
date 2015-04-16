<?php
	// LI: ezzel 'real-time' lekérdezhető egy modelből egy adott ENUM típusú mező értékkészlete
	class DHtml extends CHtml
	{
			public static function enumItem ($model, $attribute)
			{
					$attr=$attribute;
					preg_match('/\((.*)\)/', $model->tableSchema->columns[$attr]->dbType, $matches);
					foreach(explode(',', $matches[1]) as $value)
					{
						$value=str_replace("'", null, $value);
						$values[$value]=Yii::t('enumItem', $value);
					}
					
					// rendezzük az eredményhalmazt, mert az adatbázisban nem feltétlen abc szerint vannak az enum értékei
					sort($values);
					
					// ha csak az értékeket tároljuk a tömbben, akkor a HTML Select így fog felépülni:
					// 0 => 'érték 1',
					// 1 => 'érték 2', stb...
					// így viszont mikor egy létező rekordot nyitunk meg nem tudja a már mentett ENUM értéket SELECTED-re állítani,
					// mivel a listában egész számok vannak kulcsként, amit nem tud párosítani az értékkel, így csinálunk egy ilyen listát:
					// 'érték 1' => 'érték 1',
					// 'érték 2' => 'érték 2'. stb...
					$values=array_combine($values,$values);
					
					return $values;
			}  

		   public static function enumDropDownList ($model, $attribute, $htmlOptions=array())
		   {
				return CHtml::activeDropDownList( $model, $attribute, self::enumItem($model,  $attribute), $htmlOptions);
		   }

	}
?>