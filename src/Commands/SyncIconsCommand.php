<?php

declare(strict_types=1);

namespace Brunocfalcao\BladeFeatherIcons\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

final class SyncIconsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'feathericons:sync
                          {--npm-path= : Custom path to node_modules (defaults to base_path)}
                          {--dry-run : Preview changes without actually copying files}';

    /**
     * The console command description.
     */
    protected $description = 'Sync Feather Icons SVG files from npm package to the resources directory';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $npmPath = $this->option('npm-path') ?: base_path();
        $sourcePath = $npmPath . '/node_modules/feather-icons/dist/icons';
        $targetPath = __DIR__ . '/../../resources/svg';
        $isDryRun = $this->option('dry-run');

        // Check if source path exists
        if (! File::isDirectory($sourcePath)) {
            $this->components->error('Feather Icons npm package not found!');
            $this->line('');
            $this->line('Please install it first:');
            $this->line('  <fg=gray>npm install feather-icons --save-dev</>');
            $this->line('');
            $this->line('Or specify a custom path:');
            $this->line('  <fg=gray>php artisan feathericons:sync --npm-path=/path/to/project</>');

            return self::FAILURE;
        }

        // Check if target directory exists
        if (! File::isDirectory($targetPath)) {
            $this->components->error("Target directory does not exist: {$targetPath}");

            return self::FAILURE;
        }

        $this->components->info('Syncing Feather Icons...');
        $this->newLine();

        // Get all SVG files from source
        $sourceFiles = File::files($sourcePath);
        $stats = [
            'added' => 0,
            'updated' => 0,
            'unchanged' => 0,
            'total' => count($sourceFiles),
        ];

        $progressBar = $this->output->createProgressBar($stats['total']);
        $progressBar->start();

        foreach ($sourceFiles as $file) {
            $filename = $file->getFilename();
            $targetFile = $targetPath . '/' . $filename;

            // Check if file exists and compare content
            if (File::exists($targetFile)) {
                $sourceContent = File::get($file->getPathname());
                $targetContent = File::get($targetFile);

                if ($sourceContent === $targetContent) {
                    $stats['unchanged']++;
                } else {
                    $stats['updated']++;

                    if (! $isDryRun) {
                        File::copy($file->getPathname(), $targetFile);
                    }
                }
            } else {
                $stats['added']++;

                if (! $isDryRun) {
                    File::copy($file->getPathname(), $targetFile);
                }
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        // Display results
        if ($isDryRun) {
            $this->components->warn('DRY RUN - No files were actually copied');
            $this->newLine();
        }

        $this->displayStats($stats, $isDryRun);

        if ($stats['added'] > 0 || $stats['updated'] > 0) {
            if ($isDryRun) {
                $this->newLine();
                $this->line('Run without <fg=yellow>--dry-run</> to apply these changes.');
            } else {
                $this->components->success('Icons synced successfully!');
            }

            return self::SUCCESS;
        }

        $this->components->info('All icons are already up to date!');

        return self::SUCCESS;
    }

    /**
     * Display synchronization statistics.
     */
    private function displayStats(array $stats, bool $isDryRun): void
    {
        $verb = $isDryRun ? 'Would be' : 'Were';

        $this->components->twoColumnDetail(
            'Total icons',
            "<fg=blue>{$stats['total']}</>"
        );

        if ($stats['added'] > 0) {
            $this->components->twoColumnDetail(
                "{$verb} added",
                "<fg=green>{$stats['added']}</>"
            );
        }

        if ($stats['updated'] > 0) {
            $this->components->twoColumnDetail(
                "{$verb} updated",
                "<fg=yellow>{$stats['updated']}</>"
            );
        }

        if ($stats['unchanged'] > 0) {
            $this->components->twoColumnDetail(
                'Unchanged',
                "<fg=gray>{$stats['unchanged']}</>"
            );
        }
    }
}
