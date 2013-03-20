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

 
require_once('modules/UpgradeWizard/uw_utils.php');
require_once('modules/MySettings/TabController.php');

class Bug42490Test extends Sugar_PHPUnit_Framework_TestCase 
{
	private $_originalEnabledTabs;
	private $_tc;
	
    public function setUp()
    {
        SugarTestHelper::setUp('moduleList');
        SugarTestHelper::setUp('current_user', array(true, 1));
        $this->_tc = new TabController();
        $tabs = $this->_tc->get_tabs_system();
        $this->_originalEnabledTabs = $tabs[0];
    }

	public function tearDown() 
	{
        if (!empty($this->_originalEnabledTabs))
        {
            $this->_tc->set_system_tabs($this->_originalEnabledTabs);
        }
	}

	public function testUpgradeDisplayedTabsAndSubpanels() 
	{
        $modules_to_add = array(
            'Calls',
            'Meetings',
            'Tasks',
            'Notes',
            'Prospects',
            'ProspectLists',
        );

		upgradeDisplayedTabsAndSubpanels('610');
		
		$all_tabs = $this->_tc->get_tabs_system();
		$tabs = $all_tabs[0];
		
		foreach($modules_to_add as $module)
		{
            $this->assertArrayHasKey($module, $tabs, 'Assert that ' . $module . ' tab is set for system tabs');
		}
	}
}