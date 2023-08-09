<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CancellationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CancellationsTable Test Case
 */
class CancellationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CancellationsTable
     */
    protected $Cancellations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Cancellations',
        'app.Users',
        'app.Usuarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Cancellations') ? [] : ['className' => CancellationsTable::class];
        $this->Cancellations = $this->getTableLocator()->get('Cancellations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Cancellations);

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
