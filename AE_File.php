<?php

class AE_File extends SC_Element {
	
	public static $storageChecked;
	
	static
		$AdminMsg,
		$ReturnBtnMsg,
		$CancelBtnMsg,

		$SearchBtnMsg,
		$SearchMsg,

		$ViewBtnMsg,
		$ViewMsg,

		$CreateBtnMsg,
		$CreatedMsg,
		$CreateMsg,
		$CreateError,

		$UpdateBtnMsg,
		$UpdatedMsg,
		$UpdateMsg,
		$UpdateError,

		$DeleteBtnMsg,
		$DeletedMsg,
		$DeleteMsg,
		$DeleteError;

		
	static $permissions = array(
		'admin' => array('*'=>'allow'),
		'user' => array(
			''=>'accessibleWhen_CurrentUserId_=_user',
			'View'=>array(
				''=>'accessibleWhen_CurrentUserId_=_user',
				'user'=>'fixed_CurrentUserId',
			),
			'Admin'=>array(
				'user'=>'fixed_CurrentUserId',
				'updateAction'=>'viwableWhen_user_=_CurrentUserId',
				'deleteAction'=>'hide',
			),
			'Search'=>array(
				''=>'accessibleWhen_CurrentUserId_=_user',
				'user'=>'fixed_CurrentUserId',
			),
			'Update'=>array(
				''=>'accessibleWhen_CurrentUserId_=_user',
				'user'=>'fixed_CurrentUserId',
			),
			'Create'=>array(
				'user'=>'fixed_CurrentUserId',
			),
			'Delete'=>array(
				''=>'accessibleWhen_CurrentUserId_=_user',
				'user'=>'fixed_CurrentUserId',
			),
		),
		'*' => array('*'=>'deny')
	);

    function construct() {
        $this->id = new SD_AutoIncrementId();
		$this->file = new AD_File('./files','Archivo','S');
		$this->description = new SD_Text('Descripción','S');
		$this->type = new SD_ElementContainer(new AE_FileType(),'Tipo');
		$this->type->layout(new SI_Select());
		$this->user = new SD_ElementContainer(new AE_User(),'Usuario',null,'SL',); 
		$this->user->layout(new SI_RadioButton());
    }

	//we have to asing the user to the file path respecting the original funcitionality for user that will be afected by the permissions
	function user($val = null){
		if($val){
			$this->__call('user',[$val]);
			$userDir=sanitizeFileName($this->Ouser()->viewVal());
			$this->file->path('./files/'.$userDir);
			//$this->downloadPath('./d/files/'.$userDir);
		}else{
			return $this->__call('user',null);
		}
	}
}