# D2U History - Redaxo Addon

A Redaxo 5 CMS addon for managing and displaying a company timeline/history with multilingual support. Provides a visual timeline module for the frontend.

## Tech Stack

- **Language:** PHP >= 8.0
- **CMS:** Redaxo >= 5.19.0 (via d2u_helper)
- **Frontend Framework:** Bootstrap 4/5 (via d2u_helper templates)
- **Namespace:** `TobiasKrais\D2UHistory`

## Project Structure

```text
d2u_history/
├── boot.php               # Addon bootstrap (extension points, permissions)
├── install.php             # Installation (database tables, sprog wildcards)
├── update.php              # Update (calls install.php, utf8mb4 conversion)
├── uninstall.php           # Cleanup (database tables, sprog wildcards)
├── package.yml             # Addon configuration, version, dependencies
├── lang/                   # Backend translations (de_de, en_gb)
├── lib/                    # PHP classes
│   ├── History.php         # History event model (multilingual)
│   ├── LangHelper.php      # Sprog wildcard provider (6 languages)
│   ├── Module.php          # Module definitions and revisions
│   └── deprecated_classes.php  # Backward compatibility (until 2.0.0)
├── modules/                # 1 module in group 21
│   └── 21/
│       └── 1/              # Timeline output
│           ├── input.php
│           ├── output.php
│           └── style.css
└── pages/                  # Backend pages
    ├── index.php           # Page router
    ├── history.php         # History event management (CRUD, status)
    ├── settings.php        # Addon settings (sprog languages)
    └── setup.php           # Module manager + changelog
```

## Coding Conventions

- **Namespace:** `TobiasKrais\D2UHistory` for all classes
- **Deprecated Namespace:** `D2U_History` (backward compatibility, removal planned for 2.0.0)
- **Naming:** camelCase for variables, PascalCase for classes
- **Indentation:** 4 spaces in PHP classes, tabs in module files
- **Comments:** English comments only
- **Frontend labels:** Use `Sprog\Wildcard::get()` backed by `LangHelper`, not `rex_i18n::msg()`
- **Backend labels:** Use `rex_i18n::msg()` with keys from `lang/` files

## AGENTS.md Maintenance

- When new project insights are gained during work and they are relevant to agent guidance, workflows, conventions, architecture, or known pitfalls, update this AGENTS.md accordingly.

## Key Classes

| Class | Description |
| ----- | ----------- |
| `History` | History event model: name, year, picture, description, online status. Implements `ITranslationHelper` |
| `LangHelper` | Sprog wildcard provider for 6 languages (DE, EN, FR, ES, RU, ZH). Single wildcard: `d2u_history_interactive_time_travel` |
| `Module` | Module definitions: 1 module (21-1, Timeline) |

## Database Tables

| Table | Description |
| ----- | ----------- |
| `rex_d2u_history` | History events (language-independent): name, year, picture, online status |
| `rex_d2u_history_lang` | History events (language-specific): description, translation status |

## Architecture

### Extension Points

| Extension Point | Location | Purpose |
| --------------- | -------- | ------- |
| `D2U_HELPER_TRANSLATION_LIST` | boot.php (backend) | Registers addon in D2U Helper translation manager |
| `CLANG_DELETED` | boot.php (backend) | Cleans up language-specific data when a language is deleted |
| `MEDIA_IS_IN_USE` | boot.php (backend) | Prevents deletion of media files used by history events |

### Modules

1 module in group 21:

| Module | Name | Description |
| ------ | ---- | ----------- |
| 21-1 | D2U History - Timeline | Visual timeline output |

#### Module Versioning

Each module has a revision number defined in `lib/Module.php` inside the `getModules()` method. When a module is changed:

1. Add a changelog entry in `pages/setup.php` describing the change.
2. Increment the module's revision number in `Module::getModules()` by one.

**Important:** The revision only needs to be incremented **once per release**, not per commit. Check the changelog: if the version number is followed by `-DEV`, the release is still in development and no additional revision bump is needed.

## Settings

Managed via `pages/settings.php` and stored in `rex_config`:

- `lang_wildcard_overwrite` — Preserve custom Sprog translations
- `lang_replacement_{clang_id}` — Language mapping per REDAXO language (6 languages)

## Dependencies

| Package | Version | Purpose |
| ------- | ------- | ------- |
| `d2u_helper` | >= 1.14.0 | Backend/frontend helpers, module manager, translation interface |

## Multi-language Support

- **Backend:** de_de, en_gb
- **Frontend (Sprog Wildcards):** DE, EN, FR, ES, RU, ZH (6 languages)

## Versioning

This addon follows [Semantic Versioning](https://semver.org/). The version number is maintained in `package.yml`. During development, the changelog uses a `-DEV` suffix.

## Changelog

The changelog is located in `pages/setup.php`.
