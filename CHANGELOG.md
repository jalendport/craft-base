# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/).

## Unreleased

## 1.1.1 - 2026-07-16

### Fixed
- Fixed a bug where the `configWarning()` macro's message could not be translated

## 1.1.0 - 2026-07-16

### Added
- Added `Plugin::getConfigOverrides()`, listing the settings overridden in `config/<handle>.php`

## 1.0.1 - 2026-07-16

### Changed
- Changed all files to drop `declare(strict_types=1)`, which conflicts with Craft's internal type coercion

## 1.0.0 - 2026-07-16

### Added
- Added the initial release: base Plugin class, per-plugin logging via `LogTrait`, web and console controller traits, the `configWarning` settings macro, and Pest testing helpers
