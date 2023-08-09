<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BuyDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BuyDetailsTable Test Case
 */
class BuyDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BuyDetailsTable
     */
    protected $BuyDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.BuyDetails',
        'app.Users',
        'app.BuySummaries',
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
        $config = $this->getTableLocator()->exists('BuyDetails') ? [] : ['className' => BuyDetailsTable::class];
        $this->BuyDetails = $this->getTableLocator()->get('BuyDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->BuyDetails);

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
