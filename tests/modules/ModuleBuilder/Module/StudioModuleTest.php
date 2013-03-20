<?php
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

 
require_once("modules/ModuleBuilder/Module/StudioModule.php");

class StudioModuleTest extends Sugar_PHPUnit_Framework_TestCase
{
	public static function setUpBeforeClass()
    {
        $beanList = array();
        $beanFiles = array();
        require('include/modules.php');
        $GLOBALS['beanList'] = $beanList;
        $GLOBALS['beanFiles'] = $beanFiles;
        $GLOBALS['current_user'] = SugarTestUserUtilities::createAnonymousUser();
        $GLOBALS['app_list_strings'] = return_app_list_strings_language($GLOBALS['current_language']);

    }
    
    public static function tearDownAfterClass()
    {
        unset($GLOBALS['beanFiles']);
        unset($GLOBALS['beanList']);
        unset($GLOBALS['current_user']);
        unset($GLOBALS['app_list_strings']);
    }

    /**
     * @ticket 39407
     *
     */
    public function testRemoveFieldFromLayoutsDocumentsException()
    {
        $this->markTestSkipped('Skip this test');
    	$SM = new StudioModule("Documents");
        try {
            $SM->removeFieldFromLayouts("aFieldThatDoesntExist");
            $this->assertTrue(true);
        } catch (Exception $e) {
            //Studio module threw exception
            $this->assertTrue(true);
        }
    }

    public function providerGetType()
    {
        return array(
            array('Meetings', 'basic'),
            array('Calls', 'basic'),
            array('Accounts', 'company'),
            array('Contacts', 'person'),
            array('Leads', 'person'),
            array('Cases', 'basic'),
        );
    }

    /**
     * @ticket 50977
     *
     * @dataProvider providerGetType
     */
    public function testGetTypeFunction($module, $type) {
        $SM = new StudioModule($module);
        $this->assertEquals($type, $SM->getType(), 'Failed asserting that module:' . $module . ' is of type:' . $type);
    }
}