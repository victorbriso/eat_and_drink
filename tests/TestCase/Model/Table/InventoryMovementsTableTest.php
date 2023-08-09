<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InventoryMovementsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InventoryMovementsTable Test Case
 */
class InventoryMovementsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InventoryMovementsTable
     */
    protected $InventoryMovements;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.InventoryMovements',
        'app.Users',
        'app.Products',
        'app.Cellars',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('InventoryMovements') ? [] : ['className' => InventoryMovementsTable::class];
        $this->InventoryMovements = $this->getTableLocator()->get('InventoryMovements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->InventoryMovements);

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
