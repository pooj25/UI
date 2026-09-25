<?php

namespace Tests\Feature;

use App\Models\Fabric;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FabricTest extends TestCase
{
    use RefreshDatabase;

    private function user(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function fabricData(array $overrides = []): array
    {
        return array_merge([
            'fabric_code' => 'FAB-TEST',
            'fabric_name' => 'Test Fabric',
            'fabric_type' => 'Knitted',
            'composition' => '100% Cotton',
            'color'       => 'White',
            'gsm'         => 180,
            'width'       => 72,
            'unit'        => 'KG',
            'status'      => 'active',
        ], $overrides);
    }

    public function test_fabric_index_is_accessible(): void
    {
        $this->actingAs($this->user())->get(route('fabrics.index'))->assertStatus(200);
    }

    public function test_fabric_create_page_is_accessible(): void
    {
        $this->actingAs($this->user())->get(route('fabrics.create'))->assertStatus(200);
    }

    public function test_user_can_create_fabric(): void
    {
        $response = $this->actingAs($this->user())->post(route('fabrics.store'), $this->fabricData());

        $response->assertRedirect();
        $this->assertDatabaseHas('fabrics', ['fabric_code' => 'FAB-TEST', 'fabric_name' => 'Test Fabric']);
    }

    public function test_fabric_code_must_be_unique(): void
    {
        Fabric::factory()->create(['fabric_code' => 'FAB-DUP']);
        $response = $this->actingAs($this->user())
            ->post(route('fabrics.store'), $this->fabricData(['fabric_code' => 'FAB-DUP']));
        $response->assertSessionHasErrors('fabric_code');
    }

    public function test_fabric_name_is_required(): void
    {
        $response = $this->actingAs($this->user())
            ->post(route('fabrics.store'), $this->fabricData(['fabric_name' => '']));
        $response->assertSessionHasErrors('fabric_name');
    }

    public function test_fabric_code_is_required(): void
    {
        $response = $this->actingAs($this->user())
            ->post(route('fabrics.store'), $this->fabricData(['fabric_code' => '']));
        $response->assertSessionHasErrors('fabric_code');
    }

    public function test_fabric_type_is_required(): void
    {
        $response = $this->actingAs($this->user())
            ->post(route('fabrics.store'), $this->fabricData(['fabric_type' => '']));
        $response->assertSessionHasErrors('fabric_type');
    }

    public function test_gsm_must_be_numeric(): void
    {
        $response = $this->actingAs($this->user())
            ->post(route('fabrics.store'), $this->fabricData(['gsm' => 'abc']));
        $response->assertSessionHasErrors('gsm');
    }

    public function test_gsm_cannot_be_negative(): void
    {
        $response = $this->actingAs($this->user())
            ->post(route('fabrics.store'), $this->fabricData(['gsm' => -10]));
        $response->assertSessionHasErrors('gsm');
    }

    public function test_user_can_view_fabric(): void
    {
        $fabric = Fabric::factory()->create();
        $this->actingAs($this->user())
            ->get(route('fabrics.show', $fabric))
            ->assertStatus(200)
            ->assertSee($fabric->fabric_name);
    }

    public function test_user_can_update_fabric(): void
    {
        $fabric = Fabric::factory()->create(['fabric_code' => 'FAB-UP']);
        $this->actingAs($this->user())
            ->put(route('fabrics.update', $fabric), $this->fabricData([
                'fabric_code' => 'FAB-UP',
                'fabric_name' => 'Updated Name',
            ]));
        $this->assertDatabaseHas('fabrics', ['id' => $fabric->id, 'fabric_name' => 'Updated Name']);
    }

    public function test_user_can_soft_delete_fabric(): void
    {
        $fabric = Fabric::factory()->create();
        $this->actingAs($this->user())->delete(route('fabrics.destroy', $fabric));
        $this->assertSoftDeleted('fabrics', ['id' => $fabric->id]);
    }

    public function test_fabric_in_use_cannot_be_deleted(): void
    {
        $fabric = Fabric::factory()->create();
        $group  = \App\Models\FabricGroup::factory()->create();
        $group->fabrics()->attach($fabric);
        \App\Models\LayModel::factory()->create([
            'fabric_id'       => $fabric->id,
            'fabric_group_id' => $group->id,
        ]);

        $response = $this->actingAs($this->user())->delete(route('fabrics.destroy', $fabric));
        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('fabrics', ['id' => $fabric->id, 'deleted_at' => null]);
    }

    public function test_fabric_search_works(): void
    {
        Fabric::factory()->create(['fabric_name' => 'Unique Cotton Fabric']);
        Fabric::factory()->create(['fabric_name' => 'Polyester Sheet']);

        $response = $this->actingAs($this->user())
            ->get(route('fabrics.index', ['search' => 'Unique Cotton']));
        $response->assertSee('Unique Cotton Fabric');
        $response->assertDontSee('Polyester Sheet');
    }
}
