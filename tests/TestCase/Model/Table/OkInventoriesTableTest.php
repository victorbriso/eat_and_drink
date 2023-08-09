<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OkInventoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OkInventoriesTable Test Case
 */
class OkInventoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OkInventoriesTable
     */
    protected $OkInventories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OkInventories',
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
        $config = $this->getTableLocator()->exists('OkInventories') ? [] : ['className' => OkInventoriesTable::class];
        $this->OkInventories = $this->getTableLocator()->get('OkInventories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OkInventories);

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
