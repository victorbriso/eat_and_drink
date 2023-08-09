<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PriceListControlsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PriceListControlsTable Test Case
 */
class PriceListControlsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PriceListControlsTable
     */
    protected $PriceListControls;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PriceListControls',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PriceListControls') ? [] : ['className' => PriceListControlsTable::class];
        $this->PriceListControls = $this->getTableLocator()->get('PriceListControls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PriceListControls);

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
