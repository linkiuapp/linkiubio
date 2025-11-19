<?php

namespace Tests\Feature\TenantAdmin;

use App\Features\TenantAdmin\Controllers\SliderController;
use App\Features\TenantAdmin\Models\Category;
use App\Features\TenantAdmin\Models\Product;
use App\Features\TenantAdmin\Services\SliderImageService;
use App\Shared\Models\Plan;
use App\Shared\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mockery;
use Tests\TestCase;

class SliderInternalLinksTest extends TestCase
{
    use RefreshDatabase;

    protected Plan $plan;
    protected Store $store;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plan = Plan::create([
            'name' => 'Plan Test',
            'description' => 'Plan de prueba',
            'duration_in_days' => 30,
            'max_products' => 100,
            'max_slider' => 10,
            'max_active_coupons' => 5,
            'max_categories' => 20,
            'max_sedes' => 1,
            'max_variables' => 15,
            'max_bank_accounts' => 2,
            'support_level' => 'basic',
            'support_response_time' => 24,
            'analytics_retention_days' => 90,
            'currency' => 'COP',
        ]);

        $this->store = Store::create([
            'plan_id' => $this->plan->id,
            'name' => 'Tienda Demo',
            'slug' => 'tienda-demo',
            'status' => 'active',
            'verified' => true,
            'email' => 'demo@linkiu.test',
        ]);

        view()->share('currentStore', $this->store);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_search_internal_links_requires_minimum_length(): void
    {
        $controller = new SliderController(Mockery::mock(SliderImageService::class));

        $request = Request::create('/internal-links/search', 'GET', ['q' => 'ab']);

        $response = $controller->searchInternalLinks($request);
        $data = $response->getData(true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertSame([], $data['results']);
        $this->assertEquals(3, $data['min_length']);
    }

    public function test_search_internal_links_returns_matching_categories_and_products(): void
    {
        Category::create([
            'name' => 'Camisas Hombre',
            'slug' => 'camisas-hombre',
            'store_id' => $this->store->id,
            'is_active' => true,
            'sort_order' => 0,
        ]);

        Product::create([
            'name' => 'Camisa Azul',
            'slug' => 'camisa-azul',
            'description' => 'Camisa casual azul',
            'price' => 120000,
            'type' => Product::TYPE_SIMPLE,
            'sku' => 'SKU-CAMISA-AZUL',
            'store_id' => $this->store->id,
            'is_active' => true,
        ]);

        $controller = new SliderController(Mockery::mock(SliderImageService::class));

        $request = Request::create('/internal-links/search', 'GET', ['q' => 'camisa']);

        $response = $controller->searchInternalLinks($request);
        $data = $response->getData(true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($data['results']);

        $categoryResult = collect($data['results'])->firstWhere('type', 'category');
        $this->assertNotNull($categoryResult);
        $this->assertSame('Camisas Hombre', $categoryResult['label']);
        $this->assertSame('/categoria/camisas-hombre', $categoryResult['url']);

        $productResult = collect($data['results'])->firstWhere('type', 'product');
        $this->assertNotNull($productResult);
        $this->assertSame('Camisa Azul', $productResult['label']);
        $this->assertSame('/producto/camisa-azul', $productResult['url']);
    }
}

