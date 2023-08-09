<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SaleForDaysTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SaleForDaysTable Test Case
 */
class SaleForDaysTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SaleForDaysTable
     */
    protected $SaleForDays;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.SaleForDays',
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
        $config = $this->getTableLocator()->exists('SaleForDays') ? [] : ['className' => SaleForDaysTable::class];
        $this->SaleForDays = $this->getTableLocator()->get('SaleForDays', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->SaleForDays);

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
