<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PriceListsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PriceListsTable Test Case
 */
class PriceListsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PriceListsTable
     */
    protected $PriceLists;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PriceLists',
        'app.Users',
        'app.PriceListControls',
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
        $config = $this->getTableLocator()->exists('PriceLists') ? [] : ['className' => PriceListsTable::class];
        $this->PriceLists = $this->getTableLocator()->get('PriceLists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PriceLists);

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
