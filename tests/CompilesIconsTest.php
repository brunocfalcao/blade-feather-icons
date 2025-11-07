<?php

declare(strict_types=1);

it('compiles a single anonymous component', function (): void {
    $result = svg('feathericon-wind')->toHtml();

    $expected = <<<'SVG'
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-wind"><path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2m15.73-8.27A2.5 2.5 0 1 1 19.5 12H2"></path></svg>
        SVG;

    expect($result)->toBe($expected);
});

it('can add classes to icons', function (): void {
    $result = svg('feathericon-wind', 'w-6 h-6 text-gray-500')->toHtml();

    $expected = <<<'SVG'
        <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-wind"><path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2m15.73-8.27A2.5 2.5 0 1 1 19.5 12H2"></path></svg>
        SVG;

    expect($result)->toBe($expected);
});

it('can add styles to icons', function (): void {
    $result = svg('feathericon-wind', ['style' => 'color: #555'])->toHtml();

    $expected = <<<'SVG'
        <svg style="color: #555" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-wind"><path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2m15.73-8.27A2.5 2.5 0 1 1 19.5 12H2"></path></svg>
        SVG;

    expect($result)->toBe($expected);
});

it('can add multiple attributes to icons', function (): void {
    $result = svg('feathericon-wind', [
        'class' => 'w-8 h-8',
        'style' => 'color: red',
        'aria-hidden' => 'true',
    ])->toHtml();

    expect($result)
        ->toContain('class="w-8 h-8"')
        ->toContain('style="color: red"')
        ->toContain('aria-hidden="true"')
        ->toContain('feather-wind');
});
