# Article Insert (Contao)

Frontend module for Contao that outputs the **published content elements of a selected article**.

Designed for theme- and template-driven setups (e.g. predefined layout blocks), where structure is handled by the theme and content is managed via Contao articles.

## Installation

Install via Contao Manager or Composer:

```bash
composer require article/insert
```

## Usage
Backend → Themes → Frontend Modules

1. Create a new frontend module
2. Select module type: Article Insert
3. Select a page (used to scope the article selection)
4. Save the module (required to populate the article list)
5. Select the article
6. Place the module in a layout section or template slot
