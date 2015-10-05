<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
    <div class="container" id="menu_container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
     
          <a class="brand" href=""> <?php echo Yii::app()->name; ?> </a>
          
          <div class="nav-collapse">
			<?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'pull-right nav'),
                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
					'itemCssClass'=>'item-test',
                    'encodeLabel'=>false,
                    'items'=>array (
                        array ('label'=>'Termékek <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array (
                            array ('label'=>'Termékek listája', 'url'=> Yii::app()->createUrl('/termekek/index'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Admin')),
							array ('label'=>'Termék rendelése / beszállítása <span class="caret"></span>', 'url'=> Yii::app()->createUrl('#'), 'itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 'visible'=>Yii::app()->user->checkAccess('Admin'),
								'items'=>array (
										array ('label'=>'Termék megrendelés', 'url'=> Yii::app()->createUrl('/anyagrendelesek/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
										array ('label'=>'Beszállítás', 'url'=> Yii::app()->createUrl('/anyagbeszallitasok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
										array ('label'=>'Raktár eltéréslista', 'url'=> Yii::app()->createUrl('/raktareltereslista/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
									)
							),
                            array ('label'=>'Termékek árazása', 'url'=> Yii::app()->createUrl('/termekarak/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
                            array ('label'=>'Nyomási árak', 'url'=> Yii::app()->createUrl('/nyomasiarak/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
							array ('label'=>'Nyomási termékárak %', 'url'=> Yii::app()->createUrl('/nyomasiarakszazalek/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
                            array ('label'=>'Raktárkészletek', 'url'=> Yii::app()->createUrl('/raktartermekek/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
                            array ('label'=>'ZUH beállítások', 'url'=> Yii::app()->createUrl('#'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
							array ('label'=>'Áruházak', 'url'=> Yii::app()->createUrl('/aruhazak/index'),),
                            array ('label'=>'Gyártók', 'url'=> Yii::app()->createUrl('/gyartok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
		                    		array ('label'=>'Termék beállítások <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 
		                        'items'=>array (
	                            	array ('label'=>'Ablakhelyek', 'url'=> Yii::app()->createUrl('/termekablakhelyek/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Ablakméretek', 'url'=> Yii::app()->createUrl('/termekablakmeretek/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Papírtípusok', 'url'=> Yii::app()->createUrl('/papirtipusok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Termékméretek', 'url'=> Yii::app()->createUrl('/termekmeretek/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Zárásmódok', 'url'=> Yii::app()->createUrl('/termekzarasimodok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
															))	                          
                        ), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('Admin') || Yii::app()->user->checkAccess('Termekek.index')) ),

/*						array ('label'=>'Árajánlatok', 'url'=> Yii::app()->createUrl('/arajanlatok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),*/

                        array ('label'=>'Árajánlatok <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array (
                            array ('label'=>'Árajánlatok kezelése', 'url'=> Yii::app()->createUrl('/arajanlatok/index'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Arajanlatok.index')),
                            array ('label'=>'Visszahívásaim', 'url'=> Yii::app()->createUrl('/arajanlatok/visszahivasok'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Arajanlatok.index')),
                        ), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('Admin') || Yii::app()->user->checkAccess('Arajanlatok.index')) ),

						array ('label'=>'Megrendelések', 'url'=> Yii::app()->createUrl('/megrendelesek/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
						array ('label'=>'Nyomdakönyv', 'url'=> Yii::app()->createUrl('/nyomdakonyv/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
                        array ('label'=>'Ügyfelek <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array (
                            array ('label'=>'Ügyfelek kezelése', 'url'=> Yii::app()->createUrl('/ugyfelek/index'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Ugyfelek.index')),
                        ), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('Admin') || Yii::app()->user->checkAccess('Ugyfelek.index')) ),

                        array ('label'=>'Általános beállítások <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array (
									array ('label'=>'ÁFA kulcsok', 'url'=> Yii::app()->createUrl('/afakulcsok/index'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('AfaKulcsok.index')),
									array ('label'=>'Sztornózás okok', 'url'=> Yii::app()->createUrl('/sztornozasOkok/index'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('SztornozasOkok.index')),
									array ('label'=>'Nyomdai beállítások <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 
		                        'items'=>array (
	                            	array ('label'=>'Nyomdagépek kezelése', 'url'=> Yii::app()->createUrl('/nyomdagepek/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Nyomdagép típusok kezelése', 'url'=> Yii::app()->createUrl('/nyomdageptipusok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Műveletek kezelése', 'url'=> Yii::app()->createUrl('/nyomdaMuveletek/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
															)),	                                                                          
		                    		array ('label'=>'Ügyfelekkel kapcsolatos beállítások <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 
		                        'items'=>array (
	                            	array ('label'=>'Országok kezelése', 'url'=> Yii::app()->createUrl('/orszagok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Városok kezelése', 'url'=> Yii::app()->createUrl('/varosok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Cégformák kezelése', 'url'=> Yii::app()->createUrl('/cegformak/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Adatforrások kezelése', 'url'=> Yii::app()->createUrl('/adatforrasok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Besorolások kezelése', 'url'=> Yii::app()->createUrl('/besorolasok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Árkategóriák kezelése', 'url'=> Yii::app()->createUrl('/arkategoriak/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Fizetési morálok kezelése', 'url'=> Yii::app()->createUrl('/fizetesiMoralok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
																array ('label'=>'Egyéb beállítások', 'url'=> Yii::app()->createUrl('/ugyfelekEgyebBeallitasok/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
															)),	                                                                          
		                    		array ('label'=>'Raktárkezeléssel kapcsolatos beállítások <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 
		                        'items'=>array (
	                            	array ('label'=>'Raktárak kezelése', 'url'=> Yii::app()->createUrl('/raktarak/index'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
															))	                                                                          
                        ), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('Admin') || Yii::app()->user->checkAccess('Beallitasok.index')) ),


                        array ('label'=>'Adminisztráció <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array (
                            array ('label'=>'Felhasználók', 'url'=> Yii::app()->createUrl('/user/index'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('User.index')),
                            array ('label'=>'Szerepkörök', 'url'=> Yii::app()->createUrl('/rights/authItem/roles'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
                            array ('label'=>'Szerepkörök kiosztása', 'url'=> Yii::app()->createUrl('/rights'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
							array ('label'=>'Jogosultságok kiosztása', 'url'=> Yii::app()->createUrl('/rights/authItem'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
                            array ('label'=>'Napló', 'url'=> Yii::app()->createUrl('/auditTrail/admin'), 'visible'=>Yii::app()->user->checkAccess('Admin')),
                        ), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('Admin') || Yii::app()->user->checkAccess('User.index')) ),
                        array ('label'=>'Belépés', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                        array ('label'=>'Kijelentkezés ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    ),
                )); ?>
    	</div>
    </div>
	</div>
</div>

<div class="subnav navbar navbar-fixed-top">
    <div class="navbar-inner">
    	<div class="container">

    	</div><!-- container -->
    </div><!-- navbar-inner -->
</div><!-- subnav -->
