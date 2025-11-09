<?php

namespace Tests\Feature;

use App\Models\Application;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function test_guest_cannot_create_application()
    {
        $application = Application::factory()->make();

        $this->postJson('/api/applications', [
            $application,
        ])
            ->assertUnauthorized();
    }

    public function test_authenticated_user_can_create_application()
    {
        $this->authenticated();

        $application = Application::factory()->create();

        $this->postJson('/api/applications', $application->toArray())
            ->assertStatus(201)
            ->assertJson(
                fn (AssertableJson $json) => $json->where('message', 'Application created successfully')
            );

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'position' => $application->position,
            'link' => $application->link,
            'contact' => $application->contact,
            'applied_date' => $application->applied_date,
            'interview_date' => $application->interview_date,
            'salary' => $application->salary,
            'feedback' => $application->feedback,
            'status_id' => $application->status_id,
            'company_id' => $application->company_id,
            'city_id' => $application->city_id,
            'modality_id' => $application->modality_id,
            'contract_id' => $application->contract_id,
            'category_id' => $application->category_id,
        ]);
    }

    public function test_application_can_be_searchable()
    {
        $this->authenticated();

        Application::factory()->create(['position' => 'Application one']);
        Application::factory()->create(['position' => 'Application two']);

        $this->getJson('/api/applications?search=one')
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json->has(
                    'data.0',
                    fn ($item) => $item->where('position', 'Application one')
                        ->hasAll([
                            'link',
                            'contact',
                            'applied_date',
                            'interview_date',
                            'salary',
                            'feedback',
                        ])
                        ->etc()
                )
                    ->has(
                        'links',
                        fn (AssertableJson $links) => $links->hasAll(['first', 'last', 'prev', 'next'])
                    )
                    ->hasAll(['meta', 'links'])
            );
    }

    public function test_update_application()
    {
        $this->authenticated();

        $application = Application::factory()->create(['position' => 'Application one']);

        $this->putJson("/api/applications/{$application->id}", [
            'position' => 'Application two',
        ])
            ->assertOk()
            ->assertJson([
                'data' => [
                    'position' => 'Application two',
                ],
            ]);
    }

    public function test_delete_application()
    {
        $this->authenticated();

        $application = Application::factory()->create();

        $this->deleteJson("/api/applications/{$application->id}")
            ->assertOk()
            ->assertJson([
                'message' => 'Application deleted successfully',
            ]);
    }

    public function test_cannot_delete_non_existing_company()
    {
        $this->authenticated();
        $this->deleteJson('/api/applications/999')
            ->assertNotFound();
    }
}
