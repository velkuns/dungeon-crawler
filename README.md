# eureka-application
Template application for base web site.


## Contributing

See the [CONTRIBUTING](CONTRIBUTING.md) file.


### Install / update project

You can install project with the following command:
```bash
make install
```

And update with the following command:
```bash
make update
```

NB: For the components, the `composer.lock` file is not committed.

### Testing & CI (Continuous Integration)

#### Tests
You can run unit tests (with coverage) on your side with following command:
```bash
make tests
```

You can run integration tests (without coverage) on your side with following command:
```bash
make integration
```

For prettier output (but without coverage), you can use the following command:
```bash
make testdox # run tests without coverage reports but with prettified output
```

#### Code Style
You also can run code style check with following commands:
```bash
make phpcs
```

You also can run code style fixes with following commands:
```bash
make phpcsf
```

#### Check for missing explicit dependencies
You can check if any explicit dependency is missing with the following command:
```bash
make deps
```

#### Static Analysis
To perform a static analyze of your code (with phpstan, lvl 9 at default), you can use the following command:
```bash
make analyse
```

To ensure you code still compatible with current supported version at Deezer and futures versions of php, you need to
run the following commands (both are required for full support):

Minimal supported version:
```bash
make php81compatibility
```

Maximal supported version:
```bash
make php83compatibility
```

#### CI Simulation
And the last "helper" commands, you can run before commit and push, is:
```bash
make ci  
```

## License

This project is currently under The MIT License (MIT). See [LICENCE](LICENSE) file for more information.
