<?php

class AE_Admin extends AE_User {

	protected static $AdminRoleID;

	protected 
	 	$defaultClass = 'AE_Admin',
	 	$defaultMethod = 'startScreen';

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
		$this->storage('AE_User');

		//We need to ensure there is an Admmin role in the DB and set it as a fixed value for this class
		if(!self::$AdminRoleID){
			$role = new SE_Role();
			$role->roleName('admin');
			$search = new SE_Search(array('SE_Role'));
			$result = $search->getResults($role->toArray(), ['id'], 0, 1)[0];
			if ($result && $result->id()) {
				self::$AdminRoleID = $result->id();
			} else {
				self::$AdminRoleID = $role->create();
			}
		}
		
		@$Links[] = new SI_Link(SC_Main::$RENDERER->action('AE_File','showAdmin'), SC_MAIN::L('Files'));
		$Links[] = new SI_Link(SC_Main::$RENDERER->action('AE_FileType','showAdmin'), SC_MAIN::L('Files types'));
		$Links[] = new SI_Link(SC_Main::$RENDERER->action('AE_User','showAdmin'), SC_MAIN::L('Users'));
		$Links[] = new SI_Link(SC_Main::$RENDERER->action('SE_Role','showAdmin'), SC_MAIN::L('Roles'));
		$Links[] = new SI_AjaxLink(SC_Main::$RENDERER->action($this->getClass(),'logout'), SC_MAIN::L('Logout'), 'logout.svg');

		self::$menu =  new SI_SystemMenu($Links);
    }

	function startScreen(){
		
		$content = new SI_VContainer();
			$titleText = SC_Main::L('Welcome');
        	$title = new SI_Title($titleText,5,'c');
        	
		$content->addItem($title);
			$buttons = new SI_HContainer();
			$buttons->addItem(new SI_Link(SC_Main::$RENDERER->action('AE_File','showAdmin'), new SI_Image('Files.svg','Files','500rem','500rem')));
			$buttons->addItem(new SI_Link(SC_Main::$RENDERER->action('AE_FileType','showAdmin'), new SI_Image('FileTypes.svg','File Types','500rem','500rem')));
			$buttons->addItem(new SI_Link(SC_Main::$RENDERER->action('AE_User','showAdmin'), new SI_Image('Users.svg','Users','500rem','500rem')));
			$buttons->addItem(new SI_Link(SC_Main::$RENDERER->action('SE_Role','showAdmin'), new SI_Image('Roles.svg','Roles','500rem','500rem')));
		$content->addItem($buttons);
		$page = new SI_systemScreen( $content,$titleText );
		return $page;
	}
}