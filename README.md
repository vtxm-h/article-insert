# Article Insert (Contao)

Reusable Contao frontend module that renders the published content elements of a selected article.

Designed for theme- and template-driven setups where structure is handled by templates, layout areas or structural content elements, while content is managed through Contao articles.


## Features

- Frontend module: **Article Insert**
- Select source page
- Select source article
- Outputs all published content elements from the selected article
- Useful for:
  - one-page layouts
  - custom template slots
  - reusable article-based content blocks
  - layout areas
- Theme-agnostic output
- Keeps content management inside Contao articles


## Usage

Backend -> Themes -> Frontend Modules

1. Create a new frontend module
2. Select module type: **Article Insert**
3. Select a page
4. Save the module
5. Select the article
6. Place the module in a layout section, custom template slot or page layout area

Note: In Contao 4.13, dependent select fields may require a save/reload step. This extension intentionally avoids Ajax to keep the implementation stable and predictable.


## Recommended Role

Use this bundle when you need to insert one article into another layout context.

Recommended separation:

- `article-insert` = article include module
- `layout-preset` = macro layout / split layout
- `content-grid` = micro layout / grid container
- `content-elements` = reusable content blocks


## Template

```text
mod_article_insert.html5
```


## Installation (via Composer / Contao Manager)

Add the package definition to your Contao project `composer.json` or install it via your configured repository setup.

Example package reference:

```json
{
  "repositories": [
    {
      "type": "package",
      "package": {
        "name": "vtxm-h/article-insert",
        "version": "1.1.5",
        "type": "contao-bundle",
        "license": "MIT",
        "dist": {
          "url": "https://github.com/vtxm-h/article-insert/archive/refs/tags/v1.1.5.zip",
          "type": "zip"
        },
        "autoload": {
          "psr-4": {
            "Vendor\\ArticleInsertBundle\\": "src/"
          }
        },
        "require": {
          "php": "^8.0",
          "contao/core-bundle": "^4.13",
          "contao/manager-plugin": "^2.0"
        },
        "extra": {
          "contao-manager-plugin": "Vendor\\ArticleInsertBundle\\ContaoManager\\Plugin"
        }
      }
    }
  ]
}
```

Install:

```bash
composer require vtxm-h/article-insert
```


## Compatibility

Contao 4.13
PHP 8.0+

## License

MIT
