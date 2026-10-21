# packages/brunocfalcao/blade-feather-icons — Project Guidance

Shared project instructions for Codex and Claude.

## Purpose and boundaries

A package to easily make use of Feather Icons in your Laravel Blade views.

## Documentation

Start with `README.md`. No matching canonical `~/Herd/docs/<project>` directory was found. Use local documentation and current source; do not borrow another product’s requirements.

## Working rules

- Address Bruno directly and use concise caveman full communication; code, commits, and PR descriptions remain professional language.
- Read relevant source, callers, configuration, tests, and scoped instructions before editing. Current code wins over unsupported documentation; planned and historical behavior must be labeled.
- Follow the closest working implementation. Keep changes within Bruno's requested product behavior; preserve unrelated dirty work and user data.
- Bruno owns product decisions. The agent owns technical choices. Ask about material product ambiguity, not class names or file placement.
- Never commit, push, deploy, send messages, or perform destructive operations unless the task authorizes them. Never expose credentials.
- Run the smallest relevant existing executable checks. Ordinary implementation defers new coverage to the release pass; authentication, privacy, billing, data integrity, concurrency, and production regressions require immediate coverage. Do not claim browser/device/provider acceptance without observing it.
- Resolve shared `do` workflows from `~/Herd/.dynamic-commands/` freshly. Read applicable global rules and project/nested instructions. Keep handoffs concise and outcome-first.

## Dependency contract

Manifest requirements: PHP `^8.4`, `illuminate/support` `^12.0|^13.0`. Exact resolved versions come from `composer.lock`; runtime versions require a fresh check.

## Code map

`src/`, `tests/`. Inspect these entrypoints and their actual callers for the area being changed.

## Verification

Available entrypoints: `composer test`, `composer test:full`. Choose the narrowest relevant check; a listed full-suite, build, install, or packaging command is not an instruction to run it for every edit. Inspect test environment and side effects first.

Orientation examples read: `src/BladeFeatherIconsServiceProvider.php`, `tests/CompilesIconsTest.php`. Re-read the closest example for the actual task rather than copying an unrelated one.

## Keep this file current

Please update `PROJECT.md` whenever project guidelines, architecture, workflows,
or verified constraints change. Correct documentation that is not supported by
current codebase evidence; codebase wins. Distinguish implemented behavior from
plans and historical records. Keep `AGENTS.md` and `CLAUDE.md` as thin pointers
to this shared file so Codex and Claude follow the same project guidance.
