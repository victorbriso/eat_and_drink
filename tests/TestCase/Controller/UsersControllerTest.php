<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Users',
        'app.Bookings',
        'app.BuyDetails',
        'app.BuySummaries',
        'app.Cancellations',
        'app.CashboxMovements',
        'app.Cashboxes',
        'app.Categories',
        'app.Cellars',
        'app.Comandas',
        'app.FixedCosts',
        'app.FolioCashes',
        'app.Folios',
        'app.HistoricalCommands',
        'app.InventoryMovements',
        'app.Orders',
        'app.PlaceElaborations',
        'app.PriceListControls',
        'app.PriceLists',
        'app.Products',
        'app.Profiles',
        'app.SaleForDays',
        'app.Salons',
        'app.Tables',
        'app.Usuarios',
        'app.Vendors',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
