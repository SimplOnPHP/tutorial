<?php

class AE_FileType extends SC_Element {

	static
		$ReturnBtnMsg,
		$CancelBtnMsg,

		$SearchBtnMsg,
		$SearchMsg,

		$CreateBtnMsg,
		$CreatedMsg,
		$CreateMsg,
		$CreateError,

		$UpdateBtnMsg = 'Update',
		$UpdatedMsg,
		$UpdateMsg,
		$UpdateError,

		$DeleteBtnMsg,
		$DeletedMsg,
		$DeleteMsg,
		$DeleteError;

		
	static $permissions = array(
		'admin' => array('*'=>'allow'),
		'*' => array('View'=>'deny','*'=>'deny')
	);

    function construct() {
        $this->id = new SD_AutoIncrementId(); 
		$this->nombre = new SD_String('Nombre','SE');
		$this->icon = new SD_Image('Icono','sel');
		$this->icon->path('./usrImgs');
    }

	public function showList() {
		$iconView = $this->renderer->render($this->icon,'showList');

		return $this->nombre();
	}

}