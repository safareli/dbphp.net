<?php
namespace galaxy
{
	class star
	{
		public $id;
		public $name;
		public function __construct ($name=null)
		{
			$this->name = $name;
		}
	}

	class planet
	{
		/**
		* primary
		* length 16
		* @var string
		*/
		public $name;
		/**
		* type smallint
		* @var integer
		*/
		public $order;
		/**
		* @var boolean
		*/
		public $water;
		/**
		* @var \galaxy\star
		*/
		public $star;
		/**
		* enum
		* @var \galaxy\moon
		*/
		public $moons = array ();
		public function __construct ($star=null, $name=null, $order=null, $water=false)
		{
			$this->name = $name;
			$this->order = $order;
			$this->star = $star;
			$this->water = $water;
		}
		public function add (\galaxy\moon $moon)
		{
			$this->moons[$moon->id] = $moon;
		}
	}

	//let us set cache type to 'load' as moon has no any sensitive data
	//with this cache type database	caches results per script load
	//in array
	/**
	* cache load
	*/
	class moon
	{
		public $id;
		public $name;
		public function __construct ($name=null)
		{
			$this->name = $name;
		}
	}
}
?>