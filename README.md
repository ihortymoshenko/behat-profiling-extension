# behat-profiling-extension #

## Overview ##

The Behat extension that allows you to profile Behat steps.

## Installation ##

### 1. Using Composer (recommended) ###

To install `behat-profiling-extension` with [Composer][1] just add the
following to your `composer.json` file:

```json
{
    "require-dev": {
        "imt/behat-profiling-extension": "0.9.*"
    }
}
```

Then, you can install the new dependencies by running Composer's update command
from the directory where your `composer.json` file is located:

```sh
$ php composer.phar update imt/behat-profiling-extension
```

Now, Composer will automatically download all required files, and install them
for you.

## Usage ##

To enable `behat-profiling-extension` just add the following to your
`behat.yml` file:

```yml
default:
    extensions:
        IMT\BehatProfilingExtension\Extension: ~
```

That's all!

If you want to disable/enable the extension depending of environment you can use `use_env` parameter:

```yml
default:
    extensions:
        IMT\BehatProfilingExtension\Extension:
            use_env: BEHAT_PROFILING_ENABLED
```

```sh
$ BEHAT_PROFILING_ENABLED=true behat
```

## Testing ##

```sh
$ make test
```

## Contributing ##

Please see [CONTRIBUTING][2] for details.

## Credits

- [Igor Timoshenko][3]
- [All Contributors][4]

## License ##

This library is released under the MIT license. See the complete license in the
`LICENSE` file that is distributed with this source code.

[1]: http://getcomposer.org
[2]: https://github.com/IgorTimoshenko/behat-profiling-extension/blob/master/CONTRIBUTING.md
[3]: https://github.com/IgorTimoshenko
[4]: https://github.com/IgorTimoshenko/behat-profiling-extension/graphs/contributors
