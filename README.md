### GITFLOW ###

***Branch prefixes***

Bugfix ``bugfix/FS-****``

Feature ``feature/FS-****``

Hotfix ``hotfix/FS-****``

Release ``release/FS-****``

***Commit Message Header***

`<type>(<scope>): <short summary>`

Commit Type: build|ci|docs|feat|fix|perf|refactor|test

Commit Scope: issue name `FS-****` or `hotfix`

Summary in present tense. Not capitalized. No period at the end.

The `<type>` and (`<scope>`) fields are mandatory.

Example: `fix(FS-0000): some text`

### Automatic PHPDoc generation for Laravel Facades

You can now re-generate the docs yourself (for future updates)

```bash

php artisan ide-helper:generate

```

_Check out [this Laracasts video](https://laracasts.com/series/how-to-be-awesome-in-phpstorm/episodes/15) for a quick introduction/explanation!_

- [`php artisan ide-helper:generate` - PHPDoc generation for Laravel Facades ](https://github.com/barryvdh/laravel-ide-helper#automatic-phpdoc-generation-for-laravel-facades)
- [`php artisan ide-helper:models` - PHPDocs for models](https://github.com/barryvdh/laravel-ide-helper#automatic-PHPDocs-for-models)
- [`php artisan ide-helper:meta` - PhpStorm Meta file](https://github.com/barryvdh/laravel-ide-helper#phpstorm-meta-for-container-instances)


Note: You do need CodeComplice for Sublime Text: https://github.com/spectacles/CodeComplice

### Phpcsfixer

```console
$ ./vendor/bin/php-cs-fixer fix --config=.php_cs.php
```

See [usage](https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/3.0/doc/config.rst), list of [built-in rules](https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/3.0/doc/rules/index.rst), list of [rule sets](https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/3.0/doc/ruleSets/index.rst)

and [configuration file](https://github.com/FriendsOfPHP/PHP-CS-Fixer/blob/3.0/doc/config.rst) documentation for more details.

### Psalm

```console
$ ./vendor/bin/psalm
```

See [usage](https://github.com/vimeo/psalm/blob/4.x/docs/running_psalm/command_line_usage.md)