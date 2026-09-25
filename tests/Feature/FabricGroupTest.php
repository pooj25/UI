<?php

namespace Tests\Feature;

use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\LayModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FabricGroupTest extends TestCase
{
    use RefreshDatabase;

    private function user(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function groupData(array $fabrics = [], array $overrides = []): array
    {
        return array_merge([
            'group_code'  => 'FG-TEST',
            'group_name'  => 'Test Group',
            'description' => 'Test description',
            'status'      => 'active',
            'fabrics'     => $fabrics,
        ], $overrides);
    }

    public function test_fabric_group_index_is_accessible(): void
    {
        $this->actingAs($this->user())->get(route('fabric-groups.index'))->assertStatus(200);
    }

    public function test_fabric_group_create_page_is_accessible(): void
    {
        $this->actingAs($this->user())->get(route('fabric-groups.create'))->assertStatus(200);
    }

    public function test_user_can_create_fabric_group_with_fabrics(): void
    {
        $fabrics = Fabric::factory()->count(3)->create();
        $ids = $fabrics->pluck('id')->toArray();

        $response = $this->actingAs($this->user())
            ->post(route('fabric-groups.store'), $this->groupData($ids));

        $response->assertRedirect();
        $this->assertDatabaseHas('fabric_groups', ['group_code' => 'FG-TEST']);

        $group = FabricGroup::where('group_code', 'FG-TEST')->first();
        $this->assertCount(3, $group->fabrics);
    }

    public function test_group_requires_at_least_one_fabric(): void
    {
        $response = $this->actingAs($this->user())
            ->post(route('fabric-groups.store'), $this->groupData([]));
        $response->assertSessionHasErrors('fabrics');
    }

    public function test_group_code_must_be_unique(): void
    {
        $fabric = Fabric::factory()->create();
        FabricGroup::factory()->create(['group_code' => 'FG-DUP']);

        $response = $this->actingAs($this->user())
            ->post(route('fabric-groups.store'), $this->groupData([$fabric->id], ['group_code' => 'FG-DUP']));
        $response->assertSessionHasErrors('group_code');
    }

    public function test_group_name_is_required(): void
    {
        $fabric = Fabric::factory()->create();
        $response = $this->actingAs($this->user())
            ->post(route('fabric-groups.store'), $this->groupData([$fabric->id], ['group_name' => '']));
        $response->assertSessionHasErrors('group_name');
    }

    public function test_user_can_view_fabric_group(): void
    {
        $group = FabricGroup::factory()->create();
        $this->actingAs($this->user())
            ->get(route('fabric-groups.show', $group))
            ->assertStatus(200)
            ->assertSee($group->group_name);
    }

    public function test_user_can_add_fabric_to_group(): void
    {
        $group  = FabricGroup::factory()->create();
        $fabric = Fabric::factory()->create(['status' => 'active']);

        $this->actingAs($this->user())
            ->post(route('fabric-groups.add-fabric', $group), ['fabric_id' => $fabric->id]);

        $this->assertDatabaseHas('fabric_group_fabric', [
            'fabric_group_id' => $group->id,
            'fabric_id'       => $fabric->id,
        ]);
    }

    public function test_user_can_remove_fabric_from_group(): void
    {
        $group  = FabricGroup::factory()->create();
        $fabric = Fabric::factory()->create();
        $group->fabrics()->attach($fabric);

        $this->actingAs($this->user())
            ->delete(route('fabric-groups.remove-fabric', [$group, $fabric]));

        $this->assertDatabaseMissing('fabric_group_fabric', [
            'fabric_group_id' => $group->id,
            'fabric_id'       => $fabric->id,
        ]);
    }

    public function test_group_with_lay_models_cannot_be_deleted(): void
    {
        $group  = FabricGroup::factory()->create();
        $fabric = Fabric::factory()->create();
        $group->fabrics()->attach($fabric);
        LayModel::factory()->create(['fabric_group_id' => $group->id, 'fabric_id' => $fabric->id]);

        $response = $this->actingAs($this->user())
            ->delete(route('fabric-groups.destroy', $group));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('fabric_groups', ['id' => $group->id]);
    }

    public function test_user_can_update_fabric_group(): void
    {
        $group  = FabricGroup::factory()->create(['group_code' => 'FG-UPD']);
        $fabric = Fabric::factory()->create(['status' => 'active']);

        $this->actingAs($this->user())
            ->put(route('fabric-groups.update', $group), $this->groupData([$fabric->id], [
                'group_code' => 'FG-UPD',
                'group_name' => 'Updated Group Name',
            ]));

        $this->assertDatabaseHas('fabric_groups', ['id' => $group->id, 'group_name' => 'Updated Group Name']);
    }
}
