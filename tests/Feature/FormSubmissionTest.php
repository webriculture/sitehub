<?php

declare(strict_types=1);

use App\Mail\FormSubmissionReceived;
use App\Models\Tenant\Submission;
use App\Tenancy\Tenancy;
use Illuminate\Support\Facades\Mail;
use Tests\Concerns\ProvisionsSites;

uses(ProvisionsSites::class);

afterEach(fn () => $this->cleanupProvisionedSites());

it('stores a submission and emails the configured recipients', function (): void {
    Mail::fake();

    $site = $this->provisionSite('fs-a', ['forms']);
    $site->update(['settings' => ['form_recipients' => ['staff@example.org']]]);

    $response = $this->post('http://fs-a.test/forms/contact', [
        'name' => 'Maria Lopez',
        'email' => 'maria@example.com',
        'message' => 'Do you offer parenting classes?',
    ]);

    $response->assertRedirect('/?sent=contact');

    Tenancy::makeCurrent($site);

    expect(Submission::query()->count())->toBe(1)
        ->and(Submission::query()->first()->payload['name'])->toBe('Maria Lopez');

    Mail::assertSent(FormSubmissionReceived::class, fn ($mail) => $mail->hasTo('staff@example.org'));
});

it('pretends success for honeypot submissions without storing anything', function (): void {
    Mail::fake();

    $site = $this->provisionSite('fs-b', ['forms']);

    $this->post('http://fs-b.test/forms/contact', [
        'name' => 'Bot',
        'email' => 'bot@example.com',
        'message' => 'spam',
        'website' => 'http://spam.example',
    ])->assertRedirect('/?sent=contact');

    Tenancy::makeCurrent($site);

    expect(Submission::query()->count())->toBe(0);
    Mail::assertNothingSent();
});

it('returns a visible validation error for incomplete submissions', function (): void {
    $this->provisionSite('fs-c', ['forms']);

    $this->post('http://fs-c.test/forms/contact', ['name' => 'No Email'])
        ->assertRedirect('/?error=validation');
});

it('404s when the forms feature is disabled', function (): void {
    $this->provisionSite('fs-d');

    $this->post('http://fs-d.test/forms/contact', [
        'name' => 'X', 'email' => 'x@example.com', 'message' => 'hi',
    ])->assertNotFound();
});
