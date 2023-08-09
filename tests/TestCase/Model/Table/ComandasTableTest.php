<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ComandasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ComandasTable Test Case
 */
class ComandasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ComandasTable
     */
    protected $Comandas;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Comandas',
        'app.Users',
        'app.Salons',
        'app.Tables',
        'app.Usuarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Comandas') ? [] : ['className' => ComandasTable::class];
        $this->Comandas = $this->getTableLocator()->get('Comandas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Comandas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
