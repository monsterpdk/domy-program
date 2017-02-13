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
                            array ('label'=>'Termékek listája', 'url'=> Yii::app()->createUrl('/termekek/index'), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin')|| Yii::app()->user->checkAccess('Menu.Termekek.TermekekListaja')) ),
							array ('label'=>'Termék rendelése / beszállítása <span class="caret"></span>', 'url'=> Yii::app()->createUrl('#'), 'itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekRendeleseBeszallitasa'),
								'items'=>array (
										array ('label'=>'Termék megrendelés', 'url'=> Yii::app()->createUrl('/anyagrendelesek/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekRendeleseBeszallitasa.TermekMegrendeles')),
										array ('label'=>'Beszállítás', 'url'=> Yii::app()->createUrl('/anyagbeszallitasok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekRendeleseBeszallitasa.Beszallitas')),
										array ('label'=>'Raktár eltéréslista', 'url'=> Yii::app()->createUrl('/raktareltereslista/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekRendeleseBeszallitasa.RaktarElteresLista')),
									)
							),
                            array ('label'=>'Termékek árazása', 'url'=> Yii::app()->createUrl('/termekarak/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekekArazasa')),
                            array ('label'=>'Nyomási árak', 'url'=> Yii::app()->createUrl('/nyomasiarak/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.NyomasiArak')),
//							array ('label'=>'Nyomási termékárak %', 'url'=> Yii::app()->createUrl('/nyomasiarakszazalek/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.NyomasiTermekarak')),
							array ('label'=>'Raktárkezelés <span class="caret"></span>', 'url'=> Yii::app()->createUrl('#'), 'itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekRendeleseBeszallitasa'),
								'items'=>array (
										array ('label'=>'Raktárkészletek', 'url'=> Yii::app()->createUrl('/raktartermekek/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.RaktarKezeles.RaktarKeszletek')),
										array ('label'=>'Kiadás', 'url'=> Yii::app()->createUrl('/raktarKiadasok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.RaktarKezeles.RaktarKiadasok')),
									)
							),
                            array ('label'=>'ZUH beállítások', 'url'=> Yii::app()->createUrl('/zuh/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.ZUHBeallitasok')),
							array ('label'=>'Áruházak', 'url'=> Yii::app()->createUrl('/aruhazak/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.Aruhazak')),
                            array ('label'=>'Gyártók', 'url'=> Yii::app()->createUrl('/gyartok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.Gyartok')),
		                    		array ('label'=>'Termék beállítások <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 
		                        'items'=>array (
	                            	array ('label'=>'Ablakhelyek', 'url'=> Yii::app()->createUrl('/termekablakhelyek/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekBeallitasok.Ablakhelyek')),
																array ('label'=>'Ablakméretek', 'url'=> Yii::app()->createUrl('/termekablakmeretek/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekBeallitasok.Ablakmeretek')),
																array ('label'=>'Papírtípusok', 'url'=> Yii::app()->createUrl('/papirtipusok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekBeallitasok.Papirtipusok')),
																array ('label'=>'Termékméretek', 'url'=> Yii::app()->createUrl('/termekmeretek/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekBeallitasok.Termekmeretek')),
																array ('label'=>'Termékcsoportok', 'url'=> Yii::app()->createUrl('/termekcsoportok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekBeallitasok.Termekcsoportok')),
																array ('label'=>'Zárásmódok', 'url'=> Yii::app()->createUrl('/termekzarasimodok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekBeallitasok.Zarasmodok')),
															),  'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek.TermekBeallitasok'))	                          
                        ), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Termekek')) ),

/*						array ('label'=>'Árajánlatok', 'url'=> Yii::app()->createUrl('/arajanlatok/index'), 'visible'=>Yii::app()->user->checkAccess('admin')),*/

                        array ('label'=>'Árajánlatok <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array (
                            array ('label'=>'Árajánlatok kezelése', 'url'=> Yii::app()->createUrl('/arajanlatok/index'), 'visible' => Yii::app()->user->checkAccess('admin') || !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Menu.Arajanlatok.ArajanlatokKezelese')),
                            array ('label'=>'Visszahívásaim', 'url'=> Yii::app()->createUrl('/arajanlatok/visszahivasok'), 'visible' => Yii::app()->user->checkAccess('admin') || !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Menu.Arajanlatok.Visszahivasaim')),
                        ), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Arajanlatok')) ),

						array ('label'=>'Megrendelések', 'url'=> Yii::app()->createUrl('/megrendelesek/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Megrendelesek')),
                        array ('label'=>'Nyomdakönyv <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array (
                            array ('label'=>'Nyomdakönyv kezelése', 'url'=> Yii::app()->createUrl('/nyomdakonyv/index'), 'visible' => Yii::app()->user->checkAccess('admin') || !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Menu.Nyomdakonyv.NyomdakonyvKezelese')),
                            array ('label'=>'Nyomdakönyv ütemezés lista', 'url'=> Yii::app()->createUrl('/nyomdakonyv/utemezes'), 'visible' => Yii::app()->user->checkAccess('admin') || !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Menu.Nyomdakonyv.NyomdakonyvUtemezes')),
                        ), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Nyomdakonyv')) ),

                        array ('label'=>'Statisztikák <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array (
                            array ('label'=>'Napi kombinált statisztika', 'url'=> Yii::app()->createUrl('/statisztikak/NapiKombinaltStatisztika'), 'visible' => Yii::app()->user->checkAccess('admin') || !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Menu.Statisztikak.NapiKombinaltStatisztika')),
                            array ('label'=>'Sztornózott megrendelések', 'url'=> Yii::app()->createUrl('/statisztikak/SztornozottMegrendelesek'), 'visible' => Yii::app()->user->checkAccess('admin') || !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Menu.Statisztikak.SztornozottMegrendelesek')),
                        ), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Statisztikak')) ),
                        
                        array ('label'=>'Ügyfelek <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array (
                            array ('label'=>'Ügyfelek kezelése', 'url'=> Yii::app()->createUrl('/ugyfelek/index'), 'visible' => Yii::app()->user->checkAccess('admin') || !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Menu.Ugyfelek.UgyfelekKezelese')),
                        ), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Ugyfelek')) ),

                        array ('label'=>'Általános beállítások <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array (
									array ('label'=>'Általános beállítások', 'url'=> Yii::app()->createUrl('/altalanosBeallitasok/index'), 'visible' => Yii::app()->user->checkAccess('admin') || !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.AltalanosBeallitasok') || Yii::app()->user->checkAccess('admin'))),						
									array ('label'=>'ÁFA kulcsok', 'url'=> Yii::app()->createUrl('/afakulcsok/index'), 'visible' => Yii::app()->user->checkAccess('admin') || !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.AfaKulcsok') || Yii::app()->user->checkAccess('admin'))),
									array ('label'=>'E-mail beállítások', 'url'=> Yii::app()->createUrl('/emailBeallitasok/index'), 'visible' => Yii::app()->user->checkAccess('admin') || !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.EmailBeallitasok') || Yii::app()->user->checkAccess('admin'))),
									array ('label'=>'Sztornózás okok', 'url'=> Yii::app()->createUrl('/sztornozasOkok/index'), 'visible' => Yii::app()->user->checkAccess('admin') || !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.SztornozasiOkok')) ),
									array ('label'=>'Nyomdai beállítások <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 
		                        'items'=>array (
	                            	array ('label'=>'Nyomdagépek kezelése', 'url'=> Yii::app()->createUrl('/nyomdagepek/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.NyomdaiBeallitasok.NyomdagepekKezelese')),
																array ('label'=>'Nyomdagép típusok kezelése', 'url'=> Yii::app()->createUrl('/nyomdageptipusok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.NyomdaiBeallitasok.NyomdagepTipusokKezelese')),
																array ('label'=>'Műveletek kezelése', 'url'=> Yii::app()->createUrl('/nyomdaMuveletek/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.NyomdaiBeallitasok.MuveletekKezelese')),
																array ('label'=>'Munkatípusok kezelése', 'url'=> Yii::app()->createUrl('/nyomdaMunkatipusok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.NyomdaiBeallitasok.MunkatipusokKezelese')),
																array ('label'=>'Művelet árak kezelése', 'url'=> Yii::app()->createUrl('/nyomdaMuveletNormaarak/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.NyomdaiBeallitasok.MuveletArakKezelese')),
																array ('label'=>'Nyomdakönyvi beállítások', 'url'=> Yii::app()->createUrl('/nyomdakonyvBeallitasok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.NyomdaiBeallitasok.NyomdakonyviBeallitasok')),
																array ('label'=>'Panton színkódok', 'url'=> Yii::app()->createUrl('/pantonSzinkodok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.NyomdaiBeallitasok.PantonSzinkodok')),
															), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.NyomdaiBeallitasok')) ),	                                                                          
		                    		array ('label'=>'Ügyfelekkel kapcsolatos beállítások <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 
		                        'items'=>array (
	                            	array ('label'=>'Országok kezelése', 'url'=> Yii::app()->createUrl('/orszagok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.UgyfelekkelKapcsolatosBeallitasok.OrszagokKezelese')),
																array ('label'=>'Városok kezelése', 'url'=> Yii::app()->createUrl('/varosok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.UgyfelekkelKapcsolatosBeallitasok.VarosokKezelese')),
																array ('label'=>'Cégformák kezelése', 'url'=> Yii::app()->createUrl('/cegformak/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.UgyfelekkelKapcsolatosBeallitasok.CegformakKezelese')),
																array ('label'=>'Adatforrások kezelése', 'url'=> Yii::app()->createUrl('/adatforrasok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.UgyfelekkelKapcsolatosBeallitasok.AdatforrasokKezelese')),
																array ('label'=>'Besorolások kezelése', 'url'=> Yii::app()->createUrl('/besorolasok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.UgyfelekkelKapcsolatosBeallitasok.BesorolasokKezelese')),
																array ('label'=>'Árkategóriák kezelése', 'url'=> Yii::app()->createUrl('/arkategoriak/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.UgyfelekkelKapcsolatosBeallitasok.ArkategoriakKezelese')),
																array ('label'=>'Fizetési morálok kezelése', 'url'=> Yii::app()->createUrl('/fizetesiMoralok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.UgyfelekkelKapcsolatosBeallitasok.FizetesiMoralokKezelese')),
																array ('label'=>'Egyéb beállítások', 'url'=> Yii::app()->createUrl('/ugyfelekEgyebBeallitasok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.UgyfelekkelKapcsolatosBeallitasok.EgyebBeallitasok')),
															), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.UgyfelekkelKapcsolatosBeallitasok')) 
															),	                                                                          
		                    		array ('label'=>'Raktárkezeléssel kapcsolatos beállítások <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 
		                        'items'=>array (
	                            	array ('label'=>'Raktárak kezelése', 'url'=> Yii::app()->createUrl('/raktarak/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.RaktarkezelesselKapcsolatosBeallitasok.RaktarakKezelese')),
															), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.RaktarkezelesselKapcsolatosBeallitasok')) ),	                                                                          
															
		                    		array ('label'=>'Számlázás beállítások <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'almenu-jobbra','tabindex'=>"-1"), 
		                        'items'=>array (
	                            	array ('label'=>'Alapértelmezett beállítások', 'url'=> Yii::app()->createUrl('/szamlazoBeallitasok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.SzamlazasBeallitasok.AlapertelmezettBeallitasok')),
	                            	array ('label'=>'Fizetési módok', 'url'=> Yii::app()->createUrl('/fizetesiModok/index'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.SzamlazasBeallitasok.FizetesiModok')),
															), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.SzamlazasBeallitasok'))),
									array ('label'=>'Nyomtató beállítások', 'url'=> Yii::app()->createUrl('/nyomtatoBeallitasok/index'), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.NyomtatoBeallitasok') || Yii::app()->user->checkAccess('admin'))),
									array ('label'=>'Nyomtatványok', 'url'=> Yii::app()->createUrl('/nyomtatvanyok/index'), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok.Nyomtatvanyok') || Yii::app()->user->checkAccess('admin'))),
							), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.AltalanosBeallitasok')) ),
                        array ('label'=>'Adminisztráció <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                        'items'=>array (
                            array ('label'=>'Felhasználók', 'url'=> Yii::app()->createUrl('/user/index'), 'visible' => Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Adminisztracio.Felhasznalok')),
                            array ('label'=>'Szerepkörök', 'url'=> Yii::app()->createUrl('/rights/authItem/roles'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Adminisztracio.Szerepkorok')),
                            array ('label'=>'Szerepkörök kiosztása', 'url'=> Yii::app()->createUrl('/rights'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Adminisztracio.SzerepkorokKiosztasa')),
							array ('label'=>'Jogosultságok kiosztása', 'url'=> Yii::app()->createUrl('/rights/authItem'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Adminisztracio.JogosultsagokKiosztasa')),
                            array ('label'=>'Napló', 'url'=> Yii::app()->createUrl('/auditTrail/admin'), 'visible'=>Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Adminisztracio.Naplo')),
                        ), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->checkAccess('admin') || Yii::app()->user->checkAccess('Menu.Adminisztracio')) ),
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
