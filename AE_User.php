<?php

class AE_User extends SE_User {

	protected static $RoleID;

	protected 
	 	$defaultClass = 'AE_File',
	 	$defaultMethod = 'showAdmin';

	static
		$menu,
		$ReturnBtnMsg,
		$CancelBtnMsg,

		$SearchBtnMsg,
		$SearchMsg,

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

	
	function construct($id = NULL, $storage = 'AE_User' ) {
		parent::construct($id, $storage);

		//We need to ensure there is an user role in the DB and set it as a fixed value for this class
		if(!self::$RoleID){
			$role = new SE_Role();
			$role->roleName('user');
			$search = new SE_Search(array('SE_Role'));
			$result = $search->getResults($role->toArray(), ['id'], 0, 1)[0];
			if ($result && $result->id()) {
				self::$RoleID = $result->id();
			} else {
				self::$RoleID = $role->create();
			}
		}
		
		@$Links[] = new SI_Link(SC_Main::$RENDERER->action('AE_File','showAdmin'), SC_MAIN::L('Files'));
		$Links[] = new SI_Link(SC_Main::$RENDERER->action($this,'showupdate'), SC_MAIN::L('My profile'));
		$Links[] = new SI_AjaxLink(SC_Main::$RENDERER->action($this->getClass(),'logout'), SC_MAIN::L('Logout'), 'logout.svg');
		self::$menu =  new SI_SystemMenu($Links);
    }

}