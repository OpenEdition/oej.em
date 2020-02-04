<?php
if (PHP_SAPI != 'cli') die('cli only');         // php-cli only

/*******************************************************************
   
   Description
   - upgrade editorial model from version 1.0.0 or 1.0.1 to 1.0.2
   - update XPath for pagination, ndlr, ndla, datepublipapier
     for compatibility with OpenEdition TEI Schema 1.6.2
   - create if needed or update emversion option

   Install
   - copy or make a symbolic link of the file in the root directory 
     of the Lodel install

   Execute
   - cd PATH_TO_ROOT_LODEL_DIRECTORY
   - php upgrade_1.0.X_to_1.0.2.php mysite # update the site "mysite"
     or 
     php upgrade_1.0.X_to_1.0.2.php all # update all sites (excepted site listed in the array $exclude. See below)
   - after execution, file should be remove from lodel root directory

 *******************************************************************/

require_once('lodel/install/scripts/me_manipulation_func.php');
define('DO_NOT_DIE', true);                      // only die of a severe error
// define('QUIET', true);                        // no output
$exclude = array();                              // the $exclude array may contain site names to be excluded from processing at execution with the  parameter "all"
$sites = new ME_sites_iterator($argv, 'errors'); // 'errors' display only errors ot the function ->m()

while ($siteName = $sites->fetch()) {
	if (in_array($siteName,$exclude)) continue;

	TF::get('textes', 'pagination')->set('otx','/tei:TEI/tei:teiHeader/tei:fileDesc/tei:sourceDesc/tei:biblStruct/tei:monogr/tei:imprint/tei:biblScope[@unit=\'page\']')->m();
	TF::get('textes', 'ndlr')->set('otx','/tei:TEI/tei:text/tei:front/tei:note[@type=\'publisher\']/tei:p')->m();
	TF::get('textes', 'ndla')->set('otx','/tei:TEI/tei:text/tei:front/tei:note[@type=\'author\']/tei:p')->m();
	TF::get('textes', 'datepublipapier')->set('otx','/tei:TEI/tei:teiHeader/tei:fileDesc/tei:sourceDesc/tei:biblStruct/tei:monogr/tei:imprint/tei:date[@type=\'published\']')->m();

	O::create('optionsgenerales', 'emversion', 'tinytext', 'Version du modèle éditorial',array('edition' => 'display','editionparams' => '','userrights' => 40,'defaultvalue' => '1.0.2','value'=>'1.0.2'))->m();
	// Update emversion with MySQL commands
	// me_manipulation_func.php doesn't provide method to update these fields
	global $db;
        $sql = lq("UPDATE options SET defaultvalue='1.0.2', value='1.0.2' WHERE name='emversion'");
        $db->Execute($sql);
}

?>
