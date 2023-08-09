<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PendingInventoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PendingInventoriesTable Test Case
 */
class PendingInventoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PendingInventoriesTable
     */
    protected $PendingInventories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PendingInventories',
        'app.Users',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PendingInventories') ? [] : ['className' => PendingInventoriesTable::class];
        $this->PendingInventories = $this->getTableLocator()->get('PendingInventories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PendingInventories);

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
