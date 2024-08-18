<?php

namespace ziaadini\bidashboard\components;

class Env
{
    /**
     * Get either an env var or a default value if the var is not set.
     *
     * @param string $name the name of the variable to get
     * @param mixed $default the default value to return if variable is not set.
     * Default is `null`.
     * @param bool $required whether the var must be set. $default is ignored in
     * this case. Default is `false`.
     * @return mixed the content of the environment variable or $default if not set
     */
    public static function get($name, $default = null, $required = false)
    {
        if (array_key_exists($name, $_ENV)) {
            $value = $_ENV[$name];
        } elseif (array_key_exists($name, $_SERVER)) {
            $value = $_SERVER[$name];
        } else {
            $value = getenv($name);
        }

        if ($value === false && $required) {
            throw new \Exception("Environment variable '$name' is not set");
        }

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return;
        }

        return $value;
    }
}
