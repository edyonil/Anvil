<?php namespace Anvil\Modules;

use Illuminate\Database\DatabaseManager;

class DatabaseLoader implements LoaderInterface {

	/**
	 * The database instance.
	 *
	 * @var Illuminate\Database\DatabaseManager
	 */
	protected $database;

	/**
	 * All of the registered modules.
	 *
	 * @var array
	 */
	protected $modules;

	/**
	 * Save the Database Manager instance.
	 *
	 * @param  Illuminate\Database\DatabaseManager $database
	 * @return void
	 */
	public function __construct(DatabaseManager $database)
	{
		$this->database = $database;
	}

	/**
	 * Get all of the existing modules.
	 *
	 * @return array
	 */
	public function get()
	{
		if(is_null($this->modules))
		{
			$this->modules = array();

			$modules = $this->database->table('modules')
						->orderBy('is_core', 'desc')
						->get();

			// Organize the modules by their slugs. 
			foreach($modules as $module)
			{
				$this->modules[$module->slug] = $module;
			}
		}

		return $this->modules;
	}
}