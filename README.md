# Command line applications

A simple base point for command line applications

```sh
composer create-project corley/cli ./my-app ~1
```

## Environment variables

Environment variable should be prefixed with: `APP__` and those variables will
be propagated as parameters

```sh
APP__HELLO=walter ./bin/console app:hello
Hello walter!
```

Rules:

 * variables are replaces as lowercase
   * `APP__WALTER=test -> setParameter('walter,'test');`
 * `_` remains `_`
   * `APP__WALTER_TEST=test -> setParameter('walter_test', 'test');`
 * `__` will be `.`
   * `APP__WALTER__TEST=test -> setParameter('walter.test', 'test');`

