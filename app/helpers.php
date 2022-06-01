<?php

if (! function_exists('envFromDB')) {

    function envFromDB($key, $default = null)
    {
        if(env('DB_CONNECTION') != 'mysql') {
            return env($key, $default);
        }

        if(! isset($GLOBALS['configurations'])) {
            $servername = env('DB_HOST');
            $port = env('DB_PORT');
            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');

            $conn = @new mysqli($servername, $username, $password, $database);

            if (@$conn->connect_error) {
                return env($key, $default);
            }

            $result = $conn->query("SELECT `key`, `value` FROM `configurations`");

            if (@$result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $GLOBALS['configurations'][$row['key']] = $row['value'];
                }
            }

            $conn->close();
        }

        return $GLOBALS['configurations'][$key] ?? env($key, $default);
    }

}
