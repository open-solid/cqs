# Command-Query Separation implementation

Command-Query Separation (CQS) is a principle in software design that states a function should either 
be a command that performs an action (modifies state) or a query that returns data, but not both. 
This separation ensures clarity and predictability in code. Commands alter the state of the system, 
while queries provide information without causing side effects.

See more https://martinfowler.com/bliki/CommandQuerySeparation.html

## Installation

```bash
composer require open-solid/cqs
```

## License

This software is published under the [MIT License](LICENSE)
