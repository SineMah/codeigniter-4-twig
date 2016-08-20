<?php namespace Builder;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\MockConnection;

class LikeTest extends \CIUnitTestCase
{
	protected $db;

	//--------------------------------------------------------------------

	public function setUp()
	{
		$this->db = new MockConnection([]);
	}

	//--------------------------------------------------------------------

	public function testSimpleLike()
	{
		$builder = new BaseBuilder('job', $this->db);

		$builder->like('name', 'veloper');

		$expectedSQL   = "SELECT * FROM \"job\" WHERE \"name\" LIKE :name ESCAPE '!'";
		$expectedBinds = ['name' => '%veloper%'];

		$this->assertEquals($expectedSQL, str_replace("\n", ' ', $builder->getCompiledSelect()));
		$this->assertSame($expectedBinds, $builder->getBinds());
	}

	//--------------------------------------------------------------------

	public function testLikeNoSide()
	{
		$builder = new BaseBuilder('job', $this->db);

		$builder->like('name', 'veloper', 'none');

		$expectedSQL   = "SELECT * FROM \"job\" WHERE \"name\" LIKE :name ESCAPE '!'";
		$expectedBinds = ['name' => 'veloper'];

		$this->assertEquals($expectedSQL, str_replace("\n", ' ', $builder->getCompiledSelect()));
		$this->assertSame($expectedBinds, $builder->getBinds());
	}

	//--------------------------------------------------------------------

	public function testLikeBeforeOnly()
	{
		$builder = new BaseBuilder('job', $this->db);

		$builder->like('name', 'veloper', 'before');

		$expectedSQL   = "SELECT * FROM \"job\" WHERE \"name\" LIKE :name ESCAPE '!'";
		$expectedBinds = ['name' => '%veloper'];

		$this->assertEquals($expectedSQL, str_replace("\n", ' ', $builder->getCompiledSelect()));
		$this->assertSame($expectedBinds, $builder->getBinds());
	}

	//--------------------------------------------------------------------

	public function testLikeAfterOnly()
	{
		$builder = new BaseBuilder('job', $this->db);

		$builder->like('name', 'veloper', 'after');

		$expectedSQL   = "SELECT * FROM \"job\" WHERE \"name\" LIKE :name ESCAPE '!'";
		$expectedBinds = ['name' => 'veloper%'];

		$this->assertEquals($expectedSQL, str_replace("\n", ' ', $builder->getCompiledSelect()));
		$this->assertSame($expectedBinds, $builder->getBinds());
	}

	//--------------------------------------------------------------------

	public function testOrLike()
	{
		$builder = new BaseBuilder('job', $this->db);

		$builder->like('name', 'veloper')->orLike('name', 'ian');

		$expectedSQL   = "SELECT * FROM \"job\" WHERE \"name\" LIKE :name ESCAPE '!' OR  \"name\" LIKE :name0 ESCAPE '!'";
		$expectedBinds = ['name' => '%veloper%', 'name0' => '%ian%'];

		$this->assertEquals($expectedSQL, str_replace("\n", ' ', $builder->getCompiledSelect()));
		$this->assertSame($expectedBinds, $builder->getBinds());
	}

	//--------------------------------------------------------------------

	public function testNotLike()
	{
		$builder = new BaseBuilder('job', $this->db);

		$builder->notLike('name', 'veloper');

		$expectedSQL   = "SELECT * FROM \"job\" WHERE \"name\" NOT LIKE :name ESCAPE '!'";
		$expectedBinds = ['name' => '%veloper%'];

		$this->assertEquals($expectedSQL, str_replace("\n", ' ', $builder->getCompiledSelect()));
		$this->assertSame($expectedBinds, $builder->getBinds());
	}

	//--------------------------------------------------------------------

	public function testOrNotLike()
	{
		$builder = new BaseBuilder('job', $this->db);

		$builder->like('name', 'veloper')->orNotLike('name', 'ian');

		$expectedSQL   = "SELECT * FROM \"job\" WHERE \"name\" LIKE :name ESCAPE '!' OR  \"name\" NOT LIKE :name0 ESCAPE '!'";
		$expectedBinds = ['name' => '%veloper%', 'name0' => '%ian%'];

		$this->assertEquals($expectedSQL, str_replace("\n", ' ', $builder->getCompiledSelect()));
		$this->assertSame($expectedBinds, $builder->getBinds());
	}

	//--------------------------------------------------------------------

	/**
	 * @group single
	 */
	public function testCaseInsensitiveLike()
	{
		$builder = new BaseBuilder('job', $this->db);

		$builder->like('name', 'VELOPER', 'both', null, true);

		$expectedSQL   = "SELECT * FROM \"job\" WHERE LOWER(name) LIKE :name ESCAPE '!'";
		$expectedBinds = ['name' => '%veloper%'];

		$this->assertEquals($expectedSQL, str_replace("\n", ' ', $builder->getCompiledSelect()));
		$this->assertSame($expectedBinds, $builder->getBinds());
	}

	//--------------------------------------------------------------------
}
