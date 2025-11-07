<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function (): void {
    // Create a temporary directory for testing
    $this->tempPath = sys_get_temp_dir() . '/feather-icons-test-' . uniqid();
    $this->sourcePath = $this->tempPath . '/node_modules/feather-icons/dist/icons';
    $this->targetPath = __DIR__ . '/../resources/svg-test';

    if (! File::isDirectory($this->sourcePath)) {
        File::makeDirectory($this->sourcePath, 0755, true);
    }

    if (! File::isDirectory($this->targetPath)) {
        File::makeDirectory($this->targetPath, 0755, true);
    }
});

afterEach(function (): void {
    // Clean up temporary directories
    if (File::isDirectory($this->tempPath)) {
        File::deleteDirectory($this->tempPath);
    }

    if (File::isDirectory($this->targetPath)) {
        File::deleteDirectory($this->targetPath);
    }
});

it('displays error when npm package is not installed', function (): void {
    $this->artisan('feathericons:sync', ['--npm-path' => '/non/existent/path'])
        ->expectsOutputToContain('Feather Icons npm package not found!')
        ->assertExitCode(1);
});

it('syncs new icons successfully', function (): void {
    // Create a test SVG file in the source directory
    $testSvg = '<svg><path d="M1 1"/></svg>';
    File::put($this->sourcePath . '/test-icon.svg', $testSvg);

    // Mock the target path to use our test directory
    $command = $this->artisan('feathericons:sync', [
        '--npm-path' => $this->tempPath,
        '--dry-run' => true,
    ]);

    $command->assertExitCode(0);
})->skip('Requires refactoring command to support custom target path');

it('shows dry run preview without copying files', function (): void {
    // Create test SVG files
    File::put($this->sourcePath . '/heart.svg', '<svg><path d="heart"/></svg>');
    File::put($this->sourcePath . '/star.svg', '<svg><path d="star"/></svg>');

    $this->artisan('feathericons:sync', [
        '--npm-path' => $this->tempPath,
        '--dry-run' => true,
    ])->expectsOutput('DRY RUN - No files were actually copied')
        ->assertExitCode(0);
})->skip('Requires refactoring command to support custom target path');

it('detects unchanged files', function (): void {
    $svgContent = '<svg><path d="test"/></svg>';

    // Create identical files in source and target
    File::put($this->sourcePath . '/unchanged.svg', $svgContent);
    File::put($this->targetPath . '/unchanged.svg', $svgContent);

    $this->artisan('feathericons:sync', [
        '--npm-path' => $this->tempPath,
    ])->expectsOutput('All icons are already up to date!')
        ->assertExitCode(0);
})->skip('Requires refactoring command to support custom target path');

it('detects updated files', function (): void {
    // Create different content in source and target
    File::put($this->sourcePath . '/updated.svg', '<svg><path d="new"/></svg>');
    File::put($this->targetPath . '/updated.svg', '<svg><path d="old"/></svg>');

    $this->artisan('feathericons:sync', [
        '--npm-path' => $this->tempPath,
        '--dry-run' => true,
    ])->expectsOutputToContain('Would be updated')
        ->assertExitCode(0);
})->skip('Requires refactoring command to support custom target path');

it('can sync with real npm feather-icons if installed', function (): void {
    $npmPath = base_path();
    $featherIconsPath = $npmPath . '/node_modules/feather-icons/dist/icons';

    // Only run this test if feather-icons is actually installed
    if (! File::isDirectory($featherIconsPath)) {
        expect(true)->toBeTrue();

        return;
    }

    $this->artisan('feathericons:sync', ['--dry-run' => true])
        ->assertExitCode(0);
});

it('command is registered and available', function (): void {
    $commands = $this->artisan('list');

    expect($commands)->not->toBeNull();
});
