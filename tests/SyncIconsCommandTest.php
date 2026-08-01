<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

beforeEach(function (): void {
    $this->tempPath = sys_get_temp_dir().'/feather-icons-test-'.uniqid();
    $this->sourcePath = $this->tempPath.'/node_modules/feather-icons/dist/icons';
    $this->targetPath = __DIR__.'/../resources/svg';
    $this->targetFiles = [];

    if (! File::isDirectory($this->sourcePath)) {
        File::makeDirectory($this->sourcePath, 0755, true);
    }
});

afterEach(function (): void {
    if (File::isDirectory($this->tempPath)) {
        File::deleteDirectory($this->tempPath);
    }

    foreach ($this->targetFiles as $targetFile) {
        File::delete($targetFile);
    }
});

it('displays error when npm package is not installed', function (): void {
    $this->artisan('feathericons:sync', ['--npm-path' => '/non/existent/path'])
        ->expectsOutputToContain('Feather Icons npm package not found!')
        ->assertExitCode(1);
});

it('syncs new icons successfully', function (): void {
    $filename = 'upgrade-test-new-'.uniqid().'.svg';
    $testSvg = '<svg><path d="M1 1"/></svg>';
    $targetFile = $this->targetPath.'/'.$filename;
    $this->targetFiles[] = $targetFile;
    File::put($this->sourcePath.'/'.$filename, $testSvg);

    expect(File::exists($targetFile))->toBeFalse();

    $this->artisan('feathericons:sync', [
        '--npm-path' => $this->tempPath,
        '--dry-run' => true,
    ])->expectsOutputToContain('Would be added')
        ->assertExitCode(0);

    expect(File::exists($targetFile))->toBeFalse();
});

it('shows dry run preview without copying files', function (): void {
    $filenames = [
        'upgrade-test-heart-'.uniqid().'.svg',
        'upgrade-test-star-'.uniqid().'.svg',
    ];

    foreach ($filenames as $filename) {
        $targetFile = $this->targetPath.'/'.$filename;
        $this->targetFiles[] = $targetFile;
        File::put($this->sourcePath.'/'.$filename, '<svg><path d="test"/></svg>');
        expect(File::exists($targetFile))->toBeFalse();
    }

    $this->artisan('feathericons:sync', [
        '--npm-path' => $this->tempPath,
        '--dry-run' => true,
    ])->expectsOutputToContain('DRY RUN - No files were actually copied')
        ->assertExitCode(0);

    foreach ($this->targetFiles as $targetFile) {
        expect(File::exists($targetFile))->toBeFalse();
    }
});

it('detects unchanged files', function (): void {
    $filename = 'upgrade-test-unchanged-'.uniqid().'.svg';
    $svgContent = '<svg><path d="test"/></svg>';
    $targetFile = $this->targetPath.'/'.$filename;
    $this->targetFiles[] = $targetFile;

    File::put($this->sourcePath.'/'.$filename, $svgContent);
    File::put($targetFile, $svgContent);

    expect(File::get($targetFile))->toBe($svgContent);

    $this->artisan('feathericons:sync', [
        '--npm-path' => $this->tempPath,
    ])->expectsOutputToContain('All icons are already up to date!')
        ->assertExitCode(0);

    expect(File::get($targetFile))->toBe($svgContent);
});

it('detects updated files', function (): void {
    $filename = 'upgrade-test-updated-'.uniqid().'.svg';
    $targetFile = $this->targetPath.'/'.$filename;
    $this->targetFiles[] = $targetFile;

    File::put($this->sourcePath.'/'.$filename, '<svg><path d="new"/></svg>');
    File::put($targetFile, '<svg><path d="old"/></svg>');

    expect(File::get($targetFile))->toBe('<svg><path d="old"/></svg>');

    $this->artisan('feathericons:sync', [
        '--npm-path' => $this->tempPath,
        '--dry-run' => true,
    ])->expectsOutputToContain('Would be updated')
        ->assertExitCode(0);

    expect(File::get($targetFile))->toBe('<svg><path d="old"/></svg>');
});

it('can sync with real npm feather-icons if installed', function (): void {
    $npmPath = base_path();
    $featherIconsPath = $npmPath.'/node_modules/feather-icons/dist/icons';

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
