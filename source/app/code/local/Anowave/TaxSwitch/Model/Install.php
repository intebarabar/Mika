<?php
class Anowave_TaxSwitch_Model_Install
{
	/**
	 * Catalog Setup
	 */
	private $setup = null;
	
	/**
	 * @var (object) Core Setup
	 */
	private $core = null;
	
	/**
	 * @var (object) Catalog Setup
	 */
	private $catalog_setup = null;
	
	/**
	 * @var (object) Entity Setup
	 */
	private $entity_setup = null;
	
	/* Installer */
	private $installer = null;

	public function install(Mage_Core_Model_Resource_Setup $installer)
	{
		/* Set installer */
		$this->installer = $installer;

		/* Start installer */
		$this->installer->startSetup();
		
		$this->addSql();

		$this->installer->endSetup();
	}

	private function addSql()
	{
		$sql = array();
		
		$sql[] = "CREATE TABLE IF NOT EXISTS " . Mage::getConfig()->getTablePrefix() . "anowave_taxswitch (tax_group_id smallint(2) NOT NULL,tax_display_setting int(2) NOT NULL,PRIMARY KEY (tax_group_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		
		foreach ($sql as $query)
		{
			$this->installer->run($query);
		}
	
		return $this;
	}

	private function getCoreSetup()
	{
		if (!$this->core)
		{
			$this->core = new Mage_Eav_Model_Entity_Setup('core_setup');
		}
	
		return $this->core;
	}
	
	private function getCatalogSetup()
	{
		if (!$this->catalog_setup)
		{
			$this->catalog_setup = new Mage_Eav_Model_Entity_Setup('catalog_setup');
		}
		return $this->catalog_setup;
	}
	
	private function getEntitySetup()
	{
		if (!$this->entity_setup)
		{
			$this->entity_setup = Mage::getModel('customer/entity_setup', 'core_setup');
		}
		return $this->entity_setup;
	}
}