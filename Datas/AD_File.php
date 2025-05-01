<?php

class AD_File extends SD_File {

	public function viewVal(){
		return new SI_Link($this->val(), $this->fileName());
	}
}
