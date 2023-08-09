<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FixedCostsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FixedCostsTable Test Case
 */
class FixedCostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FixedCostsTable
     */
    protected $FixedCosts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.FixedCosts',
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
        $config = $this->getTableLocator()->exists('FixedCosts') ? [] : ['className' => FixedCostsTable::class];
        $this->FixedCosts = $this->getTableLocator()->get('FixedCosts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->FixedCosts);

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
