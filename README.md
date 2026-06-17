# Forge Starters

This repository contains the official starter kits for the Forge PHP framework.

## Available Starters

| Starter     | Description                                                                              |
| ----------- | ---------------------------------------------------------------------------------------- |
| **blank**   | Minimal Forge project with just the package manager. Ideal for building from scratch.    |
| **minimal** | Full-featured starter with package manager and welcome page. Ready for web applications. |

## Structure

```
starters/
├── blank/           # Blank starter source files
└── minimal/         # Minimal starter source files
```

## Publishing a Version

Use the Forge CLI to build and publish a new starter version:

```bash
php forge.php dev:starter:version --name=<starter-name>
```

This will create a ZIP archive and update the starters.json manifest.
