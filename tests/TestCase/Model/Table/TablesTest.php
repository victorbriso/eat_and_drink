<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\Tables;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\Tables Test Case
 */
class TablesTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\Tables
     */
    protected $Tables;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('s') ? [] : ['className' => Tables::class];
        $this->Tables = $this->getTableLocator()->get('s', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Tables);

        parent::tearDown();
    }
}
