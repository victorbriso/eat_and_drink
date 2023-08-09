<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BuySummariesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BuySummariesTable Test Case
 */
class BuySummariesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BuySummariesTable
     */
    protected $BuySummaries;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.BuySummaries',
        'app.Users',
        'app.Vendors',
        'app.BuyDetails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BuySummaries') ? [] : ['className' => BuySummariesTable::class];
        $this->BuySummaries = $this->getTableLocator()->get('BuySummaries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->BuySummaries);

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
