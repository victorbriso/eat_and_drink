<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CellarsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CellarsTable Test Case
 */
class CellarsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CellarsTable
     */
    protected $Cellars;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Cellars',
        'app.Users',
        'app.Products',
        'app.InventoryMovements',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Cellars') ? [] : ['className' => CellarsTable::class];
        $this->Cellars = $this->getTableLocator()->get('Cellars', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Cellars);

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
