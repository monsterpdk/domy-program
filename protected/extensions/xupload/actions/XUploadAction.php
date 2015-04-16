<?php

/**
 * XUploadAction
 * =============
 * Basic upload functionality for an action used by the xupload extension.
 *
 * XUploadAction is used together with XUpload and XUploadForm to provide file upload funcionality to any application
 *
 * You must configure properties of XUploadAction to customize the folders of the uploaded files.
 *
 * Using XUploadAction involves the following steps:
 *
 * 1. Override CController::actions() and register an action of class XUploadAction with ID 'upload', and configure its
 * properties:
 * ~~~
 * [php]
 * class MyController extends CController
 * {
 *     public function actions()
 *     {
 *         return array(
 *             'upload'=>array(
 *                 'class'=>'xupload.actions.XUploadAction',
 *                 'path' =>Yii::app() -> getBasePath() . "/../uploads",
 *                 'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
 *                 'subfolderVar' => "parent_id",
 *             ),
 *         );
 *     }
 * }
 *
 * 2. In the form model, declare an attribute to store the uploaded file data, and declare the attribute to be validated
 * by the 'file' validator.
 * 3. In the controller view, insert a XUpload widget.
 *
 * ###Resources
 * - [xupload](http://www.yiiframework.com/extension/xupload)
 *
 * @version 0.3
 * @author Asgaroth (http://www.yiiframework.com/user/1883/)
 */
class XUploadAction extends CAction {

    /**
     * XUploadForm (or subclass of it) to be used.  Defaults to XUploadForm
     * @see XUploadAction::init()
     * @var string
     * @since 0.5
     */
    public $formClass = 'xupload.models.XUploadForm';

    /**
     * Name of the model attribute referring to the uploaded file.
     * Defaults to 'file', the default value in XUploadForm
     * @var string
     * @since 0.5
     */
    public $fileAttribute = 'file';

    /**
     * Name of the model attribute used to store mimeType information.
     * Defaults to 'mime_type', the default value in XUploadForm
     * @var string
     * @since 0.5
     */
    public $mimeTypeAttribute = 'mime_type';

    /**
     * Name of the model attribute used to store file size.
     * Defaults to 'size', the default value in XUploadForm
     * @var string
     * @since 0.5
     */
    public $sizeAttribute = 'size';

    /**
     * Name of the model attribute used to store the file's display name.
     * Defaults to 'name', the default value in XUploadForm
     * @var string
     * @since 0.5
     */
    public $displayNameAttribute = 'name';

    /**
     * Name of the model attribute used to store the file filesystem name.
     * Defaults to 'filename', the default value in XUploadForm
     * @var string
     * @since 0.5
     */
    public $fileNameAttribute = 'filename';

    /**
     * The query string variable name where the subfolder name will be taken from.
     * If false, no subfolder will be used.
     * Defaults to null meaning the subfolder to be used will be the result of date("mdY").
     *
     * @see XUploadAction::init().
     * @var string
     * @since 0.2
     */
    public $subfolderVar;

    /**
     * Path of the main uploading folder.
     * @see XUploadAction::init()
     * @var string
     * @since 0.1
     */
    public $path;

    /**
     * Public path of the main uploading folder.
     * @see XUploadAction::init()
     * @var string
     * @since 0.1
     */
    public $publicPath;

    /**
     * @var boolean dictates whether to use sha1 to hash the file names
     * along with time and the user id to make it much harder for malicious users
     * to attempt to delete another user's file
     */
    public $secureFileNames = false;

    /**
     * Name of the state variable the file array is stored in
     * @see XUploadAction::init()
     * @var string
     * @since 0.5
     */
    public $stateVariable = 'xuploadFiles';

    /**
     * The resolved subfolder to upload the file to
     * @var string
     * @since 0.2
     */
    private $_subfolder = "";

    /**
     * The form model we'll be saving our files to
     * @var CModel (or subclass)
     * @since 0.5
     */
    private $_formModel;

    /**
     * Initialize the propeties of pthis action, if they are not set.
     *
     * @since 0.1
     */
	 
	private $infoMessages = "";
	 
    public function init( ) {

        if( !isset( $this->path ) ) {
            $this->path = realpath( Yii::app( )->getBasePath( )."/../uploads" );
        }

        if( !is_dir( $this->path ) ) {
            mkdir( $this->path, 0777, true );
            chmod ( $this->path , 0777 );
            //throw new CHttpException(500, "{$this->path} does not exists.");
        } else if( !is_writable( $this->path ) ) {
            chmod( $this->path, 0777 );
            //throw new CHttpException(500, "{$this->path} is not writable.");
        }
        if( $this->subfolderVar === null ) {
            $this->_subfolder = Yii::app( )->request->getQuery( $this->subfolderVar, date( "Ymd" ) );
        } else if($this->subfolderVar !== false ) {
            $this->_subfolder = date( "mdY" );
        }

        if( !isset($this->_formModel)) {
            $this->formModel = Yii::createComponent(array('class'=>$this->formClass));
        }

        if($this->secureFileNames) {
            $this->formModel->secureFileNames = true;
        }
    }

    /**
     * The main action that handles the file upload request.
     * @since 0.1
     * @author Asgaroth
     */
    public function run( ) {
        $this->sendHeaders();

        $this->handleDeleting() or $this->handleUploading();
    }
    protected function sendHeaders()
    {
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
    }
    /**
     * Removes temporary file from its directory and from the session
     *
     * @return bool Whether deleting was meant by request
     */
    protected function handleDeleting()
    {
        if (isset($_GET["_method"]) && $_GET["_method"] == "delete") {
            $success = false;
            if ($_GET["file"][0] !== '.' && Yii::app()->user->hasState($this->stateVariable)) {
                // pull our userFiles array out of state and only allow them to delete
                // files from within that array
                $userFiles = Yii::app()->user->getState($this->stateVariable, array());

                if ($this->fileExists($userFiles[$_GET["file"]])) {
                    $success = $this->deleteFile($userFiles[$_GET["file"]]);
                    if ($success) {
                        unset($userFiles[$_GET["file"]]); // remove it from our session and save that info
                        Yii::app()->user->setState($this->stateVariable, $userFiles);
                    }
                }
            }
			
            echo json_encode($success);
            return true;
        }
        return false;
    }

    /**
     * Uploads file to temporary directory
     *
     * @throws CHttpException
     */
    protected function handleUploading()
    {
        $this->init();
        $model = $this->formModel;
        $model->{$this->fileAttribute} = CUploadedFile::getInstance($model, $this->fileAttribute);
        if ($model->{$this->fileAttribute} !== null) {
            $model->{$this->mimeTypeAttribute} = $model->{$this->fileAttribute}->getType();
            $model->{$this->sizeAttribute} = $model->{$this->fileAttribute}->getSize();
            $model->{$this->displayNameAttribute} = $model->{$this->fileAttribute}->getName();
            $model->{$this->fileNameAttribute} = $model->{$this->displayNameAttribute};

            if ($model->validate()) {

                $path = $this->getPath();

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                    chmod($path, 0777);
                }

				$fileName =  basename($model->{$this->fileNameAttribute}, ".csv"). '_' . date('YmdHis') . '.csv';
                $model->{$this->fileAttribute}->saveAs($path . $fileName);
                chmod($path . $fileName, 0777);

                $returnValue = $this->beforeReturn();
				
				$csv = array_map('str_getcsv', file($path . $fileName));
				
				$row_counter = 0;
				$object_class = '';
				
				$true_delimiter = ";"; // ha Excel-ben megnyitom és rámentek a fájlra, akkor TAB-bá alakítja a ; delimitert ... ?!
				if (count($csv) >= 3)
					if (substr_count($csv[2][0], "\t") > 30)
						$true_delimiter = "\t";

				$errorList = array();
				foreach ($csv as $row) {
					if ($row_counter > 1) {
						$cols = explode ($true_delimiter, $row[0]);
						
						$action = $cols[0];
						$id = $cols[1];
						
						$errors = null;
						if (empty($id) || !empty($action))
							$errors = $this -> updateRowIfNecessary ($object_class, $cols, $row_counter);
						
						if ($errors != null)
							$errorList = array_merge($errorList, $errors);
					} else if ($row_counter == 0) {
						$cols = explode ($true_delimiter, $this -> remove_utf8_bom($row[0]));
						$object_class = $cols[0];
					}
					$row_counter++;
				} 
				
				// TODO : remove
				// die();
				
              /*  if ($returnValue === true) {
                    echo json_encode(array(array(
                        "name" => $model->{$this->displayNameAttribute},
                        "type" => $model->{$this->mimeTypeAttribute},
                        "size" => $model->{$this->sizeAttribute},
                        "url" => $this->getFileUrl($model->{$this->fileNameAttribute}),
                        "thumbnail_url" => $model->getThumbnailUrl($this->getPublicPath()),
                        "delete_url" => $this->getController()->createUrl($this->getId(), array(
                            "_method" => "delete",
                            "file" => $model->{$this->fileNameAttribute},
                        )),
                        "delete_type" => "POST"
                    )));
                } else {*/
				
					// LI : hozzáadjuk az info sorokat a hibák végére, ha vannak
					if (strlen($this -> infoMessages) > 0) {
						$counter = substr_count ($this -> infoMessages, ', ') + 1;
						$errorList[] = array("type" => 'info', "msg" => "Sikeresen módosított rekordok száma: " . $counter);
					} else
						$errorList[] = array("type" => 'info', "msg" => "A CSV fájl nem tartalmazott módosítást az adatbázishoz.");
						
                    echo json_encode($errorList);
                    Yii::log("XUploadAction: " . $returnValue, CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction");
                //}
            } else {
                echo json_encode(array(array("error" => $model->getErrors($this->fileAttribute),)));
                Yii::log("XUploadAction: " . CVarDumper::dumpAsString($model->getErrors()), CLogger::LEVEL_ERROR, "xupload.actions.XUploadAction");
            }
        } else {
            throw new CHttpException(500, "Could not upload file");
        }
    }
// LI : objektumtípustól (jelenleg vagy termék, vagy termékár) függőben importálunk
	function updateRowIfNecessary ($object_class, $cols, $row_counter) {
		$errors = null;
		
		if ($object_class == "Termekek" || $object_class == "TermekArak") {
			$errors = $this -> createClassFromCsvRow ($object_class, $cols, $row_counter);
		}		
		
		return $errors;
	}

	function createClassFromCsvRow ($object_class, $cols, $row_counter) {
		$errors = null;
		
		if ($object_class == "Termekek") {
			// ha van ID megpróbáljuk betölteni a modelt
			$termek = new Termekek;
			
			if (!empty($cols[1])) {
				$termek=Termekek::model() -> findByPk($cols[1]);
				if ($termek===null)
					$termek = new Termek;
			}
			
			$termek -> nev = $this -> clean($cols[2]);
			$termek -> kodszam = $this -> clean($cols[3]);
			$termek -> meret_id = $this -> clean($cols[4]);
			$termek -> suly = $this -> clean($cols[6]);
			$termek -> zaras_id = $this -> clean($cols[7]);
			$termek -> ablakmeret_id = $this -> clean($cols[9]);
			$termek -> ablakhely_id = $this -> clean($cols[11]);
			$termek -> papir_id = $this -> clean($cols[13]);
			$termek -> afakulcs_id = $this -> clean($cols[15]);
			$termek -> redotalp = $this -> clean($cols[17]);
			$termek -> gyarto_id = $this -> clean($cols[18]);
			$termek -> ksh_kod = $this -> clean($cols[20]);
			$termek -> csom_egys = $this -> clean($cols[21]);
			$termek -> minimum_raktarkeszlet = $this -> clean($cols[22]);
			$termek -> maximum_raktarkeszlet = $this -> clean($cols[23]);
			$termek -> doboz_suly = $this -> clean($cols[24]);
			$termek -> raklap_db = $this -> clean($cols[25]);
			$termek -> doboz_hossz = $this -> clean($cols[26]);
			$termek -> doboz_szelesseg = $this -> clean($cols[27]);
			$termek -> doboz_magassag = $this -> clean($cols[28]);
			$termek -> megjegyzes = $this -> clean($cols[29]);
			$termek -> megjelenes_mettol = date('Y-m-d', strtotime(str_replace(".", "", str_replace("-", "", $this -> clean($cols[30])))));
			$termek -> megjelenes_meddig = date('Y-m-d', strtotime(str_replace(".", "", str_replace("-", "", $this -> clean($cols[31])))));
			$termek -> torolt = $this -> clean($cols[33]);

			if ($termek -> validate()) {
				$this -> infoMessages .= ((strlen($this -> infoMessages) > 0) ? ", " : '') . $termek -> nev;
				
				// elmentjük a terméket
				$termek -> save();
			} else {
				$error_string = ($row_counter - 1) . ". sor: ";
				foreach ($termek -> getErrors() as $error) {
					$error_string .= $error[0] . "\n";
				}
				$errors[] = array("type" => 'error', "msg" => $error_string);
			}
		} else if ($object_class == 'TermekArak') {
				// ha van ID megpróbáljuk betölteni a modelt
				$termekAr = new TermekArak;
				
				if (!empty($cols[1])) {
					$termekAr=TermekArak::model() -> findByPk($cols[1]);
					if ($termekAr===null)
						$termekAr = new TermekArak;
				}
				
				$termekAr -> termek_id = $this -> clean($cols[3]);
				$termekAr -> csomag_beszerzesi_ar = $this -> clean($cols[4]);
				$termekAr -> db_beszerzesi_ar = $this -> clean($cols[5]);
				$termekAr -> csomag_ar_szamolashoz = $this -> clean($cols[6]);
				$termekAr -> csomag_ar_nyomashoz = $this -> clean($cols[7]);
				$termekAr -> db_ar_nyomashoz = $this -> clean($cols[8]);
				$termekAr -> csomag_eladasi_ar = $this -> clean($cols[9]);
				$termekAr -> db_eladasi_ar = $this -> clean($cols[10]);
				$termekAr -> csomag_ar2 = $this -> clean($cols[11]);
				$termekAr -> db_ar2 = $this -> clean($cols[12]);
				$termekAr -> csomag_ar3 = $this -> clean($cols[13]);
				$termekAr -> db_ar3 = $this -> clean($cols[14]);
				$termekAr -> datum_mettol = date('Y-m-d', strtotime(str_replace("-", "", $this -> clean($cols[15]))));
				$termekAr -> datum_meddig = date('Y-m-d', strtotime(str_replace("-", "", $this -> clean($cols[16]))));
				$termekAr -> torolt = $this -> clean($cols[17]);
				
				if ($termekAr -> validate()) {
					$this -> infoMessages .= ((strlen($this -> infoMessages) > 0) ? ", " : '') . $termekAr -> id;
					
					// elmentjük a terméket
					$termekAr -> save();
				} else {
					$error_string = ($row_counter - 1) . ". sor: ";
					foreach ($termekAr -> getErrors() as $error) {
						$error_string .= $error[0] . "\n";
					}
					$errors[] = array("type" => 'error', "msg" => $error_string);
				}
		}
		
		return $errors;
	}
	
	function clean ($str) {
		return str_replace('"', "", trim($str));
	}
// LI 
	
    /**
     * We store info in session to make sure we only delete files we intended to
     * Other code can override this though to do other things with state, thumbnail generation, etc.
     * @since 0.5
     * @author acorncom
     * @return boolean|string Returns a boolean unless there is an error, in which case it returns the error message
     */
    protected function beforeReturn() {
        $path = $this->getPath();

        // Now we need to save our file info to the user's session
        $userFiles = Yii::app( )->user->getState( $this->stateVariable, array());

        $userFiles[$this->formModel->{$this->fileNameAttribute}] = array(
            "path" => $path.$this->formModel->{$this->fileNameAttribute},
            //the same file or a thumb version that you generated
            "thumb" => $path.$this->formModel->{$this->fileNameAttribute},
            "filename" => $this->formModel->{$this->fileNameAttribute},
            'size' => $this->formModel->{$this->sizeAttribute},
            'mime' => $this->formModel->{$this->mimeTypeAttribute},
            'name' => $this->formModel->{$this->displayNameAttribute},
        );
        Yii::app( )->user->setState( $this->stateVariable, $userFiles );

        return true;
    }

    /**
     * Returns the file URL for our file
     * @param $fileName
     * @return string
     */
    protected function getFileUrl($fileName) {
        return $this->getPublicPath().$fileName;
    }

    /**
     * Returns the file's path on the filesystem
     * @return string
     */
    protected function getPath() {
        $path = ($this->_subfolder != "") ? "{$this->path}/{$this->_subfolder}/" : "{$this->path}/";
        return $path;
    }

    /**
     * Returns the file's relative URL path
     * @return string
     */
    protected function getPublicPath() {
        return ($this->_subfolder != "") ? "{$this->publicPath}/{$this->_subfolder}/" : "{$this->publicPath}/";
    }

    /**
     * Deletes our file.
     * @param $file
     * @since 0.5
     * @return bool
     */
    protected function deleteFile($file) {
        return unlink($file['path']);
    }

    /**
     * Our form model setter.  Allows us to pass in a instantiated form model with options set
     * @param $model
     */
    public function setFormModel($model) {
        $this->_formModel = $model;
    }

    public function getFormModel() {
        return $this->_formModel;
    }

    /**
     * Allows file existence checking prior to deleting
     * @param $file
     * @return bool
     */
    protected function fileExists($file) {
        return is_file( $file['path'] );
    }
	
	function remove_utf8_bom($text)
	{
		$bom = pack('H*','EFBBBF');
		$text = preg_replace("/^$bom/", '', $text);
		
		return $text;
	}
}
