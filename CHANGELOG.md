# Release Notes for Craft Base

## 1.0.1 - 2026-07-16

### Changed
- Removed `declare(strict_types=1)` from all files — Craft's internal type coercion depends on PHP's default weak typing mode.

## 1.0.0 - 2026-07-16

### Added
- Initial release: base Plugin class, per-plugin file logging via `LogTrait`, web/console controller traits, `configWarning` settings macro, and Pest testing helpers.
