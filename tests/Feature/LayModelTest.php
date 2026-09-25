<?php

namespace Tests\Feature;

use App\Models\Fabric;
use App\Models\FabricGroup;
use App\Models\LayModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LayModelTest extends TestCase
{
    use RefreshDatabase;

    private function user(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function setupRelationship(): array
    {
        $fabric = Fabric::factory()->create(['status' => 'active']);
        $group  = FabricGroup::factory()->create(['status' => 'active']);
        $group->fabrics()->attach($fabric);
        return [$fabric, $group];
    }

    private function layModelData(int $groupId, int $fabricId, array $overrides = []): array
    {
        return array_merge([
            'lay_model_code'  => 'LM-TEST',
            'lay_model_name'  => 'Test Lay Model',
            'fabric_group_id' => $groupId,
            'fabric_id'       => $fabricId,
            'lay_length'      => 12.5,
            'lay_width'       => 72,
            'number_of_plies' => 50,
            'garment_size'    => 'L',
            'marker_length'   => 11.8,
            'marker_width'    => 68,
            'status'          => 'active',
        ], $overrides);
    }

    public function test_lay_model_index_is_accessible(): void
    {
        $this->actingAs($this->user())->get(route('lay-models.index'))->assertStatus(200);
    }

    public function test_lay_model_create_page_is_accessible(): void
    {
        $this->actingAs($this->user())->get(route('lay-models.create'))->assertStatus(200);
    }

    public function test_user_can_create_lay_model(): void
    {
        [$fabric, $group] = $this->setupRelationship();

        $response = $this->actingAs($this->user())
            ->post(route('lay-models.store'), $this->layModelData($group->id, $fabric->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('lay_models', ['lay_model_code' => 'LM-TEST']);
    }

    public function test_lay_model_code_must_be_unique(): void
    {
        [$fabric, $group] = $this->setupRelationship();
        LayModel::factory()->create([
            'lay_model_code'  => 'LM-DUP',
            'fabric_group_id' => $group->id,
            'fabric_id'       => $fabric->id,
        ]);

        $response = $this->actingAs($this->user())
            ->post(route('lay-models.store'), $this->layModelData($group->id, $fabric->id, ['lay_model_code' => 'LM-DUP']));
        $response->assertSessionHasErrors('lay_model_code');
    }

    public function test_fabric_must_belong_to_selected_group(): void
    {
        [$fabric, $group] = $this->setupRelationship();

        // Create a different fabric NOT in the group
        $otherFabric = Fabric::factory()->create(['status' => 'active']);

        $response = $this->actingAs($this->user())
            ->post(route('lay-models.store'), $this->layModelData($group->id, $otherFabric->id));

        $response->assertSessionHasErrors('fabric_id');
    }

    public function test_lay_model_rejects_negative_lay_length(): void
    {
        [$fabric, $group] = $this->setupRelationship();
        $response = $this->actingAs($this->user())
            ->post(route('lay-models.store'), $this->layModelData($group->id, $fabric->id, ['lay_length' => -5]));
        $response->assertSessionHasErrors('lay_length');
    }

    public function test_lay_model_rejects_zero_plies(): void
    {
        [$fabric, $group] = $this->setupRelationship();
        $response = $this->actingAs($this->user())
            ->post(route('lay-models.store'), $this->layModelData($group->id, $fabric->id, ['number_of_plies' => 0]));
        $response->assertSessionHasErrors('number_of_plies');
    }

    public function test_user_can_view_lay_model(): void
    {
        [$fabric, $group] = $this->setupRelationship();
        $lm = LayModel::factory()->create([
            'fabric_group_id' => $group->id,
            'fabric_id'       => $fabric->id,
        ]);

        $this->actingAs($this->user())
            ->get(route('lay-models.show', $lm))
            ->assertStatus(200)
            ->assertSee($lm->lay_model_name);
    }

    public function test_user_can_update_lay_model(): void
    {
        [$fabric, $group] = $this->setupRelationship();
        $lm = LayModel::factory()->create([
            'lay_model_code'  => 'LM-UPD',
            'fabric_group_id' => $group->id,
            'fabric_id'       => $fabric->id,
        ]);

        $this->actingAs($this->user())
            ->put(route('lay-models.update', $lm), $this->layModelData($group->id, $fabric->id, [
                'lay_model_code' => 'LM-UPD',
                'lay_model_name' => 'Updated Lay Model',
            ]));

        $this->assertDatabaseHas('lay_models', ['id' => $lm->id, 'lay_model_name' => 'Updated Lay Model']);
    }

    public function test_user_can_delete_lay_model(): void
    {
        [$fabric, $group] = $this->setupRelationship();
        $lm = LayModel::factory()->create([
            'fabric_group_id' => $group->id,
            'fabric_id'       => $fabric->id,
        ]);

        $this->actingAs($this->user())->delete(route('lay-models.destroy', $lm));
        $this->assertDatabaseMissing('lay_models', ['id' => $lm->id]);
    }

    public function test_fabrics_by_group_ajax_endpoint(): void
    {
        [$fabric, $group] = $this->setupRelationship();

        $response = $this->actingAs($this->user())
            ->getJson(route('api.fabrics-by-group', ['fabric_group_id' => $group->id]));

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $fabric->id]);
    }

    public function test_fabrics_by_group_excludes_other_groups_fabrics(): void
    {
        [$fabric, $group] = $this->setupRelationship();
        $otherFabric = Fabric::factory()->create(['status' => 'active']);

        $response = $this->actingAs($this->user())
            ->getJson(route('api.fabrics-by-group', ['fabric_group_id' => $group->id]));

        $response->assertJsonFragment(['id' => $fabric->id]);
        $ids = collect($response->json())->pluck('id');
        $this->assertNotContains($otherFabric->id, $ids);
    }
}
